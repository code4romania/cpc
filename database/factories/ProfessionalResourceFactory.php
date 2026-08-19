<?php

namespace Database\Factories;

use App\Models\ProfessionalResource;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<ProfessionalResource>
 */
class ProfessionalResourceFactory extends Factory
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
            'title_ro' => $title,
            'title_en' => $title,
            'description_ro' => fake()->paragraph(),
            'description_en' => fake()->paragraph(),
            'category' => fake()->randomElement(['Investigation', 'Case Management', 'Legal']),
            'type' => fake()->randomElement(['PDF Guide', 'Template Pack', 'Video Series']),
            'file_path' => null,
            'file_size' => fake()->randomFloat(1, 1, 250) . ' MB',
            'is_published' => true,
            'last_updated_at' => fake()->dateTimeBetween('-1 year'),
        ];
    }
}
