<?php

namespace Database\Factories;

use App\Enums\ResourceType;
use App\Enums\SubmissionStatus;
use App\Models\ResourceSubmission;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ResourceSubmission>
 */
class ResourceSubmissionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(5),
            'description' => fake()->paragraphs(2, true),
            'type' => fake()->randomElement(ResourceType::cases())->value,
            'category' => fake()->words(2, true),
            'submitter_name' => fake()->name(),
            'submitter_email' => fake()->safeEmail(),
            'submitter_organization' => fake()->optional()->company(),
            'external_url' => fake()->optional()->url(),
            'locale' => fake()->randomElement(['ro', 'en']),
            'status' => SubmissionStatus::Pending->value,
            'rejection_reason' => null,
            'reviewed_by' => null,
            'reviewed_at' => null,
            'resource_id' => null,
        ];
    }
}
