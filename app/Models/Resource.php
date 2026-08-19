<?php

namespace App\Models;

use App\Concerns\HasTranslations;
use App\Enums\ResourceStatus;
use App\Enums\ResourceType;
use Database\Factories\ResourceFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'slug',
    'title_ro',
    'title_en',
    'description_ro',
    'description_en',
    'type',
    'resource_category_id',
    'tags',
    'author',
    'download_url',
    'video_url',
    'file_path',
    'featured',
    'status',
    'published_at',
])]
class Resource extends Model
{
    /** @use HasFactory<ResourceFactory> */
    use HasFactory;
    use HasTranslations;

    protected function casts(): array
    {
        return [
            'type' => ResourceType::class,
            'status' => ResourceStatus::class,
            'tags' => 'array',
            'featured' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    public function resourceCategory(): BelongsTo
    {
        return $this->belongsTo(ResourceCategory::class);
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->where('status', ResourceStatus::Published)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function scopeFeatured(Builder $query): Builder
    {
        return $query->where('featured', true);
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getTitleAttribute(): ?string
    {
        return $this->getTranslated('title');
    }

    public function getDescriptionAttribute(): ?string
    {
        return $this->getTranslated('description');
    }
}
