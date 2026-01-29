<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use App\Models\ClassRoom;
use App\Models\Timetable;
use App\Models\Student;
use App\Models\StudentParent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        $messages = Message::where('receiver_id', Auth::id())
            ->with('sender')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('staff.messages.index', compact('messages'));
    }

    public function sent()
    {
        $messages = Message::where('sender_id', Auth::id())
            ->with('receiver')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('staff.messages.sent', compact('messages'));
    }

    public function create(Request $request)
    {
        $user = Auth::user();
        $staff = $user->staff;

        if (!$staff) {
            return redirect()->route('dashboard');
        }

        // Logic to get parents of students taught by this teacher
        $homeroomClasses = ClassRoom::where('class_teacher_id', $staff->id)->pluck('id');
        $scheduledClasses = Timetable::where('teacher_id', $user->id)->pluck('class_id');
        $classIds = $homeroomClasses->merge($scheduledClasses)->unique();

        // 1. Get parents of students in these classes
        $parentUsers = User::whereHas('parent.students', function ($query) use ($classIds) {
            $query->whereIn('class_id', $classIds);
        })
            ->where('role', 'parent')
            ->get(['id', 'name', 'role']);

        // 2. Get all staff and admin users (colleagues)
        $staffUsers = User::whereIn('role', ['admin', 'staff', 'receptionist', 'librarian', 'accountant'])
            ->where('id', '!=', $user->id)
            ->get(['id', 'name', 'role']);

        // 3. Get students in these classes
        $studentUsers = User::whereHas('student', function ($query) use ($classIds) {
            $query->whereIn('class_id', $classIds);
        })
            ->where('role', 'student')
            ->get(['id', 'name', 'role']);

        $recipients = $staffUsers->concat($parentUsers)->concat($studentUsers);

        $replyTo = null;
        if ($request->has('reply_to')) {
            $replyTo = Message::with('sender')->find($request->reply_to);
            if ($replyTo && ($replyTo->receiver_id !== $user->id && $replyTo->sender_id !== $user->id)) {
                $replyTo = null;
            }
        }

        return view('staff.messages.create', compact('recipients', 'replyTo'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'parent_message_id' => 'nullable|exists:messages,id',
        ]);

        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'subject' => $request->subject,
            'message' => $request->message,
            'parent_message_id' => $request->parent_message_id,
            'is_read' => false,
        ]);

        return redirect()->route('staff.messages.index')->with('success', 'Message sent successfully.');
    }

    public function show(Message $message)
    {
        if ($message->sender_id !== Auth::id() && $message->receiver_id !== Auth::id()) {
            abort(403);
        }

        if ($message->receiver_id === Auth::id() && !$message->is_read) {
            $message->update(['is_read' => true, 'read_at' => now()]);
        }

        return view('staff.messages.show', compact('message'));
    }

    public function confirmDelete(Message $message)
    {
        if ($message->sender_id !== Auth::id() && $message->receiver_id !== Auth::id()) {
            abort(403);
        }

        return view('staff.messages.delete', compact('message'));
    }

    public function destroy(Message $message)
    {
        if ($message->sender_id !== Auth::id() && $message->receiver_id !== Auth::id()) {
            abort(403);
        }

        $message->delete();

        return redirect()->route('staff.messages.index')->with('success', 'Message deleted.');
    }
}
