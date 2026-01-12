<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Student;
use App\Models\ClassRoom;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserFixSeeder extends Seeder
{
    public function run()
    {
        DB::beginTransaction();
        try {
            $user = User::firstOrCreate(
                ['username' => 'JohnDoe'],
                [
                    'password' => Hash::make('password'),
                    'role' => 'student',
                    'email' => 'john.doe@example.com',
                    'is_active' => true
                ]
            );

            $class = ClassRoom::firstOrCreate(['name' => 'Grade 10-A']);

            Student::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'name' => 'John Doe',
                    'admission_no' => 'ADM-JOHN-001',
                    'roll_no' => '101',
                    'class_id' => $class->id,
                    'dob' => '2005-01-01',
                    'gender' => 'Male',
                    'admission_date' => now(),
                    'nationality' => 'Nigerian',
                    'current_address' => '123 Main St'
                ]
            );

            DB::commit();
            $this->command->info('John Doe created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error($e->getMessage());
        }
    }
}
