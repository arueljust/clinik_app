<?php

namespace Database\Factories;

use App\Models\Doctor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class DoctorScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'doctor_id' => Doctor::factory(),
            'day' => $this->faker->randomElement(['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu']),
            'time' => $this->faker->word,
            'status' => $this->faker->word,
            'note' => $this->faker->word
        ];
    }
}
