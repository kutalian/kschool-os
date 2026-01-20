<?php

namespace Database\Factories;

use App\Models\StudentFee;
use App\Models\Student;
use App\Models\FeeType;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFeeFactory extends Factory
{
    protected $model = StudentFee::class;

    public function definition(): array
    {
        return [
            'student_id' => Student::factory(),
            // Assuming FeeType exists or we can mock ID. If FeeType model exists, use factory
            'fee_type_id' => 1,
            'amount' => 1000,
            'due_date' => $this->faker->date(),
            'status' => 'Pending',
        ];
    }
}
