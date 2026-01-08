<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attendance>
 */
class AttendanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'student_id' => \App\Models\Student::factory(),
            'date' => $this->faker->unique()->dateTimeBetween('-2 months', 'now'),
            'status' => $this->faker->randomElement(['Present', 'Present', 'Present', 'Absent', 'Late']),
            'remarks' => $this->faker->optional(0.1)->sentence(),
        ];
    }
}
