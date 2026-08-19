<?php

namespace Database\Factories;

use App\Models\Consultation;
use App\Models\ConsultationMessage;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ConsultationMessage>
 */
class ConsultationMessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'consultation_id' => Consultation::factory(),
            'user_id' => User::factory(),
            'body' => fake()->paragraphs(2, true),
            'is_expert' => false,
        ];
    }
}
