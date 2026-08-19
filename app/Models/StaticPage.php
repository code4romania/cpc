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
    'is_published',
])]
class StaticPage extends Model
{
    /** @use HasFactory<StaticPageFactory> */
    use HasFactory;
    use HasTranslations;

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
        ];
    }

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
}
