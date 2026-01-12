<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LessonPlan;
use App\Models\ClassRoom;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LessonPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = LessonPlan::with(['teacher', 'class_room', 'subject']);

        if (Auth::user()->role !== 'admin') {
            $query->where('teacher_id', Auth::id());
        }

        if ($request->has('class_id') && $request->class_id) {
            $query->where('class_id', $request->class_id);
        }

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        if ($request->has('trashed')) {
            $query->onlyTrashed();
        }

        $lessonPlans = $query->latest()->paginate(10);
        $classes = ClassRoom::all();

        return view('admin.lesson-plans.index', compact('lessonPlans', 'classes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $classes = ClassRoom::all();
        $subjects = Subject::all();
        return view('admin.lesson-plans.create', compact('classes', 'subjects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'week_start_date' => 'required|date',
            'topic' => 'required|string|max:255',
            'objectives' => 'required|string',
            'resources_needed' => 'nullable|string',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ]);

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('lesson-plans', 'public');
        }

        LessonPlan::create([
            'teacher_id' => Auth::id(),
            'class_id' => $request->class_id,
            'subject_id' => $request->subject_id,
            'week_start_date' => $request->week_start_date,
            'topic' => $request->topic,
            'objectives' => $request->objectives,
            'resources_needed' => $request->resources_needed,
            'attachment' => $attachmentPath,
            'status' => 'pending',
        ]);

        return redirect()->route('lesson-plans.index')->with('success', 'Lesson plan submitted successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(LessonPlan $lessonPlan)
    {
        // Ensure teacher can only view their own plan unless admin
        if (Auth::user()->role !== 'admin' && $lessonPlan->teacher_id !== Auth::id()) {
            abort(403);
        }
        return view('admin.lesson-plans.show', compact('lessonPlan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LessonPlan $lessonPlan)
    {
        if (Auth::user()->role !== 'admin' && $lessonPlan->teacher_id !== Auth::id()) {
            abort(403);
        }

        // Prevent editing if already approved (unless admin)
        if ($lessonPlan->status === 'approved' && Auth::user()->role !== 'admin') {
            return redirect()->route('lesson-plans.index')->with('error', 'Cannot edit approved lesson plans.');
        }

        $classes = ClassRoom::all();
        $subjects = Subject::all();
        return view('admin.lesson-plans.edit', compact('lessonPlan', 'classes', 'subjects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LessonPlan $lessonPlan)
    {
        if (Auth::user()->role !== 'admin' && $lessonPlan->teacher_id !== Auth::id()) {
            abort(403);
        }

        if ($lessonPlan->status === 'approved' && Auth::user()->role !== 'admin') {
            return redirect()->route('lesson-plans.index')->with('error', 'Cannot edit approved lesson plans.');
        }

        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'week_start_date' => 'required|date',
            'topic' => 'required|string|max:255',
            'objectives' => 'required|string',
            'resources_needed' => 'nullable|string',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ]);

        $data = [
            'class_id' => $request->class_id,
            'subject_id' => $request->subject_id,
            'week_start_date' => $request->week_start_date,
            'topic' => $request->topic,
            'objectives' => $request->objectives,
            'resources_needed' => $request->resources_needed,
            'status' => $lessonPlan->status === 'rejected' ? 'pending' : $lessonPlan->status,
        ];

        if ($request->hasFile('attachment')) {
            // Delete old file if exists
            if ($lessonPlan->attachment) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($lessonPlan->attachment);
            }
            $data['attachment'] = $request->file('attachment')->store('lesson-plans', 'public');
        }

        $lessonPlan->update($data);

        return redirect()->route('lesson-plans.index')->with('success', 'Lesson plan updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LessonPlan $lessonPlan)
    {
        if (Auth::user()->role !== 'admin' && $lessonPlan->teacher_id !== Auth::id()) {
            abort(403);
        }

        $lessonPlan->delete();

        return redirect()->route('lesson-plans.index')->with('success', 'Lesson plan deleted successfully.');
    }

    public function approve(LessonPlan $lessonPlan)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $lessonPlan->update(['status' => 'approved', 'admin_remarks' => null]);

        return redirect()->back()->with('success', 'Lesson plan approved.');
    }

    public function reject(Request $request, LessonPlan $lessonPlan)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $request->validate(['admin_remarks' => 'required|string']);

        $lessonPlan->update([
            'status' => 'rejected',
            'admin_remarks' => $request->admin_remarks
        ]);

        return redirect()->back()->with('success', 'Lesson plan rejected.');
    }

    public function restore($id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $lessonPlan = LessonPlan::withTrashed()->findOrFail($id);
        $lessonPlan->restore();

        return redirect()->back()->with('success', 'Lesson plan restored successfully.');
    }

    public function forceDelete($id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $lessonPlan = LessonPlan::withTrashed()->findOrFail($id);
        $lessonPlan->forceDelete();

        return redirect()->back()->with('success', 'Lesson plan permanently deleted.');
    }
}
