<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\ClassRoom;
use App\Models\Subject;
use App\Models\LessonPlan;

class LessonPlansSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure we have some teachers
        $teacher = User::where('role', 'staff')->first();

        if (!$teacher) {
            // Fallback or create a teacher if none exists (just for safety in dev)
            $teacher = User::first() ?? User::factory()->create(['role' => 'staff']);
        }

        $classes = ClassRoom::all();
        $subjects = Subject::all();

        if ($classes->isEmpty() || $subjects->isEmpty()) {
            $this->command->info('No classes or subjects found. Skipping Lesson Plans seeding.');
            return;
        }

        // Create some sample lesson plans
        $statuses = ['pending', 'approved', 'rejected'];

        foreach (range(1, 10) as $i) {
            $class = $classes->random();
            $subject = $subjects->random();
            $status = $statuses[array_rand($statuses)];
            $adminRemarks = $status === 'rejected' ? 'Please add more details about resources.' : null;

            LessonPlan::create([
                'teacher_id' => $teacher->id,
                'class_id' => $class->id,
                'subject_id' => $subject->id,
                'week_start_date' => now()->addWeeks(rand(-2, 4))->startOfWeek(), // Recent or upcoming weeks
                'topic' => 'Unit ' . $i . ': ' . fake()->sentence(3),
                'objectives' => fake()->paragraph(2),
                'resources_needed' => fake()->sentence(),
                'status' => $status,
                'admin_remarks' => $adminRemarks,
            ]);
        }

        $this->command->info('Lesson Plans seeded successfully.');
    }
}
