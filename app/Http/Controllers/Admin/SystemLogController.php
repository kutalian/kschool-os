<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\BackupLog;
use App\Models\LoginHistory;
use Illuminate\Http\Request;

class SystemLogController extends Controller
{
    public function activity()
    {
        $logs = ActivityLog::with('user')->latest('created_at')->paginate(20);
        return view('admin.system.activity', compact('logs'));
    }

    public function loginHistory()
    {
        $logs = LoginHistory::with('user')->latest('login_time')->paginate(20);
        return view('admin.system.login-history', compact('logs'));
    }

    public function backups()
    {
        $logs = BackupLog::with('creator')->latest('started_at')->paginate(20);
        return view('admin.system.backups', compact('logs'));
    }
}
