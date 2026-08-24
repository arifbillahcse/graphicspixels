<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * A user's explicit choice for one notification type.
 *
 * Rows are only written when somebody changes something: no row means "use the
 * catalog default", which keeps new notification types working for existing
 * users without a backfill.
 */
class NotificationPreference extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'notification_key',
        'email',
        'in_app',
    ];

    protected function casts(): array
    {
        return [
            'email' => 'boolean',
            'in_app' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Shape expected by ChannelResolver.
     *
     * @return array{email:bool,in_app:bool}
     */
    public function toChannelPreference(): array
    {
        return ['email' => $this->email, 'in_app' => $this->in_app];
    }
}
