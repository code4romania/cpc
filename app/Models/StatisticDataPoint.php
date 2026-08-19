<?php

namespace App\Models;

use App\Concerns\HasTranslations;
use Database\Factories\StatisticDataPointFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'statistic_dataset_id',
    'label_ro',
    'label_en',
    'value',
    'group_key',
    'metadata',
    'sort_order',
])]
class StatisticDataPoint extends Model
{
    /** @use HasFactory<StatisticDataPointFactory> */
    use HasFactory;
    use HasTranslations;

    protected function casts(): array
    {
        return [
            'value' => 'float',
            'metadata' => 'array',
        ];
    }

    /** @return BelongsTo<StatisticDataset, $this> */
    public function dataset(): BelongsTo
    {
        return $this->belongsTo(StatisticDataset::class, 'statistic_dataset_id');
    }

    public function getLabelAttribute(): ?string
    {
        return $this->getTranslated('label');
    }
}
