<?php

namespace Database\Factories;

use App\Enums\IndexType;
use App\Models\County;
use App\Models\IndexCountyScore;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<IndexCountyScore>
 */
class IndexCountyScoreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'index_type' => fake()->randomElement(IndexType::cases())->value,
            'county_id' => County::factory(),
            'score' => fake()->randomFloat(2, 0, 100),
            'year' => fake()->numberBetween(2019, 2026),
        ];
    }
}
