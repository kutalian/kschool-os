<?php

namespace App\Services;

use App\Models\Student;
use App\Models\StudentParent;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class StudentService
{
    public function createStudent(array $data)
    {
        return DB::transaction(function () use ($data) {
            // Auto-Generate Admission No: ST-{YEAR}-{SEQ}
            $year = date('Y');
            $latestStudent = Student::where('admission_no', 'like', "ST-$year%")
                ->lockForUpdate()
                ->orderByRaw('LENGTH(admission_no) DESC')
                ->orderBy('admission_no', 'desc')
                ->first();

            if ($latestStudent) {
                $lastSequence = intval(substr($latestStudent->admission_no, -4));
                $newSequence = $lastSequence + 1;
            } else {
                $newSequence = 1;
            }

            $admissionNo = 'ST' . $year . str_pad($newSequence, 4, '0', STR_PAD_LEFT);
            $username = $admissionNo;

            // Create Student User
            // Create Student User
            $email = !empty($data['email']) ? $data['email'] : strtolower($username) . '@student.school.erp';

            $studentUser = User::create([
                'username' => $username,
                'name' => $data['first_name'] . ' ' . $data['last_name'],
                'email' => $email,
                'password' => Hash::make('password'), // Consider generating random password
                'role' => 'student',
            ]);

            // Handle Parent
            if ($data['parent_choice'] === 'new') {
                // Create Parent User
                $parentUser = User::create([
                    'username' => 'P' . str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT),
                    'name' => $data['parent_name'],
                    'email' => $data['parent_email'],
                    'password' => Hash::make('password'),
                    'role' => 'parent',
                ]);

                $parent = StudentParent::create([
                    'user_id' => $parentUser->id,
                    'name' => $data['parent_name'],
                    'email' => $data['parent_email'],
                    'phone' => $data['parent_phone'],
                ]);
                $parentId = $parent->id;
            } else {
                $parentId = $data['parent_id'];
            }

            // Create Student Profile
            Student::create([
                'user_id' => $studentUser->id,
                'admission_no' => $admissionNo,
                'name' => $data['first_name'] . ' ' . $data['last_name'],
                'email' => $data['email'] ?? null,
                'class_id' => $data['class_id'],
                'parent_id' => $parentId,
                'transport_route_id' => $data['transport_route_id'] ?? null,
                'dob' => $data['dob'],
                'gender' => $data['gender'],
                'blood_group' => $data['blood_group'] ?? null,
                'nationality' => $data['nationality'],
                'religion' => $data['religion'] ?? null,
                'category' => $data['category'] ?? null,
                'roll_no' => $data['roll_no'] ?? null,
                'phone' => $data['phone'] ?? null,
                'current_address' => $data['current_address'] ?? null,
                'permanent_address' => $data['permanent_address'] ?? null,
                'city' => $data['city'] ?? null,
                'state' => $data['state'] ?? null,
                'country' => $data['country'],
                'emergency_contact_name' => $data['emergency_contact_name'] ?? null,
                'emergency_contact_number' => $data['emergency_contact_number'] ?? null,
                'allergies' => $data['allergies'] ?? null,
                'medications' => $data['medications'] ?? null,
                'prev_school_name' => $data['prev_school_name'] ?? null,
                'prev_school_tc_no' => $data['prev_school_tc_no'] ?? null,
                'admission_date' => now(),
            ]);

            return $username;
        });
    }

    public function updateStudent(Student $student, array $data)
    {
        DB::transaction(function () use ($student, $data) {
            // Update User 
            if ($student->user) {
                $email = !empty($data['email']) ? $data['email'] : strtolower($student->user->username) . '@student.school.erp';
                $student->user->update([
                    'email' => $email,
                ]);
            }

            $data['name'] = $data['first_name'] . ' ' . $data['last_name'];
            unset($data['first_name'], $data['last_name']);

            $student->update($data);
        });
    }

    public function deleteStudent(Student $student)
    {
        DB::transaction(function () use ($student) {
            $student->attendance()->delete();
            if ($student->user) {
                $student->user->delete();
            }
            if ($student->exists) {
                $student->delete();
            }
        });
    }
}
