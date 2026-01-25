<?php

namespace App\Http\Controllers\Admin\Communication;

use App\Http\Controllers\Controller;
use App\Models\EmailLog;
use App\Models\NotificationQueue;
use App\Models\SmsLog;
use App\Models\User;
use Illuminate\Http\Request;

class NotificationManagerController extends Controller
{
    public function index()
    {
        $queueCount = NotificationQueue::where('status', 'Pending')->count();
        $emailCount = EmailLog::whereDate('created_at', today())->count();
        $smsCount = SmsLog::whereDate('created_at', today())->count();

        $queueItems = NotificationQueue::latest()->limit(5)->get();
        $emailLogs = EmailLog::latest()->limit(5)->get();
        $smsLogs = SmsLog::latest()->limit(5)->get();

        return view('admin.communication.notifications.index', compact(
            'queueCount',
            'emailCount',
            'smsCount',
            'queueItems',
            'emailLogs',
            'smsLogs'
        ));
    }

    public function create()
    {
        return view('admin.communication.notifications.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'channel' => 'required|in:email,sms,both',
            'target_audience' => 'required|in:all,staff,student,parent',
        ]);

        $query = User::query()->where('is_active', true);

        // Filter by role except for 'all'
        if ($validated['target_audience'] !== 'all') {
            $query->where('role', $validated['target_audience']);
        }

        $recipients = $query->get();
        $count = 0;

        foreach ($recipients as $user) {

            // Queue Email
            if (in_array($validated['channel'], ['email', 'both']) && $user->email) {
                NotificationQueue::create([
                    'recipient_type' => 'Email',
                    'recipient_id' => $user->id,
                    'recipient_email' => $user->email,
                    'subject' => $validated['subject'],
                    'message' => $validated['message'],
                    'notification_type' => 'General',
                    'status' => 'Pending',
                ]);
            }

            // Queue SMS
            if (in_array($validated['channel'], ['sms', 'both']) && $user->phone) {
                NotificationQueue::create([
                    'recipient_type' => 'SMS',
                    'recipient_id' => $user->id,
                    'recipient_phone' => $user->phone, // Assumes phone column on user or linked profile
                    'subject' => 'SMS Notification',
                    'message' => strip_tags($validated['message']), // Strip HTML for SMS
                    'notification_type' => 'General',
                    'status' => 'Pending',
                ]);
            }
            $count++;
        }

        return redirect()->route('notifications.manager.index')
            ->with('success', "Notification queued for $count recipients.");
    }

    // Stub function to simulate processing the queue
    public function processQueue()
    {
        $pending = NotificationQueue::where('status', 'Pending')->limit(10)->get();
        $processed = 0;

        foreach ($pending as $item) {
            if ($item->recipient_type === 'Email') {
                // Simulating Email Send
                EmailLog::create([
                    'recipient_email' => $item->recipient_email,
                    'subject' => $item->subject,
                    'message' => $item->message,
                    'email_type' => $item->notification_type,
                    'status' => 'Sent',
                    'sent_at' => now(),
                    'created_by' => auth()->id(),
                ]);
            } elseif ($item->recipient_type === 'SMS') {
                // Simulating SMS Send
                SmsLog::create([
                    'recipient_phone' => $item->recipient_phone,
                    'message' => $item->message,
                    'sms_type' => $item->notification_type,
                    'status' => 'Sent',
                    'sent_at' => now(),
                    'created_by' => auth()->id(),
                ]);
            }

            $item->update(['status' => 'Sent', 'sent_at' => now()]);
            $processed++;
        }

        return back()->with('success', "Processed $processed queue items.");
    }
}
