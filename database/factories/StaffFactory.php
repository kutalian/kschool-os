<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Staff>
 */
class StaffFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $role = $this->faker->randomElement(['Teacher', 'Teacher', 'Teacher', 'Admin', 'Support', 'Librarian']);

        return [
            'user_id' => \App\Models\User::factory()->create(['role' => strtolower($role) === 'admin' ? 'admin' : 'staff']),
            'employee_id' => 'EMP' . $this->faker->unique()->numberBetween(1000, 9999),
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'role_type' => $role,
            'dob' => $this->faker->date('Y-m-d', '-22 years'),
            'gender' => $this->faker->randomElement(['Male', 'Female']),
            'current_address' => $this->faker->address(),
            'permanent_address' => $this->faker->address(),
            'qualification' => $this->faker->randomElement(['B.Ed', 'M.Ed', 'PhD', 'B.Sc']),
            'experience_years' => $this->faker->numberBetween(1, 20),
            'joining_date' => $this->faker->date('Y-m-d', '-5 years'),
            'basic_salary' => $this->faker->numberBetween(50000, 200000),
            'is_active' => true,
        ];
    }
}
