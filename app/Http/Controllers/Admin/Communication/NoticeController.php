<?php

namespace App\Http\Controllers\Admin\Communication;

use App\Http\Controllers\Controller;
use App\Models\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoticeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notices = Notice::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.communication.notices.index', compact('notices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.communication.notices.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required',
            'audience' => 'required',
        ]);

        Notice::create([
            'title' => $request->title,
            'message' => $request->message,
            'audience' => $request->audience,
            'priority' => $request->priority ?? 'Normal',
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'is_active' => true,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('notices.index')->with('success', 'Notice published successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Notice $notice)
    {
        return view('admin.communication.notices.edit', compact('notice'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Notice $notice)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required',
            'audience' => 'required',
        ]);

        $notice->update($request->all());

        return redirect()->route('notices.index')->with('success', 'Notice updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notice $notice)
    {
        $notice->delete();
        return redirect()->route('notices.index')->with('success', 'Notice deleted successfully.');
    }
}
