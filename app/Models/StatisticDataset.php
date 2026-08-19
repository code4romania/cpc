<?php

namespace App\Models;

use App\Concerns\HasTranslations;
use App\Enums\ChartType;
use Database\Factories\StatisticDatasetFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'slug',
    'chart_type',
    'title_ro',
    'title_en',
    'description_ro',
    'description_en',
    'narrative_ro',
    'narrative_en',
    'is_published',
    'published_at',
    'sort_order',
])]
class StatisticDataset extends Model
{
    /** @use HasFactory<StatisticDatasetFactory> */
    use HasFactory;
    use HasTranslations;

    protected function casts(): array
    {
        return [
            'chart_type' => ChartType::class,
            'is_published' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    /** @return HasMany<StatisticDataPoint, $this> */
    public function dataPoints(): HasMany
    {
        return $this->hasMany(StatisticDataPoint::class);
    }

    /**
     * @param  Builder<StatisticDataset> $query
     * @return Builder<StatisticDataset>
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

    public function getNarrativeAttribute(): ?string
    {
        return $this->getTranslated('narrative');
    }
}
