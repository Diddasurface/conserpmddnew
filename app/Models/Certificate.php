<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class Certificate extends Model
{
    public const STATUSES = ['draft' => 'Borrador', 'valid' => 'Válido', 'revoked' => 'Revocado'];

    protected $fillable = [
        'course_id', 'recipient_name', 'training_title', 'issued_at', 'expires_at',
        'hours', 'evidence_image', 'public_notes', 'status',
    ];

    protected $casts = ['issued_at' => 'date', 'expires_at' => 'date', 'hours' => 'decimal:2'];

    protected static function booted(): void
    {
        static::creating(function (self $certificate): void {
            $certificate->code = 'CMDD-'.Str::ulid();
        });

        static::updating(function (self $certificate): void {
            if ($certificate->isDirty('code')) {
                throw ValidationException::withMessages(['code' => 'El código de verificación no se puede cambiar.']);
            }
        });
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function scopePubliclyVisible(Builder $query): Builder
    {
        return $query->whereIn('status', ['valid', 'revoked']);
    }

    public function getVerificationStatusAttribute(): string
    {
        if ($this->status === 'valid' && $this->expires_at?->lt(today())) {
            return 'expired';
        }

        return $this->status;
    }

    public function getStatusLabelAttribute(): string
    {
        return $this->verification_status === 'expired' ? 'Vencido' : (self::STATUSES[$this->status] ?? 'No válido');
    }

    public function getVerificationUrlAttribute(): string
    {
        return rtrim(config('certificates.public_url'), '/').route('certificates.show', ['code' => $this->code], false);
    }
}
