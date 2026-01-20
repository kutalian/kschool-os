<?php

namespace Database\Factories;

use App\Models\Payment;
use App\Models\StudentFee;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition(): array
    {
        return [
            'student_fee_id' => StudentFee::factory(),
            'amount' => $this->faker->randomFloat(2, 50, 500),
            'payment_date' => $this->faker->date(),
            'payment_method' => $this->faker->randomElement(['Cash', 'Card', 'Bank Transfer']),
            'transaction_id' => $this->faker->uuid(),
            'status' => 'Paid',
            'received_by' => User::factory(),
        ];
    }
}
