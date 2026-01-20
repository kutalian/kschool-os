<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Services\FeeService;
use App\Models\Student;
use App\Models\FeeType;
use App\Models\StudentFee;
use App\Models\User;
use App\Models\ClassRoom;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FeeServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $feeService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->feeService = new FeeService();
    }

    public function test_assign_to_class_creates_fees_for_all_students()
    {
        // Setup
        $class = ClassRoom::factory()->create();
        $students = Student::factory()->count(3)->create(['class_id' => $class->id]);
        $feeType = FeeType::create(['name' => 'Tuition', 'amount' => 5000, 'frequency' => 'One-Time']);

        // Action
        $count = $this->feeService->assignToClass($class->id, $feeType->id, [
            'due_date' => now()->addDays(30),
            'academic_year' => '2025-2026',
            'term' => 'Term 1'
        ]);

        // Assert
        $this->assertEquals(3, $count);
        $this->assertDatabaseCount('student_fees', 3);
        $this->assertDatabaseHas('student_fees', [
            'amount' => 5000,
            'status' => 'Unpaid'
        ]);
    }

    public function test_record_payment_updates_balance_and_status()
    {
        // Setup
        $user = User::factory()->create();
        $this->actingAs($user); // For auth()->id()

        $fee = StudentFee::factory()->create(['amount' => 1000, 'paid' => 0, 'status' => 'Unpaid']);

        // Action
        $payment = $this->feeService->recordPayment($fee->id, [
            'amount' => 600,
            'payment_method' => 'Cash',
            'remarks' => 'Part payment'
        ]);

        // Assert Payment
        $this->assertEquals(600, $payment->amount);
        $this->assertEquals('Approved', $payment->status);

        // Assert Fee Update
        $fee->refresh();
        $this->assertEquals(600, $fee->paid);
        $this->assertEquals('Partial', $fee->status);

        // Complete Payment
        $this->feeService->recordPayment($fee->id, [
            'amount' => 400,
            'payment_method' => 'Cash'
        ]);

        $fee->refresh();
        $this->assertEquals(1000, $fee->paid);
        $this->assertEquals('Paid', $fee->status);
    }
}
