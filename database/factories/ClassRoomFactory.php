<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ClassRoom>
 */
class ClassRoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'Class ' . $this->faker->unique()->numberBetween(1, 1000),
            'section' => $this->faker->randomElement(['A', 'B', 'C']),
            'capacity' => $this->faker->numberBetween(30, 50),
            'room_number' => 'Rm-' . $this->faker->unique()->numberBetween(101, 300),
            'is_active' => true,
        ];
    }
}
