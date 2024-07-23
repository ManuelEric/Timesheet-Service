<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Activity>
 */
class ActivityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $fake_datestart = fake()->dateTimeBetween('-7 days');
        $fake_dateend = fake()->dateTimeBetween('-7 days');
        $start_date = Carbon::parse($fake_datestart);
        $end_date = Carbon::parse($fake_dateend);
        $time_spent = $start_date->diffInMinutes($end_date);

        $cutoff_status = ['paid', 'unpaid'];
        return [
            'timesheet_id' => \App\Models\Timesheet::inRandomOrder()->first()->id,
            'activity' => fake()->sentence,
            'description' => fake()->text,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'fee_hours' => fake()->randomNumber(6),
            'additional_fee' => 0,
            'time_spent' => $time_spent,
            'meeting_link' => fake()->url,
            'status' => 0,
            'cutoff_status' => $cutoff_status[array_rand($cutoff_status, 1)],
            'cutoff_ref_id' => NULL,
        ];
    }
}
