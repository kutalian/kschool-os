<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicSession;
use Illuminate\Http\Request;

class AcademicSessionController extends Controller
{
    public function index()
    {
        $sessions = AcademicSession::withCount('terms')->latest()->paginate(10);
        return view('admin.sessions.index', compact('sessions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'session_name' => 'required|string|unique:academic_sessions,session_name',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_current' => 'boolean',
        ]);

        if ($request->boolean('is_current')) {
            AcademicSession::where('is_current', true)->update(['is_current' => false]);
            // Sync with School Settings
            $setting = \App\Models\SchoolSetting::first();
            if ($setting) {
                $setting->update(['academic_year' => $validated['session_name']]);
            }
        }

        AcademicSession::create($validated);

        return redirect()->route('academic-sessions.index')->with('success', 'Academic Session created successfully.');
    }

    public function update(Request $request, AcademicSession $academicSession)
    {
        $validated = $request->validate([
            'session_name' => 'required|string|unique:academic_sessions,session_name,' . $academicSession->id,
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_current' => 'boolean',
            'is_active' => 'boolean',
        ]);

        if ($request->boolean('is_current')) {
            AcademicSession::where('id', '!=', $academicSession->id)->update(['is_current' => false]);
            // Sync with School Settings
            $setting = \App\Models\SchoolSetting::first();
            if ($setting) {
                $setting->update(['academic_year' => $validated['session_name']]);
            }
        }

        $academicSession->update($validated);

        return redirect()->route('academic-sessions.index')->with('success', 'Academic Session updated successfully.');
    }

    public function destroy(AcademicSession $academicSession)
    {
        if ($academicSession->terms()->exists()) {
            return back()->with('error', 'Cannot delete session with associated terms.');
        }

        if ($academicSession->is_current) {
            return back()->with('error', 'Cannot delete the current active session.');
        }

        $academicSession->delete();

        return redirect()->route('academic-sessions.index')->with('success', 'Academic Session deleted.');
    }
}
