<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Timesheet>
 */
class TimesheetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'inhouse_id' => \App\Models\TempUser::where('inhouse', 1)->inRandomOrder()->first()->uuid,
            'package_id' => \App\Models\Package::inRandomOrder()->first()->id,
            'duration' => rand(60, 360),
            'notes' => fake()->text,
            'subject_id' => \App\Models\TempUserRoles::inRandomOrder()->first()->id,
        ];
    }
}
