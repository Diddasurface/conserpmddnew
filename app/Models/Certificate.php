<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class Certificate extends Model
{
    private const CODE_PREFIX = 'CSP-SST-';
    private const CODE_ALPHABET = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';

    public const STATUSES = ['draft' => 'Borrador', 'valid' => 'Válido', 'revoked' => 'Revocado'];
    public const EVIDENCE_MIME_TYPES = ['image/jpeg', 'image/png', 'image/webp', 'application/pdf'];

    // Preserve compatibility with existing records; participants now belong to the document.
    protected $attributes = ['recipient_name' => ''];
    protected $hidden = ['recipient_name'];

    protected $fillable = [
        'course_id', 'training_title', 'issued_at', 'expires_at',
        'hours', 'evidence_image', 'public_notes', 'status',
    ];

    protected $casts = ['issued_at' => 'date', 'expires_at' => 'date', 'hours' => 'decimal:2'];

    protected static function booted(): void
    {
        static::creating(function (self $certificate): void {
            $certificate->code = self::generateVerificationCode();
        });

        static::updating(function (self $certificate): void {
            if ($certificate->isDirty('code')) {
                throw ValidationException::withMessages(['code' => 'El código de verificación no se puede cambiar.']);
            }
        });
    }

    public static function generateVerificationCode(): string
    {
        do {
            $suffix = '';

            for ($position = 0; $position < 5; $position++) {
                $suffix .= self::CODE_ALPHABET[random_int(0, strlen(self::CODE_ALPHABET) - 1)];
            }

            $code = self::CODE_PREFIX.$suffix;
        } while (self::query()->where('code', $code)->exists());

        return $code;
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

    public function getEvidenceIsPdfAttribute(): bool
    {
        $disk = Storage::disk('local');

        return $disk->exists($this->evidence_image) && $disk->mimeType($this->evidence_image) === 'application/pdf';
    }
}
