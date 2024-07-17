<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TempUserRoles>
 */
class TempUserRolesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $subjects = ['IB English', 'Mathematic', 'Biology', 'Science'];
        return [
            'temp_user_id' => \App\Models\TempUser::inRandomOrder()->first()->id,
            'role' => 'Tutor',
            'tutor_subject' => $subjects[array_rand($subjects, 1)],
            'fee_hours' => fake()->randomNumber(6),
            'fee_session' => 0
        ];
    }
}
