<?php

namespace App\Models;

use App\Concerns\HasTranslations;
use App\Enums\ResourceStatus;
use App\Enums\ResourceType;
use Database\Factories\ProfessionalResourceFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

#[Fillable([
    'slug',
    'title_ro',
    'title_en',
    'description_ro',
    'description_en',
    'body_ro',
    'body_en',
    'type',
    'resource_category_id',
    'tags',
    'author',
    'download_url',
    'video_url',
    'featured',
    'access_levels',
    'status',
    'published_at',
])]
class ProfessionalResource extends Model implements HasMedia
{
    /** @use HasFactory<ProfessionalResourceFactory> */
    use HasFactory;

    use HasTranslations;
    use InteractsWithMedia;

    protected static function booted(): void
    {
        static::saving(function (ProfessionalResource $resource): void {
            if ($resource->status === ResourceStatus::Published && $resource->published_at === null) {
                $resource->published_at = now();
            }
        });
    }

    protected function casts(): array
    {
        return [
            'type' => ResourceType::class,
            'status' => ResourceStatus::class,
            'tags' => 'array',
            'featured' => 'boolean',
            'access_levels' => 'array',
            'published_at' => 'datetime',
        ];
    }

    /** @return BelongsTo<ResourceCategory, $this> */
    public function resourceCategory(): BelongsTo
    {
        return $this->belongsTo(ResourceCategory::class);
    }

    /**
     * @param  Builder<ProfessionalResource>  $query
     * @return Builder<ProfessionalResource>
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->where('status', ResourceStatus::Published)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
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

    public function getBodyAttribute(): ?string
    {
        return $this->getTranslated('body');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('file')
            ->singleFile()
            ->useDisk('public');
    }

    public function getFileUrlAttribute(): ?string
    {
        return $this->getFirstMediaUrl('file') ?: null;
    }
}
