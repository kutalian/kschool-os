<?php

namespace App\Services;

use App\Models\Grade;
use App\Models\Mark;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class GradingService
{
    /**
     * Get the grade for a specific score.
     * Uses database lookup cached for performance.
     */
    public function calculateGrade(float $score): ?array
    {
        // Cache grade configuration for 1 hour to avoid repeated DB hits
        $grades = Cache::remember('grading_system', 3600, function () {
            return Grade::where('is_active', true)
                ->orderBy('min_marks', 'desc')
                ->get();
        });

        foreach ($grades as $grade) {
            if ($score >= $grade->min_marks && $score <= $grade->max_marks) {
                return [
                    'grade' => $grade->grade,
                    'point' => $grade->grade_point,
                    'color' => $grade->color_code,
                    'description' => $grade->description
                ];
            }
        }

        return null;
    }

    /**
     * Calculate total and average from a collection of marks.
     */
    public function calculateAggregates(Collection $marks): array
    {
        if ($marks->isEmpty()) {
            return [
                'total' => 0,
                'average' => 0,
                'count' => 0
            ];
        }

        $total = $marks->sum('marks_obtained');
        $count = $marks->count(); // Or count unique subjects if there are duplicates? Assuming unique subjects per result set.
        $average = $count > 0 ? round($total / $count, 2) : 0;

        return compact('total', 'average', 'count');
    }

    /**
     * Determine if a student Passed or Failed based on average.
     * This logic might need to be more complex (e.g. must pass constant subjects),
     * but starting with a simple average threshold (e.g., 50).
     */
    public function determineResult(float $average, float $passMark = 50.0): string
    {
        return $average >= $passMark ? 'PASSED' : 'FAILED';
    }
}
