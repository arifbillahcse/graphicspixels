<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeadAttachment extends Model
{
    use HasFactory;

    public const STATUS_PENDING = 'pending';

    public const STATUS_STORED = 'stored';

    public const STATUS_FAILED = 'failed';

    protected $fillable = [
        'lead_id',
        'source_url',
        'disk',
        'path',
        'filename',
        'mime_type',
        'size',
        'status',
        'error',
    ];

    protected function casts(): array
    {
        return [
            'size' => 'integer',
        ];
    }

    public function lead(): BelongsTo
    {
        return $this->belongsTo(Lead::class);
    }

    public function isStored(): bool
    {
        return $this->status === self::STATUS_STORED && $this->path !== null;
    }

    /**
     * Human-readable size, e.g. "1.4 MB".
     */
    public function humanSize(): string
    {
        $bytes = $this->size;

        if (! $bytes) {
            return '—';
        }

        foreach (['B', 'KB', 'MB', 'GB'] as $unit) {
            if ($bytes < 1024) {
                return round($bytes, 1).' '.$unit;
            }
            $bytes /= 1024;
        }

        return round($bytes, 1).' TB';
    }
}
