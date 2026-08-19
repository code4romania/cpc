<?php

namespace Database\Factories;

use App\Enums\ChartType;
use App\Models\StatisticDataset;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<StatisticDataset>
 */
class StatisticDatasetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->unique()->sentence(5);

        return [
            'slug' => Str::slug($title),
            'chart_type' => fake()->randomElement(ChartType::cases())->value,
            'title_ro' => $title,
            'title_en' => $title,
            'description_ro' => fake()->sentence(),
            'description_en' => fake()->sentence(),
            'narrative_ro' => fake()->paragraphs(2, true),
            'narrative_en' => fake()->paragraphs(2, true),
            'is_published' => true,
            'published_at' => fake()->dateTimeBetween('-1 year'),
            'sort_order' => fake()->numberBetween(0, 100),
        ];
    }
}
