<?php

namespace Database\Factories;

use App\Models\ResourceCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<ResourceCategory>
 */
class ResourceCategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->words(3, true);

        return [
            'slug' => Str::slug($name),
            'name_ro' => $name,
            'name_en' => $name,
            'color_bg' => fake()->hexColor(),
            'color_text' => fake()->hexColor(),
            'color_border' => fake()->hexColor(),
            'sort_order' => fake()->numberBetween(0, 100),
        ];
    }
}
