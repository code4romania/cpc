<?php

namespace App\Models;

use App\Concerns\HasTranslations;
use App\Enums\OrganizationType;
use Database\Factories\OrganizationFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'name',
    'description_ro',
    'description_en',
    'city',
    'county_id',
    'organization_type',
    'services',
    'phone',
    'email',
    'website',
    'hours',
    'address',
    'is_published',
])]
class Organization extends Model
{
    /** @use HasFactory<OrganizationFactory> */
    use HasFactory;
    use HasTranslations;

    protected function casts(): array
    {
        return [
            'organization_type' => OrganizationType::class,
            'services' => 'array',
            'is_published' => 'boolean',
        ];
    }

    /** @return BelongsTo<County, $this> */
    public function county(): BelongsTo
    {
        return $this->belongsTo(County::class);
    }

    /**
     * @param  Builder<Organization> $query
     * @return Builder<Organization>
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_published', true);
    }

    public function getDescriptionAttribute(): ?string
    {
        return $this->getTranslated('description');
    }
}
