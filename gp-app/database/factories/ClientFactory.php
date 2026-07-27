<?php

namespace Database\Factories;

use App\Enums\RateTier;
use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Client>
 */
class ClientFactory extends Factory
{
    protected $model = Client::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->optional()->phoneNumber(),
            'company' => fake()->company(),
            'website' => fake()->optional()->url(),
            'rate_tier' => RateTier::Standard->value,
        ];
    }

    public function tier(RateTier $tier): static
    {
        return $this->state(fn () => ['rate_tier' => $tier->value]);
    }
}
