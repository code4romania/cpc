<?php

namespace Database\Factories;

use App\Models\PartnerOrganization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PartnerOrganization>
 */
class PartnerOrganizationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->company(),
            'logo_path' => null,
            'description_ro' => fake()->sentence(),
            'description_en' => fake()->sentence(),
            'url' => fake()->url(),
            'sort_order' => fake()->numberBetween(0, 100),
            'is_published' => true,
        ];
    }
}
