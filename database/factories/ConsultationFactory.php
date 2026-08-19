<?php

namespace Database\Factories;

use App\Enums\ConsultationStatus;
use App\Enums\ConsultationUrgency;
use App\Models\Consultation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Consultation>
 */
class ConsultationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'subject' => fake()->sentence(6),
            'description' => fake()->paragraphs(2, true),
            'urgency' => fake()->randomElement(ConsultationUrgency::cases())->value,
            'status' => fake()->randomElement(ConsultationStatus::cases())->value,
            'category' => fake()->randomElement(['Legal', 'Case Management', 'Emergency Response']),
            'assigned_to' => null,
        ];
    }
}
