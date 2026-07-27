<?php

namespace Tests\Feature;

use App\Enums\ActivityAction;
use App\Enums\LeadStatus;
use App\Models\Lead;
use App\Models\LeadAttachment;
use App\Models\User;
use Database\Seeders\RolePermissionSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class LeadPipelineTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([RolePermissionSeeder::class, UserSeeder::class]);
    }

    private function user(string $email): User
    {
        return User::where('email', $email)->firstOrFail();
    }

    private function marketing(): User
    {
        return $this->user('marketing1@graphicspixels.test');
    }

    private function admin(): User
    {
        return $this->user('admin@graphicspixels.test');
    }

    private function editor(): User
    {
        return $this->user('editor1@graphicspixels.test');
    }

    // ---------------------------------------------------------------- access

    public function test_guests_cannot_reach_the_pipeline(): void
    {
        $this->get(route('leads.index'))->assertRedirect('/login');
    }

    public function test_marketing_and_admin_can_view_the_pipeline(): void
    {
        $this->actingAs($this->marketing())->get(route('leads.index'))->assertOk();
        $this->actingAs($this->admin())->get(route('leads.index'))->assertOk();
    }

    public function test_editors_and_qc_staff_cannot_view_the_pipeline(): void
    {
        $this->actingAs($this->editor())->get(route('leads.index'))->assertForbidden();

        $this->actingAs($this->user('qc1@graphicspixels.test'))
            ->get(route('leads.index'))
            ->assertForbidden();
    }

    public function test_production_staff_cannot_view_a_lead(): void
    {
        $lead = Lead::factory()->create();

        $this->actingAs($this->user('production1@graphicspixels.test'))
            ->get(route('leads.show', $lead))
            ->assertForbidden();
    }

    public function test_editors_cannot_change_a_lead_status(): void
    {
        $lead = Lead::factory()->create();

        $this->actingAs($this->editor())
            ->patch(route('leads.status', $lead), ['status' => LeadStatus::Lost->value])
            ->assertForbidden();

        $this->assertSame(LeadStatus::New, $lead->fresh()->status);
    }

    // ----------------------------------------------------------------- CRUD

    public function test_marketing_can_create_a_lead(): void
    {
        $this->actingAs($this->marketing())
            ->post(route('leads.store'), [
                'name' => 'Manual Lead',
                'email' => 'manual@example.test',
                'status' => LeadStatus::New->value,
            ])
            ->assertRedirect();

        $lead = Lead::sole();

        $this->assertSame('Manual Lead', $lead->name);
        $this->assertTrue(
            $lead->activities()->where('action', ActivityAction::Created->value)->exists(),
        );
    }

    public function test_marketing_cannot_delete_a_lead_but_admin_can(): void
    {
        $lead = Lead::factory()->create();

        // leads.delete is granted to admins only.
        $this->actingAs($this->marketing())
            ->delete(route('leads.destroy', $lead))
            ->assertForbidden();

        $this->assertDatabaseCount('leads', 1);

        $this->actingAs($this->admin())
            ->delete(route('leads.destroy', $lead))
            ->assertRedirect();

        $this->assertDatabaseCount('leads', 0);
    }

    // ------------------------------------------------------------- pipeline

    public function test_changing_status_records_an_activity(): void
    {
        $lead = Lead::factory()->create();

        $this->actingAs($this->marketing())
            ->patch(route('leads.status', $lead), ['status' => LeadStatus::Contacted->value])
            ->assertRedirect();

        $lead->refresh();

        $this->assertSame(LeadStatus::Contacted, $lead->status);

        $activity = $lead->activities()
            ->where('action', ActivityAction::StatusChanged->value)
            ->sole();

        $this->assertSame('new', $activity->properties['from']);
        $this->assertSame('contacted', $activity->properties['to']);
    }

    public function test_setting_the_same_status_does_not_log_a_duplicate_entry(): void
    {
        $lead = Lead::factory()->create();

        $this->actingAs($this->marketing())
            ->patch(route('leads.status', $lead), ['status' => LeadStatus::New->value]);

        $this->assertSame(
            0,
            $lead->activities()->where('action', ActivityAction::StatusChanged->value)->count(),
        );
    }

    public function test_an_invalid_status_is_rejected(): void
    {
        $lead = Lead::factory()->create();

        $this->actingAs($this->marketing())
            ->patch(route('leads.status', $lead), ['status' => 'archived'])
            ->assertSessionHasErrors('status');

        $this->assertSame(LeadStatus::New, $lead->fresh()->status);
    }

    public function test_assigning_a_lead_records_an_activity(): void
    {
        $lead = Lead::factory()->create();
        $owner = $this->user('marketing2@graphicspixels.test');

        $this->actingAs($this->marketing())
            ->patch(route('leads.assign', $lead), ['assigned_to' => $owner->id])
            ->assertRedirect();

        $lead->refresh();

        $this->assertSame($owner->id, $lead->assigned_to);
        $this->assertTrue(
            $lead->activities()->where('action', ActivityAction::Assigned->value)->exists(),
        );
    }

    public function test_a_note_is_added_to_the_activity_log(): void
    {
        $lead = Lead::factory()->create();
        $actor = $this->marketing();

        $this->actingAs($actor)
            ->post(route('leads.notes.store', $lead), ['note' => 'Called, wants a sample batch.'])
            ->assertRedirect();

        $activity = $lead->activities()
            ->where('action', ActivityAction::NoteAdded->value)
            ->sole();

        $this->assertSame('Called, wants a sample batch.', $activity->note);
        $this->assertSame($actor->id, $activity->user_id);
    }

    public function test_bulk_status_updates_apply_to_every_selected_lead(): void
    {
        $leads = Lead::factory()->count(3)->create();

        $this->actingAs($this->marketing())
            ->post(route('leads.bulk'), [
                'action' => 'status',
                'lead_ids' => $leads->pluck('id')->all(),
                'status' => LeadStatus::Converted->value,
            ])
            ->assertRedirect();

        foreach ($leads as $lead) {
            $this->assertSame(LeadStatus::Converted, $lead->fresh()->status);
        }
    }

    public function test_editors_cannot_run_bulk_actions(): void
    {
        $leads = Lead::factory()->count(2)->create();

        $this->actingAs($this->editor())
            ->post(route('leads.bulk'), [
                'action' => 'status',
                'lead_ids' => $leads->pluck('id')->all(),
                'status' => LeadStatus::Lost->value,
            ])
            ->assertForbidden();
    }

    // ---------------------------------------------------------- attachments

    private function storedAttachment(Lead $lead): LeadAttachment
    {
        Storage::fake('local');
        Storage::disk('local')->put("leads/{$lead->id}/1-brief.pdf", 'file contents');

        return $lead->attachments()->create([
            'source_url' => 'https://example.com/brief.pdf',
            'disk' => 'local',
            'path' => "leads/{$lead->id}/1-brief.pdf",
            'filename' => 'brief.pdf',
            'status' => LeadAttachment::STATUS_STORED,
            'size' => 13,
        ]);
    }

    public function test_authorised_staff_can_download_an_attachment(): void
    {
        $lead = Lead::factory()->create();
        $attachment = $this->storedAttachment($lead);

        $this->actingAs($this->marketing())
            ->get(route('leads.attachments.download', [$lead, $attachment]))
            ->assertOk();
    }

    public function test_editors_cannot_download_an_attachment(): void
    {
        $lead = Lead::factory()->create();
        $attachment = $this->storedAttachment($lead);

        $this->actingAs($this->editor())
            ->get(route('leads.attachments.download', [$lead, $attachment]))
            ->assertForbidden();
    }

    public function test_an_attachment_cannot_be_fetched_through_another_lead(): void
    {
        $lead = Lead::factory()->create();
        $other = Lead::factory()->create();
        $attachment = $this->storedAttachment($lead);

        $this->actingAs($this->marketing())
            ->get(route('leads.attachments.download', [$other, $attachment]))
            ->assertNotFound();
    }

    public function test_a_pending_attachment_cannot_be_downloaded(): void
    {
        $lead = Lead::factory()->create();

        $attachment = $lead->attachments()->create([
            'source_url' => 'https://example.com/pending.pdf',
            'disk' => 'local',
            'status' => LeadAttachment::STATUS_PENDING,
        ]);

        $this->actingAs($this->marketing())
            ->get(route('leads.attachments.download', [$lead, $attachment]))
            ->assertNotFound();
    }
}
