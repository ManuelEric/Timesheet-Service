<?php

namespace Database\Factories\Pivot;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pivot\HandleBy>
 */
class HandlebyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'temp_user_id' => \App\Models\TempUser::inRandomOrder()->first()->id,
            'timesheet_id' => \App\Models\Timesheet::inRandomOrder()->first()->id,
            'active' => true,
        ];
    }
}
