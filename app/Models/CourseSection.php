<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseSection extends Model
{
    protected $fillable = ['eyebrow', 'title', 'empty_text', 'button_text', 'button_url'];

    protected $attributes = [
        'eyebrow' => 'Cursos',
        'title' => 'Únete a nuestros cursos que tenemos para ti.',
        'empty_text' => 'Próximamente publicaremos nuevos cursos.',
    ];

    public static function current(): self
    {
        return static::find(1) ?? new static;
    }

    public function getPublicUrlAttribute(): ?string
    {
        return $this->button_url && preg_match('~^https?://~i', $this->button_url)
            ? $this->button_url
            : null;
    }
}
