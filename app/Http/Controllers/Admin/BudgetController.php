<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Budget;
use App\Models\ExpenseCategory;
use App\Models\SchoolSetting;
use Illuminate\Http\Request;

class BudgetController extends Controller
{
    public function index()
    {
        $currentYear = SchoolSetting::first()->academic_year ?? date('Y');

        $budgets = Budget::where('academic_year', $currentYear)
            ->latest()
            ->paginate(15);

        return view('admin.budgets.index', compact('budgets', 'currentYear'));
    }

    public function create()
    {
        // Get expense categories to populate the dropdown
        $categories = ExpenseCategory::where('is_active', true)->pluck('name');
        $currentYear = SchoolSetting::first()->academic_year ?? date('Y');

        return view('admin.budgets.create', compact('categories', 'currentYear'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category' => 'required|string|max:100',
            'academic_year' => 'required|string|max:20',
            'allocated_amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        // Check for duplicates
        $exists = Budget::where('category', $validated['category'])
            ->where('academic_year', $validated['academic_year'])
            ->exists();

        if ($exists) {
            return back()->with('error', 'A budget for this category and year already exists.');
        }

        Budget::create($validated);

        return redirect()->route('budgets.index')->with('success', 'Budget allocated successfully.');
    }

    public function edit(Budget $budget)
    {
        $categories = ExpenseCategory::where('is_active', true)->pluck('name');
        return view('admin.budgets.edit', compact('budget', 'categories'));
    }

    public function update(Request $request, Budget $budget)
    {
        $validated = $request->validate([
            'category' => 'required|string|max:100',
            'academic_year' => 'required|string|max:20',
            'allocated_amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
        ]);

        // Check for duplicates excluding current
        $exists = Budget::where('category', $validated['category'])
            ->where('academic_year', $validated['academic_year'])
            ->where('id', '!=', $budget->id)
            ->exists();

        if ($exists) {
            return back()->with('error', 'A budget for this category and year already exists.');
        }

        // Note: We do not update spent_amount manually here; it should be calculated via Expenses
        $budget->update([
            'category' => $validated['category'],
            'academic_year' => $validated['academic_year'],
            'allocated_amount' => $validated['allocated_amount'],
            'description' => $validated['description'],
        ]);

        return redirect()->route('budgets.index')->with('success', 'Budget updated successfully.');
    }

    public function destroy(Budget $budget)
    {
        $budget->delete();
        return redirect()->route('budgets.index')->with('success', 'Budget deleted.');
    }
}
