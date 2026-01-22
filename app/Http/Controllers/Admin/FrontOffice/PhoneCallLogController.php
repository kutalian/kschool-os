<?php

namespace App\Http\Controllers\Admin\FrontOffice;

use App\Http\Controllers\Controller;
use App\Models\PhoneCallLog;
use Illuminate\Http\Request;

class PhoneCallLogController extends Controller
{
    public function index()
    {
        $logs = PhoneCallLog::latest()->paginate(10);
        return view('admin.front-office.phone-calls.index', compact('logs'));
    }

    public function create()
    {
        return view('admin.front-office.phone-calls.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'phone' => 'required|string|max:20',
            'call_type' => 'required|in:Incoming,Outgoing',
            'date' => 'required|date',
            'description' => 'nullable|string',
            'duration' => 'nullable|string|max:20'
        ]);

        $validated['created_by'] = auth()->id();
        PhoneCallLog::create($validated);

        return redirect()->route('phone-call-logs.index')->with('success', 'Call log added successfully.');
    }

    public function edit(PhoneCallLog $phoneCallLog)
    {
        return view('admin.front-office.phone-calls.edit', compact('phoneCallLog'));
    }

    public function update(Request $request, PhoneCallLog $phoneCallLog)
    {
        $validated = $request->validate([
            'phone' => 'required|string|max:20',
            'call_type' => 'required|in:Incoming,Outgoing',
            'date' => 'required|date',
            'description' => 'nullable|string',
            'duration' => 'nullable|string|max:20'
        ]);

        $phoneCallLog->update($validated);

        return redirect()->route('phone-call-logs.index')->with('success', 'Call log updated successfully.');
    }

    public function destroy(PhoneCallLog $phoneCallLog)
    {
        $phoneCallLog->delete();
        return redirect()->route('phone-call-logs.index')->with('success', 'Call log deleted successfully.');
    }
}
