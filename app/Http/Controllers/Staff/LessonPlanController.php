<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\ClassRoom;
use App\Models\LessonPlan;
use App\Models\Subject;
use App\Models\Timetable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LessonPlanController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $staff = $user->staff;

        if (!$staff) {
            return redirect()->route('dashboard');
        }

        $lessonPlans = LessonPlan::where('teacher_id', $user->id)
            ->with(['class_room', 'subject'])
            ->latest()
            ->paginate(10);

        return view('staff.lesson-plans.index', compact('lessonPlans'));
    }

    public function create()
    {
        $user = Auth::user();
        $staff = $user->staff;

        if (!$staff) {
            return redirect()->route('dashboard');
        }

        $homeroomClasses = ClassRoom::where('class_teacher_id', $staff->id)->get();
        $scheduledClasses = Timetable::where('teacher_id', $user->id)
            ->with('classRoom')
            ->get()
            ->pluck('classRoom')
            ->unique('id');

        $classes = $homeroomClasses->merge($scheduledClasses)->unique('id');
        $subjects = Subject::where('is_active', true)->get();

        return view('staff.lesson-plans.create', compact('classes', 'subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'week_start_date' => 'required|date',
            'topic' => 'required|string|max:255',
            'objectives' => 'required|string',
            'activities' => 'nullable|string',
            'homework' => 'nullable|string',
        ]);

        $data = $request->only(['class_id', 'subject_id', 'week_start_date', 'topic', 'objectives', 'activities', 'homework']);
        $data['teacher_id'] = Auth::id();

        LessonPlan::create($data);

        return redirect()->route('staff.lesson-plans.index')->with('success', 'Lesson plan created successfully.');
    }

    public function show(LessonPlan $lessonPlan)
    {
        if ($lessonPlan->teacher_id !== Auth::id()) {
            abort(403);
        }

        return view('staff.lesson-plans.show', compact('lessonPlan'));
    }

    public function edit(LessonPlan $lessonPlan)
    {
        if ($lessonPlan->teacher_id !== Auth::id()) {
            abort(403);
        }

        $user = Auth::user();
        $staff = $user->staff;

        $homeroomClasses = ClassRoom::where('class_teacher_id', $staff->id)->get();
        $scheduledClasses = Timetable::where('teacher_id', $user->id)
            ->with('classRoom')
            ->get()
            ->pluck('classRoom')
            ->unique('id');

        $classes = $homeroomClasses->merge($scheduledClasses)->unique('id');
        $subjects = Subject::where('is_active', true)->get();

        return view('staff.lesson-plans.edit', compact('lessonPlan', 'classes', 'subjects'));
    }

    public function update(Request $request, LessonPlan $lessonPlan)
    {
        if ($lessonPlan->teacher_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'week_start_date' => 'required|date',
            'topic' => 'required|string|max:255',
            'objectives' => 'required|string',
            'activities' => 'nullable|string',
            'homework' => 'nullable|string',
        ]);

        $lessonPlan->update($request->all());

        return redirect()->route('staff.lesson-plans.index')->with('success', 'Lesson plan updated successfully.');
    }

    public function destroy(LessonPlan $lessonPlan)
    {
        if ($lessonPlan->teacher_id !== Auth::id()) {
            abort(403);
        }

        $lessonPlan->delete();

        return redirect()->route('staff.lesson-plans.index')->with('success', 'Lesson plan deleted successfully.');
    }
}
