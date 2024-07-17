<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TempUser>
 */
class TempUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => Str::ulid(),
            'uuid' => Str::uuid(),
            'full_name' => fake()->name,
            'email' => fake()->email,
            'password' => Hash::make('password'),
            'inhouse' => rand(0, 1),
            'last_activity' => NULL,
        ];
    }
}
