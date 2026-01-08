<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // ... Phase 1 Seeding Commented Out ...
        // \App\Models\Staff::factory()->count(20)->create();
        // $classes = \App\Models\ClassRoom::factory()->count(10)->create();
        // $subjects = \App\Models\Subject::factory()->count(15)->create();
        // foreach ($classes as $class) { // ... }
        // $parents = \App\Models\StudentParent::factory()->count(50)->create();
        // \App\Models\Student::factory()->count(100)->make()->each(function ($student) use ($classes, $parents) { // ... });

        // === PHASE 2: Attendance, Exams, Reports ===

        // Truncate Phase 2 tables to prevent duplicates on re-run
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \App\Models\Attendance::truncate();
        \App\Models\Exam::truncate();
        \App\Models\Mark::truncate();
        \App\Models\ReportCard::truncate();
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $students = \App\Models\Student::all();
        $classes = \App\Models\ClassRoom::with('subjects')->get();

        if ($students->isEmpty() || $classes->isEmpty()) {
            $this->command->info('No students or classes found. Skipping Phase 2 seeding.');
            return;
        }

        // 1. Attendance (30 days per student)
        $this->command->info('Generating Attendance...');
        $startDate = now()->subDays(40);
        foreach ($students as $student) {
            // Generate 30 unique dates (skipping weekends if possible, or just sequential)
            $dates = [];
            for ($i = 0; $i < 30; $i++) {
                $dates[] = $startDate->copy()->addDays($i)->format('Y-m-d');
            }

            foreach ($dates as $date) {
                \App\Models\Attendance::factory()->create([
                    'student_id' => $student->id,
                    'date' => $date
                ]);
            }
        }

        // 2. Exams (2 per Class)
        $this->command->info('Generating Exams...');
        foreach ($classes as $classroom) {
            // Mid-Term
            $midTerm = \App\Models\Exam::factory()->create([
                'class_id' => $classroom->id,
                'name' => 'Mid-Term Exam',
                'exam_type' => 'Mid-Term'
            ]);

            // Final
            $finalExam = \App\Models\Exam::factory()->create([
                'class_id' => $classroom->id,
                'name' => 'Final Exam',
                'exam_type' => 'Final'
            ]);

            // 3. Marks & Report Cards for each Student in Class
            $classStudents = $students->where('class_id', $classroom->id);

            foreach ($classStudents as $student) {
                $exams = [$midTerm, $finalExam];
                foreach ($exams as $exam) {
                    $totalMarks = 0;
                    $subjectCount = 0;

                    foreach ($classroom->subjects as $subject) {
                        $mark = \App\Models\Mark::factory()->create([
                            'exam_id' => $exam->id,
                            'student_id' => $student->id,
                            'subject_id' => $subject->id
                        ]);
                        $totalMarks += $mark->marks_obtained;
                        $subjectCount++;
                    }

                    // 4. Report Card
                    if ($subjectCount > 0) {
                        $percentage = ($totalMarks / ($subjectCount * 100)) * 100;
                        \App\Models\ReportCard::factory()->create([
                            'student_id' => $student->id,
                            'exam_id' => $exam->id,
                            'total_marks' => $totalMarks,
                            'percentage' => $percentage,
                            'academic_year' => $exam->academic_year,
                            'term' => $exam->term,
                        ]);
                    }
                }
            }
        }
    }
}
