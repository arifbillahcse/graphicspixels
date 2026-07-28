<?php

namespace App\Models;

use App\Enums\QcSeverity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QcComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'qc_review_id',
        'comment',
        'severity',
    ];

    protected function casts(): array
    {
        return [
            'severity' => QcSeverity::class,
        ];
    }

    public function review(): BelongsTo
    {
        return $this->belongsTo(QcReview::class, 'qc_review_id');
    }

    public function isBlocker(): bool
    {
        return $this->severity === QcSeverity::Blocker;
    }
}
