<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Services\AttendanceService;
use App\Models\Student;
use App\Models\Staff;
use App\Models\Attendance;
use App\Models\StaffAttendance;
use App\Models\ClassRoom;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AttendanceServiceTest extends TestCase
{
    use RefreshDatabase;

    protected AttendanceService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new AttendanceService();
    }

    public function test_it_records_student_attendance_in_bulk()
    {
        $class = ClassRoom::factory()->create();
        $student1 = Student::factory()->create(['class_id' => $class->id]);
        $student2 = Student::factory()->create(['class_id' => $class->id]);

        $date = '2024-03-10';
        $data = [
            $student1->id => 'Present',
            $student2->id => 'Absent'
        ];
        $remarks = [
            $student2->id => 'Sick'
        ];

        $count = $this->service->recordStudentAttendance($class->id, $date, $data, $remarks);

        $this->assertEquals(2, $count);

        $this->assertDatabaseHas('attendance', [
            'student_id' => $student1->id,
            'date' => $date . ' 00:00:00', // Assuming MySQL timestamp/datetime format
            'status' => 'Present'
        ]);

        $this->assertDatabaseHas('attendance', [
            'student_id' => $student2->id,
            'date' => $date . ' 00:00:00',
            'status' => 'Absent',
            'remarks' => 'Sick'
        ]);
    }

    public function test_it_records_staff_attendance_in_bulk()
    {
        $user1 = User::factory()->create();
        $staff1 = Staff::factory()->create(['user_id' => $user1->id]);

        $user2 = User::factory()->create();
        $staff2 = Staff::factory()->create(['user_id' => $user2->id]);

        $date = '2024-03-11';
        $data = [
            $staff1->id => 'Present',
            $staff2->id => 'Late'
        ];

        $count = $this->service->recordStaffAttendance($date, $data);

        $this->assertEquals(2, $count);

        $this->assertDatabaseHas('staff_attendances', [
            'staff_id' => $staff1->id,
            'date' => $date . ' 00:00:00',
            'status' => 'Present'
        ]);

        $this->assertDatabaseHas('staff_attendances', [
            'staff_id' => $staff2->id,
            'date' => $date . ' 00:00:00',
            'status' => 'Late'
        ]);
    }
}
