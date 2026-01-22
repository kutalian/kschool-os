<?php

namespace App\Http\Controllers\Admin\Communication;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $messages = Message::where('receiver_id', Auth::id())
            ->with('sender')
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        return view('admin.communication.messages.index', compact('messages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::where('id', '!=', Auth::id())->get(['id', 'name', 'role']); // basic user list
        return view('admin.communication.messages.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'subject' => $request->subject,
            'message' => $request->message,
            'is_read' => false,
        ]);

        return redirect()->route('messages.index')->with('success', 'Message sent successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Message $message)
    {
        // Ensure user is sender or receiver
        if ($message->sender_id !== Auth::id() && $message->receiver_id !== Auth::id()) {
            abort(403);
        }

        // Mark as read if receiver
        if ($message->receiver_id === Auth::id() && !$message->is_read) {
            $message->update(['is_read' => true, 'read_at' => now()]);
        }

        return view('admin.communication.messages.show', compact('message'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Message $message)
    {
        if ($message->sender_id !== Auth::id() && $message->receiver_id !== Auth::id()) {
            abort(403);
        }

        $message->delete();

        return redirect()->route('messages.index')->with('success', 'Message deleted successfully.');
    }
}
