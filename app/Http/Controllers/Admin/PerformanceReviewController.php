<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PerformanceReview;
use App\Models\Staff;

class PerformanceReviewController extends Controller
{
    public function index()
    {
        $reviews = PerformanceReview::with(['staff', 'reviewer'])->latest('review_date')->paginate(10);
        return view('admin.performance.index', compact('reviews'));
    }

    public function create()
    {
        $staff = Staff::where('is_active', true)->get();
        return view('admin.performance.create', compact('staff'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'staff_id' => 'required|exists:staff,id',
            'review_date' => 'required|date',
            'rating' => 'required|integer|min:1|max:5',
            'comments' => 'nullable|string',
        ]);

        PerformanceReview::create([
            'staff_id' => $validated['staff_id'],
            'review_date' => $validated['review_date'],
            'rating' => $validated['rating'],
            'comments' => $validated['comments'],
            'reviewer_id' => auth()->id(),
        ]);

        return redirect()->route('performance-reviews.index')->with('success', 'Performance review added successfully.');
    }

    public function show(PerformanceReview $performanceReview)
    {
        $performanceReview->load(['staff', 'reviewer']);
        return view('admin.performance.show', compact('performanceReview'));
    }

    public function confirmDelete(PerformanceReview $performanceReview)
    {
        $performanceReview->load('staff');
        return view('admin.performance.delete', compact('performanceReview'));
    }

    public function destroy(PerformanceReview $performanceReview)
    {
        $performanceReview->delete();
        return redirect()->route('performance-reviews.index')->with('success', 'Review deleted successfully.');
    }
}
