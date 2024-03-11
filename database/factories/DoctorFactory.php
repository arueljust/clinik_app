<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class DoctorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'doctor_name' => fake()->name(),
            'doctor_specialist' => fake()->word(),
            'doctor_phone' => fake()->phoneNumber(),
            'doctor_email' => fake()->unique()->safeEmail(),
            'doctor_photo' => fake()->imageUrl(),
            'doctor_address' => fake()->address(),
            'doctor_sip' => fake()->numberBetween(1000, 9999),
        ];
    }
}
