<?php

namespace Database\Factories;

use App\Enums\OrganizationType;
use App\Models\County;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Organization>
 */
class OrganizationFactory extends Factory
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
            'description_ro' => fake()->paragraph(),
            'description_en' => fake()->paragraph(),
            'city' => fake()->city(),
            'county_id' => County::factory(),
            'organization_type' => fake()->randomElement(OrganizationType::cases())->value,
            'services' => fake()->randomElements([
                'Advocacy',
                'Management de caz',
                'Servicii medicale',
                'Training și educație',
            ], fake()->numberBetween(1, 3)),
            'phone' => fake()->phoneNumber(),
            'email' => fake()->companyEmail(),
            'website' => fake()->optional()->url(),
            'hours' => 'Luni-Vineri 09:00-17:00',
            'address' => fake()->address(),
            'is_published' => fake()->boolean(90),
        ];
    }
}
