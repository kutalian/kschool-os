<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Mark>
 */
class MarkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $marks = $this->faker->numberBetween(30, 100);

        return [
            'exam_id' => \App\Models\Exam::factory(),
            'student_id' => \App\Models\Student::factory(),
            'subject_id' => \App\Models\Subject::factory(),
            'marks_obtained' => $marks,
            'total_marks' => 100,
            'grade' => $marks >= 70 ? 'A' : ($marks >= 60 ? 'B' : ($marks >= 50 ? 'C' : ($marks >= 40 ? 'D' : 'F'))),
            'remarks' => $this->faker->optional()->sentence(),
        ];
    }
}
