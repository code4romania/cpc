<?php

namespace Database\Factories;

use App\Enums\ProfessionalRole;
use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'role' => UserRole::Professional,
            'organization' => fake()->company(),
            'professional_role' => fake()->randomElement(ProfessionalRole::cases()),
            'verified_at' => null,
            'locale' => 'ro',
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => UserRole::Admin,
            'organization' => null,
            'professional_role' => null,
            'verified_at' => now(),
        ]);
    }

    public function editor(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => UserRole::Editor,
            'organization' => null,
            'professional_role' => null,
            'verified_at' => now(),
        ]);
    }

    public function professional(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => UserRole::Professional,
            'organization' => fake()->company(),
            'professional_role' => fake()->randomElement(ProfessionalRole::cases()),
        ]);
    }

    public function verifiedProfessional(): static
    {
        return $this->professional()->state(fn (array $attributes) => [
            'verified_at' => now(),
        ]);
    }

    public function unverifiedProfessional(): static
    {
        return $this->professional()->state(fn (array $attributes) => [
            'verified_at' => null,
        ]);
    }
}
