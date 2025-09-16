<?php

namespace Database\Factories;

use App\Models\Ref_Program;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ref_Program>
 */
class Ref_ProgramFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category' => $this->faker->randomElement(['Tutoring', 'Mentoring', 'Student Club']),
            'clientprog_id' => $this->faker->uuid,
            'schprog_id' => $this->faker->uuid,
            'invoice_id' => $this->faker->uuid,
            'sales_pic_name' => $this->faker->name,
            'sales_pic_phone' => $this->faker->phoneNumber,
            'student_uuid' => $this->faker->uuid,
            'student_name' => $this->faker->name,
            'student_school' => $this->faker->company,
            'student_grade' => $this->faker->randomElement(['9', '10', '11', '12']),
            'program_name' => $this->faker->sentence(3),
            'free_trial' => $this->faker->boolean,
            'require' => $this->faker->randomElement(['Tutor', 'Mentor']),
            'package' => $this->faker->randomElement(['Basic', 'Pro', 'Elite', 'Hourly']),
            'curriculum' => $this->faker->randomElement(['Math', 'Science', 'English', 'Essay']),
            'timesheet_id' => null,
            'scnd_timesheet_id' => null,
            'engagement_type_id' => null,
            'notes' => $this->faker->optional()->text,
            'cancellation_reason' => null,
            'cancelled_at' => null,
            'requested_by' => $this->faker->uuid,
            'mentoring_log_id' => null,
        ];
    }
}
