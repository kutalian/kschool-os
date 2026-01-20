<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Services\PayrollService;
use App\Models\Staff;
use App\Models\StaffAttendance;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

class PayrollServiceTest extends TestCase
{
    use RefreshDatabase;

    protected PayrollService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new PayrollService();
    }

    public function test_it_calculates_no_deduction_for_full_attendance()
    {
        // Arrange
        $user = User::factory()->create();
        $staff = Staff::factory()->create([
            'user_id' => $user->id,
            'basic_salary' => 30000
        ]);

        $month = '2024-01';

        // Act
        $data = $this->service->calculatePayrollData($staff, $month);

        // Assert
        $this->assertEquals(0, $data['deduction']);
        $this->assertEquals(30000, $data['net_salary']);
        $this->assertEquals(0, $data['absent_days']);
    }

    public function test_it_calculates_deduction_for_absences()
    {
        // Arrange
        $user = User::factory()->create();
        $staff = Staff::factory()->create([
            'user_id' => $user->id,
            'basic_salary' => 30000 // 1000 per day (assuming 30 days)
        ]);

        // Create 2 days absence
        StaffAttendance::create(['staff_id' => $staff->id, 'date' => '2024-01-05', 'status' => 'Absent']);
        StaffAttendance::create(['staff_id' => $staff->id, 'date' => '2024-01-10', 'status' => 'Leave']);

        $month = '2024-01';

        // Act
        $data = $this->service->calculatePayrollData($staff, $month);

        // Assert
        // Daily rate = 30000 / 30 = 1000. Deduction = 2 * 1000 = 2000. Net = 28000.
        $this->assertEquals(2000, $data['deduction']);
        $this->assertEquals(28000, $data['net_salary']);
        $this->assertEquals(2, $data['absent_days']);
    }

    public function test_it_generates_payroll_record()
    {
        $user = User::factory()->create();
        $staff = Staff::factory()->create(['user_id' => $user->id, 'basic_salary' => 50000]);
        $month = '2024-02';

        $payroll = $this->service->generatePayroll($staff, $month);

        $this->assertDatabaseHas('payrolls', [
            'staff_id' => $staff->id,
            'month' => $month,
            'net_salary' => 50000
        ]);
    }
}
