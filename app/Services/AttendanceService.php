<?php

namespace App\Services;

use App\Models\Attendance;
use App\Models\StaffAttendance;
use Illuminate\Support\Facades\DB;

class AttendanceService
{
    /**
     * Record attendance for multiple students in a class for a specific date.
     * 
     * @param int $classId
     * @param string $date (Y-m-d)
     * @param array $attendanceData [student_id => status]
     * @param array $remarks [student_id => remark]
     * @return int Count of records updated/created
     */
    public function recordStudentAttendance(int $classId, string $date, array $attendanceData, array $remarks = []): int
    {
        return DB::transaction(function () use ($classId, $date, $attendanceData, $remarks) {
            $count = 0;
            foreach ($attendanceData as $studentId => $status) {
                $remark = $remarks[$studentId] ?? null;

                // Ideally, verify student belongs to classId here, 
                // but for performance in bulk, we trust the controller/request validation 
                // or assume the IDs provided are valid for the context.

                Attendance::updateOrCreate(
                    ['student_id' => $studentId, 'date' => $date],
                    ['status' => $status, 'remarks' => $remark]
                );
                $count++;
            }
            return $count;
        });
    }

    /**
     * Record attendance for multiple staff members for a specific date.
     * 
     * @param string $date (Y-m-d)
     * @param array $attendanceData [staff_id => status]
     * @param array $remarks [staff_id => remark]
     * @return int Count of records updated/created
     */
    public function recordStaffAttendance(string $date, array $attendanceData, array $remarks = []): int
    {
        return DB::transaction(function () use ($date, $attendanceData, $remarks) {
            $count = 0;
            foreach ($attendanceData as $staffId => $status) {
                $remark = $remarks[$staffId] ?? null;

                StaffAttendance::updateOrCreate(
                    ['staff_id' => $staffId, 'date' => $date],
                    ['status' => $status, 'remarks' => $remark]
                );
                $count++;
            }
            return $count;
        });
    }
}
