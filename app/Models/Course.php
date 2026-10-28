<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Course extends Model
{
    protected $fillable = [
        'title', 'description', 'image', 'image_alt', 'category', 'instructor',
        'instructor_image', 'lessons_count', 'lessons_label', 'students_count',
        'students_label', 'rating', 'reviews_count', 'reviews_label', 'price',
        'original_price', 'currency', 'badge_text', 'badge_caption', 'button_text',
        'button_url', 'is_published', 'sort_order',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'price' => 'decimal:2',
        'original_price' => 'decimal:2',
        'lessons_count' => 'integer',
        'students_count' => 'integer',
        'rating' => 'integer',
        'reviews_count' => 'integer',
        'sort_order' => 'integer',
    ];

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true)->orderBy('sort_order')->orderBy('id');
    }

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? Storage::disk('public')->url($this->image) : null;
    }

    public function getInstructorImageUrlAttribute(): ?string
    {
        return $this->instructor_image ? Storage::disk('public')->url($this->instructor_image) : null;
    }

    public function getPublicUrlAttribute(): string
    {
        // Only allow web links; never render executable schemes in public markup.
        return $this->button_url && preg_match('~^https?://~i', $this->button_url)
            ? $this->button_url
            : route('contactanos');
    }
}
