<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ReportCard>
 */
class ReportCardFactory extends Factory
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
            'exam_id' => \App\Models\Exam::factory(),
            'academic_year' => date('Y') . '-' . (date('Y') + 1),
            'term' => 'First Term',
            'total_marks' => $this->faker->numberBetween(300, 800),
            'percentage' => $this->faker->randomFloat(2, 40, 99),
            'grade' => $this->faker->randomElement(['A', 'B', 'C', 'D', 'E', 'F']),
            'rank' => $this->faker->numberBetween(1, 30),
            'attendance_percentage' => $this->faker->randomFloat(2, 70, 100),
            'teacher_remarks' => $this->faker->sentence(),
            'principal_remarks' => $this->faker->sentence(),
            'status' => 'Published',
            'generated_at' => now(),
        ];
    }
}
