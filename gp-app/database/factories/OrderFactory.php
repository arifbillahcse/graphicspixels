<?php

namespace Database\Factories;

use App\Enums\OrderStatus;
use App\Enums\ServiceType;
use App\Models\Client;
use App\Models\Order;
use App\Models\User;
use App\Support\OrderReference;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        $received = now();

        return [
            'reference' => OrderReference::format($this->faker->unique()->numberBetween(1, 99999)),
            'client_id' => Client::factory(),
            'service_type' => fake()->randomElement(ServiceType::values()),
            'image_count' => fake()->numberBetween(10, 500),
            'status' => OrderStatus::Received->value,
            'rush' => false,
            'received_at' => $received,
            'deadline' => $received->copy()->addHours(Order::STANDARD_SLA_HOURS),
        ];
    }

    public function status(OrderStatus $status): static
    {
        return $this->state(fn () => ['status' => $status->value]);
    }

    public function ledBy(User $leader): static
    {
        return $this->state(fn () => [
            'team_leader_id' => $leader->id,
            'status' => OrderStatus::Assigned->value,
        ]);
    }

    public function images(int $count): static
    {
        return $this->state(fn () => ['image_count' => $count]);
    }

    /**
     * An order whose deadline is a given number of minutes away, for exercising
     * the SLA bands.
     */
    public function dueInMinutes(int $minutes): static
    {
        return $this->state(fn () => [
            'received_at' => now()->subHours(Order::STANDARD_SLA_HOURS)->addMinutes($minutes),
            'deadline' => now()->addMinutes($minutes),
        ]);
    }
}
