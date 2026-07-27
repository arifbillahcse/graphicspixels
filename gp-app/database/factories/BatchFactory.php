<?php

namespace Database\Factories;

use App\Enums\BatchStatus;
use App\Models\Batch;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Batch>
 */
class BatchFactory extends Factory
{
    protected $model = Batch::class;

    public function definition(): array
    {
        return [
            'order_id' => Order::factory(),
            'batch_number' => 1,
            'image_count' => fake()->numberBetween(5, 100),
            'status' => BatchStatus::Pending->value,
        ];
    }

    public function status(BatchStatus $status): static
    {
        return $this->state(fn () => ['status' => $status->value]);
    }

    public function editedBy(User $editor): static
    {
        return $this->state(fn () => ['editor_id' => $editor->id]);
    }

    public function number(int $number): static
    {
        return $this->state(fn () => ['batch_number' => $number]);
    }
}
