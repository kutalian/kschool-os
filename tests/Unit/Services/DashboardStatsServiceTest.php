<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Services\DashboardStatsService;
use App\Models\Student;
use App\Models\Staff;
use App\Models\ClassRoom;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DashboardStatsServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_returns_correct_counts()
    {
        // Arrange
        Student::factory()->count(5)->create();
        Staff::factory()->count(3)->create();
        ClassRoom::factory()->count(2)->create();

        $service = new DashboardStatsService();

        // Act
        $counts = $service->getCounts();

        // Student factory creates a class for each student by default + 2 explicit classes
        $this->assertEquals(5, $counts['students']);
        $this->assertEquals(3, $counts['staff']);
        $this->assertEquals(7, $counts['classes']);
    }

    public function test_it_returns_recent_students()
    {
        // Arrange
        $class = ClassRoom::factory()->create();
        $student1 = Student::factory()->create(['created_at' => now()->subDay(), 'class_id' => $class->id]);
        $student2 = Student::factory()->create(['created_at' => now(), 'class_id' => $class->id]);

        $service = new DashboardStatsService();

        // Act
        $recent = $service->getRecentStudents(2);

        // Assert
        $this->assertCount(2, $recent);
        $this->assertEquals($student2->id, $recent->first()->id);
        $this->assertTrue($recent->first()->relationLoaded('class_room')); // Check eager loading
    }
}
