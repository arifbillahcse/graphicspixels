<?php

namespace App\Models;

use App\Enums\Department;
use App\Enums\RoleName;
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
