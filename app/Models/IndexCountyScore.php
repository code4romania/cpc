<?php

namespace App\Models;

use App\Enums\IndexType;
use Database\Factories\IndexCountyScoreFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'index_type',
    'county_id',
    'score',
    'year',
])]
class IndexCountyScore extends Model
{
    /** @use HasFactory<IndexCountyScoreFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'index_type' => IndexType::class,
            'score' => 'float',
        ];
    }

    /** @return BelongsTo<County, $this> */
    public function county(): BelongsTo
    {
        return $this->belongsTo(County::class);
    }
}
