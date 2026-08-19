<?php

namespace Database\Factories;

use App\Enums\ResourceStatus;
use App\Enums\ResourceType;
use App\Models\Resource;
use App\Models\ResourceCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<resource>
 */
class ResourceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->unique()->sentence(5);
        $isPublished = fake()->boolean(80);

        return [
            'slug' => Str::slug($title),
            'title_ro' => $title,
            'title_en' => $title,
            'description_ro' => fake()->paragraphs(2, true),
            'description_en' => fake()->paragraphs(2, true),
            'type' => fake()->randomElement(ResourceType::cases())->value,
            'resource_category_id' => ResourceCategory::factory(),
            'tags' => fake()->words(3),
            'author' => fake()->name(),
            'download_url' => fake()->optional()->url(),
            'video_url' => null,
            'file_path' => null,
            'featured' => fake()->boolean(20),
            'status' => $isPublished ? ResourceStatus::Published->value : ResourceStatus::Draft->value,
            'published_at' => $isPublished ? fake()->dateTimeBetween('-2 years') : null,
        ];
    }
}
