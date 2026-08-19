<?php

namespace Database\Factories;

use App\Models\StaticPage;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<StaticPage>
 */
class StaticPageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->unique()->sentence(4);

        return [
            'slug' => Str::slug($title),
            'title_ro' => $title,
            'title_en' => $title,
            'body_ro' => fake()->paragraphs(5, true),
            'body_en' => fake()->paragraphs(5, true),
            'is_published' => true,
        ];
    }
}
