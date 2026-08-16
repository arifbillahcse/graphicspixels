<?php

namespace App\Models;

use App\Enums\Department;
use App\Enums\LeaveStatus;
use App\Enums\RoleName;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, HasRoles, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'department',
        'job_title',
        'team_leader_id',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'department' => Department::class,
            'is_active' => 'boolean',
        ];
    }

    /**
     * The team leader this user reports to (editors only).
     */
    public function teamLeader(): BelongsTo
    {
        return $this->belongsTo(self::class, 'team_leader_id');
    }

    /**
     * Editors reporting to this user (team leaders only).
     */
    public function teamMembers(): HasMany
    {
        return $this->hasMany(self::class, 'team_leader_id');
    }

    /**
     * Leads currently assigned to this user.
     */
    public function assignedLeads(): HasMany
    {
        return $this->hasMany(Lead::class, 'assigned_to');
    }

    /**
     * Orders this user is the responsible team leader for.
     */
    public function managedOrders(): HasMany
    {
        return $this->hasMany(Order::class, 'team_leader_id');
    }

    /**
     * Batches assigned to this user as the editor.
     */
    public function batches(): HasMany
    {
        return $this->hasMany(Batch::class, 'editor_id');
    }

    /**
     * How much unfinished work this editor is carrying, used to balance new
     * batch assignments.
     */
    public function openBatchCount(): int
    {
        return $this->batches()->open()->count();
    }

    public function leaveRequests(): HasMany
    {
        return $this->hasMany(LeaveRequest::class)->latest('starts_on');
    }

    /**
     * Whether approved leave covers the given day.
     */
    public function isOnLeaveOn(?string $date = null): bool
    {
        $date ??= now()->toDateString();

        return $this->leaveRequests()
            ->approved()
            ->where('starts_on', '<=', $date)
            ->where('ends_on', '>=', $date)
            ->exists();
    }

    /**
     * Staff who are not on approved leave on the given day.
     *
     * Only approved leave removes somebody from the pool — a pending request
     * must not quietly stop work being assigned to them.
     */
    public function scopeAvailableOn(Builder $query, ?string $date = null): Builder
    {
        $date ??= now()->toDateString();

        return $query->whereDoesntHave('leaveRequests', function (Builder $leave) use ($date) {
            $leave->where('status', LeaveStatus::Approved->value)
                ->where('starts_on', '<=', $date)
                ->where('ends_on', '>=', $date);
        });
    }

    /**
     * Primary role as an enum, or null when the user has no recognised role.
     * Users are seeded with exactly one role; if that ever changes, the first
     * assigned role wins for routing purposes.
     */
    public function primaryRole(): ?RoleName
    {
        $name = $this->getRoleNames()->first();

        return $name ? RoleName::tryFrom($name) : null;
    }

    /**
     * Named route this user should land on after logging in.
     */
    public function dashboardRoute(): string
    {
        return $this->primaryRole()?->dashboardRoute() ?? 'dashboard';
    }

    public function isAdmin(): bool
    {
        return $this->primaryRole() === RoleName::Admin;
    }
}
