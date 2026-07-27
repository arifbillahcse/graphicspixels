<?php

namespace App\Models;

use App\Enums\RateTier;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'company',
        'website',
        'rate_tier',
        'lead_id',
        'account_manager_id',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'rate_tier' => RateTier::class,
        ];
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }

    public function accountManager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'account_manager_id');
    }

    /**
     * Find or create the client behind a converted lead.
     *
     * Email is the identity: a repeat customer who enquires again through the
     * website should attach to their existing client record rather than
     * creating a duplicate.
     */
    public static function fromLead(Lead $lead): self
    {
        $client = self::firstOrNew(['email' => $lead->email]);

        if (! $client->exists) {
            $client->fill([
                'name' => $lead->name,
                'phone' => $lead->phone,
                'company' => $lead->company,
                'website' => $lead->website,
                'rate_tier' => RateTier::Standard->value,
                'lead_id' => $lead->id,
                'account_manager_id' => $lead->assigned_to,
            ]);

            $client->save();
        }

        return $client;
    }

    public function displayName(): string
    {
        return $this->company ? "{$this->name} ({$this->company})" : $this->name;
    }
}
