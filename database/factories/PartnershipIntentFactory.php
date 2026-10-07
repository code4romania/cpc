<?php

namespace Database\Factories;

use App\Enums\PartnershipEntityType;
use App\Models\PartnershipIntent;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PartnershipIntent>
 */
class PartnershipIntentFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'entity_name' => fake()->company(),
            'entity_type' => fake()->randomElement(PartnershipEntityType::cases()),
            'activity_domain' => fake()->words(3, true),
            'contact_name' => fake()->name(),
            'contact_role' => fake()->jobTitle(),
            'phone' => fake()->phoneNumber(),
            'email' => fake()->safeEmail(),
            'intent' => fake()->paragraph(),
            'personal_data_consent' => true,
            'locale' => 'ro',
        ];
    }
}
