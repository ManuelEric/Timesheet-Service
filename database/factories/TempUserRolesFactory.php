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
        /**
         * Tutor Factory
         */
        // $subjects = ['IB English', 'Mathematic', 'Biology', 'Science'];
        // return [
        //     'temp_user_id' => \App\Models\TempUser::inRandomOrder()->first()->id,
        //     'role' => 'Tutor',
        //     'tutor_subject' => $subjects[array_rand($subjects, 1)],
        //     'year' => Carbon::now()->format('Y'),
        //     'head' => null,
        //     'additional_fee' => 0,
        //     'grade' => rand(10,12),
        //     'fee_individual' => fake()->randomNumber(6),
        //     'fee_group' => fake()->randomNumber(6),
        //     'tax' => null,
        //     'curriculum_id' => null,
        // ];

        /**
         * External Mentor Factory
         */
        return [
            'temp_user_id' => \App\Models\TempUser::doesntHave('roles')->inRandomOrder()->first()->id,
            'role' => 'External Mentor',
        ];
    }
}
