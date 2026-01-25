<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicSession;
use App\Models\Term;
use Illuminate\Http\Request;

class TermController extends Controller
{
    public function index()
    {
        $terms = Term::with('session')->latest()->paginate(10);
        $sessions = AcademicSession::where('is_active', true)->get();
        return view('admin.terms.index', compact('terms', 'sessions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'session_id' => 'required|exists:academic_sessions,id',
            'term_name' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_current' => 'boolean',
        ]);

        if ($request->boolean('is_current')) {
            Term::where('is_current', true)->update(['is_current' => false]);
            // Sync with School Settings
            $setting = \App\Models\SchoolSetting::first();
            if ($setting) {
                $setting->update(['current_term' => $validated['term_name']]);
            }
        }

        Term::create($validated);

        return redirect()->route('terms.index')->with('success', 'Term created successfully.');
    }

    public function update(Request $request, Term $term)
    {
        $validated = $request->validate([
            'session_id' => 'required|exists:academic_sessions,id',
            'term_name' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_current' => 'boolean',
            'is_active' => 'boolean',
        ]);

        if ($request->boolean('is_current')) {
            Term::where('id', '!=', $term->id)->update(['is_current' => false]);
            // Sync with School Settings
            $setting = \App\Models\SchoolSetting::first();
            if ($setting) {
                $setting->update(['current_term' => $validated['term_name']]);
            }
        }

        $term->update($validated);

        return redirect()->route('terms.index')->with('success', 'Term updated successfully.');
    }

    public function destroy(Term $term)
    {
        if ($term->is_current) {
            return back()->with('error', 'Cannot delete the current active term.');
        }

        $term->delete();

        return redirect()->route('terms.index')->with('success', 'Term deleted.');
    }
}