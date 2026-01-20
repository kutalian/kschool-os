<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $admissionYear = $this->faker->year;

        return [
            'user_id' => \App\Models\User::factory()->create(['role' => 'student']),
            'admission_no' => 'ST' . $admissionYear . $this->faker->unique()->numberBetween(1000, 9999),
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'class_id' => \App\Models\ClassRoom::factory(),
            'parent_id' => \App\Models\StudentParent::factory(),
            'admission_date' => $this->faker->date(),
            'roll_no' => $this->faker->numberBetween(1, 60),
            'dob' => $this->faker->date('Y-m-d', '-15 years'),
            'gender' => $this->faker->randomElement(['Male', 'Female']),
            'nationality' => 'Nigerian',
            'category' => 'General',
            'current_address' => $this->faker->address(),
            'permanent_address' => $this->faker->address(),
        ];
    }
}
