<?php

namespace Database\Factories;

use App\Models\StatisticDataPoint;
use App\Models\StatisticDataset;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<StatisticDataPoint>
 */
class StatisticDataPointFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $label = fake()->word();

        return [
            'statistic_dataset_id' => StatisticDataset::factory(),
            'label_ro' => $label,
            'label_en' => $label,
            'value' => fake()->randomFloat(2, 0, 1000),
            'group_key' => fake()->optional()->word(),
            'metadata' => null,
            'sort_order' => fake()->numberBetween(0, 100),
        ];
    }
}
