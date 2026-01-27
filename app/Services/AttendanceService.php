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
        $data = [];
        foreach ($attendanceData as $studentId => $status) {
            $data[] = [
                'student_id' => $studentId,
                'date' => $date,
                'status' => $status,
                'remarks' => $remarks[$studentId] ?? null
            ];
        }

        if (empty($data)) {
            return 0;
        }

        Attendance::upsert($data, ['student_id', 'date'], ['status', 'remarks']);

        return count($data);
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
        $data = [];
        foreach ($attendanceData as $staffId => $status) {
            $data[] = [
                'staff_id' => $staffId,
                'date' => $date,
                'status' => $status,
                'remarks' => $remarks[$staffId] ?? null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        if (empty($data)) {
            return 0;
        }

        StaffAttendance::upsert($data, ['staff_id', 'date'], ['status', 'remarks', 'updated_at']);

        return count($data);
    }
}
