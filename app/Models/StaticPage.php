<?php

namespace App\Models;

use App\Concerns\HasTranslations;
use Database\Factories\StaticPageFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'slug',
    'title_ro',
    'title_en',
    'body_ro',
    'body_en',
    'blocks',
    'is_published',
])]
class StaticPage extends Model
{
    /**
     * Pages an administrator may edit. New pages cannot be added.
     *
     * @var list<string>
     */
    public const MANAGED_SLUGS = [
        'terms',
        'privacy',
        'home',
        'about',
        'contact',
    ];

    /** @use HasFactory<StaticPageFactory> */
    use HasFactory;

    use HasTranslations;

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'blocks' => 'array',
        ];
    }

    /**
     * @param  Builder<StaticPage>  $query
     * @return Builder<StaticPage>
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getTitleAttribute(): ?string
    {
        return $this->getTranslated('title');
    }

    public function getBodyAttribute(): ?string
    {
        return $this->getTranslated('body');
    }

    public function text(string $key, string $fallback): string
    {
        $value = $this->block($key);

        if ($value !== null) {
            return $value;
        }

        $translated = __($fallback);

        return is_string($translated) ? $translated : '';
    }

    /**
     * @return list<string>
     */
    public function lines(string $key, string $fallback): array
    {
        $value = $this->block($key);

        if ($value !== null) {
            return array_values(array_filter(array_map(trim(...), explode("\n", $value))));
        }

        $translated = __($fallback);

        return is_array($translated) ? array_values(array_map(strval(...), $translated)) : [];
    }

    private function block(string $key): ?string
    {
        $blocks = $this->blocks ?? [];
        $localized = $blocks[$key] ?? null;

        if (! is_array($localized) || ! array_key_exists(app()->getLocale(), $localized)) {
            return null;
        }

        $value = $localized[app()->getLocale()];

        return is_string($value) ? $value : null;
    }
}
