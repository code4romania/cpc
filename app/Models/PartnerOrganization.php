<?php

namespace App\Models;

use App\Concerns\HasTranslations;
use Database\Factories\PartnerOrganizationFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'name',
    'logo_path',
    'description_ro',
    'description_en',
    'url',
    'sort_order',
    'is_published',
])]
class PartnerOrganization extends Model
{
    /** @use HasFactory<PartnerOrganizationFactory> */
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
        return $query
            ->where('is_published', true)
            ->orderBy('sort_order');
    }

    public function getDescriptionAttribute(): ?string
    {
        return $this->getTranslated('description');
    }
}
