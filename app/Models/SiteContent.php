<?php

namespace App\Models;

use App\Support\SiteContentDefaults;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class SiteContent extends Model
{
    protected $fillable = ['name', 'content'];

    protected $casts = ['content' => 'array'];

    public static function current(): self
    {
        if (! Schema::hasTable('site_contents')) {
            return (new static)->forceFill([
                'id' => 1,
                'name' => 'Contenido principal',
                'content' => SiteContentDefaults::content(),
            ]);
        }

        $content = static::query()->find(1);
        if ($content) {
            return $content;
        }

        SiteContentDefaults::prepareAssets();

        return static::query()->forceCreate([
            'id' => 1,
            'name' => 'Contenido principal',
            'content' => SiteContentDefaults::content(),
        ]);
    }

    public function value(string $key, mixed $default = null): mixed
    {
        $missing = new \stdClass;
        $value = data_get($this->content, $key, $missing);

        return $value === $missing ? data_get(SiteContentDefaults::content(), $key, $default) : $value;
    }

    public function services(): array
    {
        return collect($this->value('services', []))
            ->filter(fn (array $service): bool => ($service['is_active'] ?? true) && filled($service['slug'] ?? null))
            ->mapWithKeys(fn (array $service): array => [$service['slug'] => $service])
            ->all();
    }

    public function clients(): array
    {
        return collect($this->value('clients', []))
            ->filter(fn (array $client): bool => ($client['is_active'] ?? true) && filled($client['logo'] ?? null))
            ->values()->all();
    }

    public function standards(): array
    {
        return collect($this->value('standards', []))
            ->filter(fn (array $standard): bool => ($standard['is_active'] ?? true) && filled($standard['number'] ?? null))
            ->values()->all();
    }

    public function imageUrl(?string $path): ?string
    {
        if (blank($path)) {
            return null;
        }

        if (preg_match('~^https?://~i', $path)) {
            return $path;
        }

        if (str_starts_with($path, 'images/')) {
            return asset($path);
        }

        return Storage::disk('public')->url($path);
    }
}
