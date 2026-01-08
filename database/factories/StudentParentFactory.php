<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StudentParent>
 */
class StudentParentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::factory()->create(['role' => 'parent']),
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'father_name' => $this->faker->name('male'),
            'father_phone' => $this->faker->phoneNumber(),
            'father_occupation' => $this->faker->jobTitle(),
            'mother_name' => $this->faker->name('female'),
            'mother_phone' => $this->faker->phoneNumber(),
            'mother_occupation' => $this->faker->jobTitle(),
            'is_active' => true,
        ];
    }
}
