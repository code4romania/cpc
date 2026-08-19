<?php

namespace Database\Factories;

use App\Models\County;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<County>
 */
class CountyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => fake()->unique()->lexify('??'),
            'name_ro' => fake()->city(),
            'name_en' => fake()->city(),
        ];
    }
}
