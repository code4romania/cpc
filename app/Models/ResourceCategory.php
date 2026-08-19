<?php

namespace App\Models;

use App\Concerns\HasTranslations;
use Database\Factories\ResourceCategoryFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'slug',
    'name_ro',
    'name_en',
    'color_bg',
    'color_text',
    'color_border',
    'sort_order',
])]
class ResourceCategory extends Model
{
    /** @use HasFactory<ResourceCategoryFactory> */
    use HasFactory;
    use HasTranslations;

    /** @return HasMany<\App\Models\Resource, $this> */
    public function resources(): HasMany
    {
        return $this->hasMany(Resource::class);
    }

    public function getNameAttribute(): ?string
    {
        return $this->getTranslated('name');
    }
}
