<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subject>
 */
class SubjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $subjects = [
            'Mathematics',
            'English',
            'Science',
            'History',
            'Geography',
            'Physics',
            'Chemistry',
            'Biology',
            'Computer Science',
            'Art',
            'Music',
            'Physical Education',
            'Economics',
            'Business Studies',
            'Accounting',
            'Commerce',
            'Government',
            'Literature',
            'Agricultural Science',
            'French',
            'Civic Education',
            'Further Mathematics',
            'Data Processing',
            'Technical Drawing'
        ];
        $subject = $this->faker->unique()->randomElement($subjects);

        return [
            'name' => $subject,
            'code' => strtoupper(substr($subject, 0, 3) . $this->faker->unique()->numberBetween(101, 199)),
            'type' => $this->faker->randomElement(['Theory', 'Practical', 'Both']),
            'description' => 'Standard curriculum for ' . $subject,
            'credit_hours' => $this->faker->numberBetween(2, 4),
            'is_active' => true,
        ];
    }
}
