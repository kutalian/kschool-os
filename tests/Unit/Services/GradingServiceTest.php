<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Services\GradingService;
use App\Models\Grade;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;

class GradingServiceTest extends TestCase
{
    use RefreshDatabase;

    protected GradingService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new GradingService();
    }

    public function test_it_calculates_correct_grade_from_db()
    {
        // Arrange
        Grade::create(['grade' => 'A', 'min_marks' => 70, 'max_marks' => 100, 'grade_point' => 5.0, 'is_active' => true]);
        Grade::create(['grade' => 'B', 'min_marks' => 60, 'max_marks' => 69.99, 'grade_point' => 4.0, 'is_active' => true]);
        Grade::create(['grade' => 'F', 'min_marks' => 0, 'max_marks' => 39.99, 'grade_point' => 0.0, 'is_active' => true]);

        // Act & Assert
        $resultA = $this->service->calculateGrade(85);
        $this->assertEquals('A', $resultA['grade']);

        $resultB = $this->service->calculateGrade(65);
        $this->assertEquals('B', $resultB['grade']);

        $resultF = $this->service->calculateGrade(20);
        $this->assertEquals('F', $resultF['grade']);

        $resultNull = $this->service->calculateGrade(105); // Out of bounds
        $this->assertNull($resultNull);
    }

    public function test_it_calculates_aggregates()
    {
        // Arrange
        $marks = collect([
            ['marks_obtained' => 80],
            ['marks_obtained' => 60],
            ['marks_obtained' => 70],
        ]);

        // Act
        $aggregates = $this->service->calculateAggregates($marks);

        // Assert
        $this->assertEquals(210, $aggregates['total']);
        $this->assertEquals(70, $aggregates['average']);
        $this->assertEquals(3, $aggregates['count']);
    }

    public function test_it_determines_pass_result()
    {
        $this->assertEquals('PASSED', $this->service->determineResult(60));
        $this->assertEquals('FAILED', $this->service->determineResult(40));
    }
}
