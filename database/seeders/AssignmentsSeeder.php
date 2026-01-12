<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Assignment;
use App\Models\ClassRoom;
use App\Models\Subject;
use App\Models\User;
use App\Models\Student;
use App\Models\Submission;
use Carbon\Carbon;

class AssignmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $class = ClassRoom::first();
        $subject = Subject::first();
        $user = User::first(); // Assuming local admin or first user

        if (!$class || !$subject) {
            $this->command->warn('No classes or subjects found. Skipping assignment seeding.');
            return;
        }

        // Create Assignments
        $assignments = [];

        $assignments[] = Assignment::create([
            'class_id' => $class->id,
            'subject_id' => $subject->id,
            'title' => 'Biology Chapter 1 - The Cell',
            'description' => 'Read Chapter 1 and answer the questions at the end. Submit your answers as a PDF.',
            'due_date' => Carbon::now()->addDays(7),
            'created_by' => $user ? $user->id : null,
        ]);

        $assignments[] = Assignment::create([
            'class_id' => $class->id,
            'subject_id' => $subject->id,
            'title' => 'Math - Algebra Integration',
            'description' => 'Solve the attached problems regarding integration.',
            'due_date' => Carbon::now()->addDays(3),
            'created_by' => $user ? $user->id : null,
        ]);

        $assignments[] = Assignment::create([
            'class_id' => $class->id,
            'subject_id' => $subject->id, // Ideally pick another subject if available, but staying safe
            'title' => 'History - World War II Overview',
            'description' => 'Write a 500-word essay on the causes of WWII.',
            'due_date' => Carbon::now()->addDays(14),
            'created_by' => $user ? $user->id : null,
        ]);

        // Create Submissions for each assignment
        $students = Student::limit(10)->get(); // Get a pool of students

        foreach ($assignments as $assignment) {
            // Pick rand 3-5 students to submit
            $submitters = $students->random(rand(3, 5));

            foreach ($submitters as $student) {
                Submission::create([
                    'assignment_id' => $assignment->id,
                    'student_id' => $student->id,
                    'file_path' => 'submissions/dummy_file.pdf', // Dummy path
                    'marks_obtained' => rand(0, 1) ? rand(50, 100) / 10 : null, // Randomly grade some
                    'remarks' => rand(0, 1) ? 'Good effort!' : null,
                    'submitted_at' => Carbon::now()->subDays(rand(0, 5)),
                ]);
            }
        }

        $this->command->info('Assignments seeded successfully!');
    }
}
