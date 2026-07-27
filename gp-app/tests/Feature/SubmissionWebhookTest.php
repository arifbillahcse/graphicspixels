<?php

namespace Tests\Feature;

use App\Enums\ActivityAction;
use App\Enums\LeadSource;
use App\Enums\LeadStatus;
use App\Jobs\FetchLeadAttachment;
use App\Models\Lead;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

/**
 * Covers POST /api/submissions against the payloads the WordPress theme
 * actually sends from gp_forward_to_app().
 */
class SubmissionWebhookTest extends TestCase
{
    use RefreshDatabase;

    private const KEY = 'test-webhook-key';

    protected function setUp(): void
    {
        parent::setUp();

        config(['graphicspixels.webhook.key' => self::KEY]);
    }

    /**
     * The exact shape the free-trial form forwards.
     */
    private function trialPayload(array $overrides = []): array
    {
        return array_merge([
            'name' => 'Jane Buyer',
            'email' => 'Jane@Example.COM',
            'phone' => '+44 7700 900123',
            'website' => 'https://example.com',
            'service' => 'Clipping Path',
            'message' => 'Please quote for 500 images.',
            'file_link' => 'https://drive.google.com/folder/abc',
            'form' => 'Free Trial Request',
            'submitted_at' => '2026-07-27T10:15:00+06:00',
            'wp_entry_id' => 4021,
        ], $overrides);
    }

    /**
     * The contact form sends company instead of website, and no file_link.
     */
    private function contactPayload(array $overrides = []): array
    {
        return array_merge([
            'name' => 'Mark Retailer',
            'email' => 'mark@shop.test',
            'phone' => '',
            'company' => 'Shop Ltd',
            'service' => 'Photo Retouching',
            'message' => 'Do you handle jewellery?',
            'form' => 'Contact Message',
            'submitted_at' => '2026-07-27T11:00:00+06:00',
            'wp_entry_id' => 4022,
        ], $overrides);
    }

    private function post(array $payload, ?string $key = self::KEY)
    {
        $headers = $key === null ? [] : ['Authorization' => 'Bearer '.$key];

        return $this->postJson('/api/submissions', $payload, $headers);
    }

    public function test_it_rejects_a_request_with_no_token(): void
    {
        $this->post($this->trialPayload(), null)->assertStatus(401);

        $this->assertDatabaseCount('leads', 0);
    }

    public function test_it_rejects_a_request_with_the_wrong_token(): void
    {
        $this->post($this->trialPayload(), 'not-the-key')->assertStatus(401);

        $this->assertDatabaseCount('leads', 0);
    }

    public function test_it_refuses_to_run_when_no_key_is_configured(): void
    {
        config(['graphicspixels.webhook.key' => null]);

        $this->post($this->trialPayload(), 'anything')->assertStatus(503);

        $this->assertDatabaseCount('leads', 0);
    }

    public function test_it_stores_a_free_trial_submission(): void
    {
        $response = $this->post($this->trialPayload());

        $response->assertStatus(201)->assertJson([
            'ok' => true,
            'duplicate' => false,
            'status' => LeadStatus::New->value,
            'source' => LeadSource::FreeTrial->value,
        ]);

        $lead = Lead::sole();

        $this->assertSame('Jane Buyer', $lead->name);
        $this->assertSame('jane@example.com', $lead->email, 'Email should be normalised to lowercase');
        $this->assertSame('https://example.com', $lead->website);
        $this->assertSame(LeadSource::FreeTrial, $lead->source);
        $this->assertSame(LeadStatus::New, $lead->status);
        $this->assertSame(4021, $lead->wp_entry_id);
        $this->assertNotNull($lead->submitted_at);
    }

    public function test_it_stores_a_contact_submission(): void
    {
        $this->post($this->contactPayload())->assertStatus(201);

        $lead = Lead::sole();

        $this->assertSame(LeadSource::Contact, $lead->source);
        $this->assertSame('Shop Ltd', $lead->company);
        $this->assertNull($lead->website);
    }

    public function test_it_converts_empty_strings_to_null(): void
    {
        // The theme forwards every field, including the ones left blank.
        $this->post($this->contactPayload(['phone' => '', 'service' => '   ']))->assertStatus(201);

        $lead = Lead::sole();

        $this->assertNull($lead->phone);
        $this->assertNull($lead->service);
    }

    public function test_it_logs_a_created_activity(): void
    {
        $this->post($this->trialPayload())->assertStatus(201);

        $activity = Lead::sole()->activities()->sole();

        $this->assertSame(ActivityAction::Created, $activity->action);
        $this->assertNull($activity->user_id, 'Webhook activity has no acting user');
    }

    public function test_a_repeated_delivery_does_not_create_a_second_lead(): void
    {
        $this->post($this->trialPayload())->assertStatus(201);

        $this->post($this->trialPayload())
            ->assertStatus(200)
            ->assertJson(['ok' => true, 'duplicate' => true]);

        $this->assertDatabaseCount('leads', 1);

        $this->assertTrue(
            Lead::sole()->activities()
                ->where('action', ActivityAction::DuplicateReceived->value)
                ->exists(),
        );
    }

    public function test_submissions_without_a_wp_entry_id_are_not_deduplicated(): void
    {
        $payload = $this->trialPayload();
        unset($payload['wp_entry_id']);

        $this->post($payload)->assertStatus(201);
        $this->post($payload)->assertStatus(201);

        $this->assertDatabaseCount('leads', 2);
    }

    public function test_it_rejects_a_payload_with_no_name_or_email(): void
    {
        $this->post(['form' => 'Contact Message'])
            ->assertStatus(422)
            ->assertJsonStructure(['ok', 'error', 'errors']);

        $this->assertDatabaseCount('leads', 0);
    }

    public function test_it_rejects_an_invalid_email(): void
    {
        $this->post($this->trialPayload(['email' => 'not-an-email']))->assertStatus(422);

        $this->assertDatabaseCount('leads', 0);
    }

    public function test_an_unknown_form_label_falls_back_to_other(): void
    {
        $this->post($this->trialPayload(['form' => 'Newsletter Signup']))->assertStatus(201);

        $this->assertSame(LeadSource::Other, Lead::sole()->source);
    }

    public function test_an_attachment_url_is_queued_for_download(): void
    {
        Queue::fake();

        $this->post($this->trialPayload([
            'attachment_url' => 'https://graphicspixels.com/wp-content/uploads/2026/07/sample.jpg',
        ]))->assertStatus(201);

        $attachment = Lead::sole()->attachments()->sole();

        $this->assertSame('pending', $attachment->status);
        $this->assertNull($attachment->path);

        Queue::assertPushed(FetchLeadAttachment::class);
    }

    public function test_a_non_http_attachment_value_is_ignored(): void
    {
        Queue::fake();

        $this->post($this->trialPayload(['attachment_url' => 'file:///etc/passwd']))->assertStatus(201);

        $this->assertSame(0, Lead::sole()->attachments()->count());

        Queue::assertNothingPushed();
    }
}
