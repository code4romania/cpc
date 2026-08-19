<?php

namespace App\Models;

use App\Concerns\HasTranslations;
use Database\Factories\CountyFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'code',
    'name_ro',
    'name_en',
])]
class County extends Model
{
    /** @use HasFactory<CountyFactory> */
    use HasFactory;
    use HasTranslations;

    public function organizations(): HasMany
    {
        return $this->hasMany(Organization::class);
    }

    public function indexCountyScores(): HasMany
    {
        return $this->hasMany(IndexCountyScore::class);
    }

    public function getNameAttribute(): ?string
    {
        return $this->getTranslated('name');
    }
}
