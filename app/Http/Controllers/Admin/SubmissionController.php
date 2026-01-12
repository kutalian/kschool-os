<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Submission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SubmissionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'assignment_id' => 'required|exists:school_assignments,id',
            'file' => 'required|file|mimes:pdf,doc,docx,jpg,png,zip|max:10240',
        ]);

        $filePath = null;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . Auth::id() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('submissions', $filename, 'public');
        }

        // Check if already submitted
        $existing = Submission::where('assignment_id', $request->assignment_id)
            ->where('student_id', Auth::user()->student->id ?? 0) // Assuming student relationship exists on User
            ->first();

        if ($existing) {
            // Update existing? Or block? Let's allow update.
            if ($filePath) {
                if (Storage::exists('public/' . $existing->file_path)) {
                    Storage::delete('public/' . $existing->file_path);
                }
                $existing->update([
                    'file_path' => $filePath,
                    'submitted_at' => now(),
                ]);
            }
            return redirect()->back()->with('success', 'Assignment submission updated.');
        }

        // Verify user is a student
        $student = Auth::user()->student; // Need to ensure User has student relation
        if (!$student) {
            return redirect()->back()->with('error', 'Only students can submit assignments.');
        }

        Submission::create([
            'assignment_id' => $request->assignment_id,
            'student_id' => $student->id,
            'file_path' => $filePath,
            'submitted_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Assignment submitted successfully.');
    }
}
