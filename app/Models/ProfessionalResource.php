<?php

namespace App\Models;

use App\Concerns\HasTranslations;
use Database\Factories\ProfessionalResourceFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

#[Fillable([
    'slug',
    'title_ro',
    'title_en',
    'description_ro',
    'description_en',
    'category',
    'type',
    'file_size',
    'is_published',
    'last_updated_at',
])]
class ProfessionalResource extends Model implements HasMedia
{
    /** @use HasFactory<ProfessionalResourceFactory> */
    use HasFactory;
    use HasTranslations;
    use InteractsWithMedia;

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'last_updated_at' => 'datetime',
        ];
    }

    /**
     * @param  Builder<ProfessionalResource> $query
     * @return Builder<ProfessionalResource>
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

    public function getDescriptionAttribute(): ?string
    {
        return $this->getTranslated('description');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('file')->singleFile();
    }

    public function getFileUrlAttribute(): ?string
    {
        return $this->getFirstMediaUrl('file') ?: null;
    }
}
