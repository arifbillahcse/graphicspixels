<?php

namespace Database\Factories;

use App\Enums\LeadSource;
use App\Enums\LeadStatus;
use App\Models\Lead;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Lead>
 */
class LeadFactory extends Factory
{
    protected $model = Lead::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->optional()->phoneNumber(),
            'website' => fake()->optional()->url(),
            'company' => fake()->optional()->company(),
            'service' => fake()->randomElement([
                'Clipping Path',
                'Photo Retouching',
                'Ghost Mannequin',
                'Colour Correction',
                'Image Masking',
            ]),
            'message' => fake()->optional()->paragraph(),
            'status' => LeadStatus::New->value,
            'source' => LeadSource::FreeTrial->value,
            'assigned_to' => null,
            'wp_entry_id' => null,
            'submitted_at' => now(),
        ];
    }

    public function status(LeadStatus $status): static
    {
        return $this->state(fn () => ['status' => $status->value]);
    }

    public function fromContactForm(): static
    {
        return $this->state(fn () => [
            'source' => LeadSource::Contact->value,
            'website' => null,
        ]);
    }
}
