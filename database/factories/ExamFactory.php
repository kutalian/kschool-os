<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Exam>
 */
class ExamFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('+1 month', '+2 months');
        $endDate = (clone $startDate)->modify('+2 weeks');

        return [
            'name' => $this->faker->randomElement(['Mid-Term', 'Final', 'First Term']) . ' Exam ' . date('Y'),
            'exam_type' => $this->faker->randomElement(['Mid-Term', 'Final', 'Quiz', 'Test']),
            'class_id' => \App\Models\ClassRoom::factory(),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'academic_year' => date('Y') . '-' . (date('Y') + 1),
            'term' => $this->faker->randomElement(['First Term', 'Second Term', 'Third Term']),
            'is_published' => $this->faker->boolean(80),
        ];
    }
}
