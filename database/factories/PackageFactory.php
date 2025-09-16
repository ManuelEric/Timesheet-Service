<?php

namespace Database\Factories;

use App\Models\Package;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Package>
 */
class PackageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category' => $this->faker->randomElement(['Tutoring', 'External Mentors', 'Student Club']),
            'type_of' => $this->faker->randomElement(['ALL', 'Academic Tutoring', 'Essay Guidance', 'Passion Project Mentoring']),
            'package' => $this->faker->randomElement(['Basic', 'Pro', 'Elite', 'Hourly', 'Starter', 'Regular', 'Premium']),
            'detail' => $this->faker->optional()->numberBetween(60, 2000),
            'active' => 1,
        ];
    }
}
