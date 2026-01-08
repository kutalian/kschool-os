<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $password = Hash::make('password');
        $now = Carbon::now();

        // 1. Super Admin
        $adminId = DB::table('users')->insertGetId([
            'username' => 'admin',
            'password' => $password,
            'role' => 'admin',
            'email' => 'admin@school.com',
            'is_active' => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::table('staff')->insert([
            'user_id' => $adminId,
            'employee_id' => 'ADM001',
            'name' => 'Super Admin',
            'email' => 'admin@school.com',
            'phone' => '08012345678',
            'role_type' => 'Admin',
            'employment_type' => 'Permanent',
            'joining_date' => '2020-01-01',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // 2. Principal
        $principalId = DB::table('users')->insertGetId([
            'username' => 'principal',
            'password' => $password,
            'role' => 'staff',
            'email' => 'principal@school.com',
            'is_active' => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::table('staff')->insert([
            'user_id' => $principalId,
            'employee_id' => 'PRN001',
            'name' => 'Principal User',
            'email' => 'principal@school.com',
            'phone' => '08012345679',
            'role_type' => 'Management', // Closest to Principal in the enum if not exact
            'designation' => 'Principal',
            'employment_type' => 'Permanent',
            'joining_date' => '2020-01-01',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // 3. Teacher
        $teacherId = DB::table('users')->insertGetId([
            'username' => 'teacher',
            'password' => $password,
            'role' => 'staff',
            'email' => 'teacher@school.com',
            'is_active' => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::table('staff')->insert([
            'user_id' => $teacherId,
            'employee_id' => 'TCH001',
            'name' => 'John Teacher',
            'email' => 'teacher@school.com',
            'phone' => '08012345680',
            'role_type' => 'Teacher',
            'designation' => 'Senior Teacher',
            'employment_type' => 'Permanent',
            'joining_date' => '2021-01-01',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // 4. Parent
        $parentId = DB::table('users')->insertGetId([
            'username' => 'parent',
            'password' => $password,
            'role' => 'parent',
            'email' => 'parent@school.com',
            'is_active' => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $parentProfileId = DB::table('parents')->insertGetId([
            'user_id' => $parentId,
            'name' => 'Mr. Parent',
            'email' => 'parent@school.com',
            'primary_phone' => '08012345681',
            'father_name' => 'Mr. Parent',
            'is_active' => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // 5. Student
        $studentId = DB::table('users')->insertGetId([
            'username' => 'student',
            'password' => $password,
            'role' => 'student',
            'email' => 'student@school.com',
            'is_active' => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::table('students')->insert([
            'user_id' => $studentId,
            'admission_no' => 'STD001',
            'name' => 'Student User',
            'email' => 'student@school.com',
            'parent_id' => $parentProfileId,
            'roll_no' => '1001',
            'dob' => '2010-01-01',
            'gender' => 'Male',
            'nationality' => 'Nigerian',
            'is_active' => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // 6. Accountant
        $accountantId = DB::table('users')->insertGetId([
            'username' => 'accountant',
            'password' => $password,
            'role' => 'staff',
            'email' => 'accountant@school.com',
            'is_active' => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::table('staff')->insert([
            'user_id' => $accountantId,
            'employee_id' => 'ACC001',
            'name' => 'Accountant User',
            'email' => 'accountant@school.com',
            'phone' => '08012345682',
            'role_type' => 'Other',
            'designation' => 'Accountant',
            'employment_type' => 'Permanent',
            'joining_date' => '2021-06-01',
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // Assign Roles in user_roles table based on the roles table
        // We assume roles table is already populated by the import
        $roles = DB::table('roles')->pluck('id', 'role_name');

        // Helper to attach role
        $attachRole = function ($userId, $roleName) use ($roles, $now) {
            // Find closest role match or fallback
            // In schema insert: Super Admin, Principal, Teacher, Student, Parent, Accountant
            $roleId = $roles[$roleName] ?? null;
            if ($roleId) {
                DB::table('user_roles')->insert([
                    'user_id' => $userId,
                    'role_id' => $roleId,
                    'created_at' => $now,
                ]);
            }
        };

        $attachRole($adminId, 'Super Admin');
        $attachRole($principalId, 'Principal');
        $attachRole($teacherId, 'Teacher');
        $attachRole($parentId, 'Parent');
        $attachRole($studentId, 'Student');
        $attachRole($accountantId, 'Accountant');
    }
}
