<?php

namespace Database\Factories;

use App\Enums\LeaveStatus;
use App\Enums\LeaveType;
use App\Models\LeaveRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<LeaveRequest>
 */
class LeaveRequestFactory extends Factory
{
    protected $model = LeaveRequest::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'type' => LeaveType::Annual->value,
            'starts_on' => now()->toDateString(),
            'ends_on' => now()->addDays(2)->toDateString(),
            'status' => LeaveStatus::Pending->value,
        ];
    }

    public function status(LeaveStatus $status): static
    {
        return $this->state(fn () => ['status' => $status->value]);
    }

    public function approved(): static
    {
        return $this->status(LeaveStatus::Approved);
    }

    /**
     * Leave that covers today, so it affects availability right now.
     */
    public function coveringToday(): static
    {
        return $this->state(fn () => [
            'starts_on' => now()->subDay()->toDateString(),
            'ends_on' => now()->addDay()->toDateString(),
        ]);
    }

    public function between(string $start, string $end): static
    {
        return $this->state(fn () => ['starts_on' => $start, 'ends_on' => $end]);
    }
}
