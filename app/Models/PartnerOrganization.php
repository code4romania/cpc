<?php

namespace App\Models;

use App\Concerns\HasTranslations;
use Database\Factories\PartnerOrganizationFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

#[Fillable([
    'name',
    'description_ro',
    'description_en',
    'url',
    'sort_order',
    'is_published',
])]
class PartnerOrganization extends Model implements HasMedia
{
    /** @use HasFactory<PartnerOrganizationFactory> */
    use HasFactory;
    use HasTranslations;
    use InteractsWithMedia;

    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
        ];
    }

    /**
     * @param  Builder<PartnerOrganization> $query
     * @return Builder<PartnerOrganization>
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query
            ->where('is_published', true)
            ->orderBy('sort_order');
    }

    public function getDescriptionAttribute(): ?string
    {
        return $this->getTranslated('description');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('logo')->singleFile();
    }

    public function getLogoUrlAttribute(): ?string
    {
        return $this->getFirstMediaUrl('logo') ?: null;
    }
}
