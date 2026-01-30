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

    public function createBackup()
    {
        $backupPath = 'backups/' . date('Y-m-d_H-i-s') . '_full.sql';

        $log = BackupLog::create([
            'backup_type' => 'Full',
            'status' => 'In Progress',
            'started_at' => now(),
            'created_by' => auth()->id(),
            'backup_path' => $backupPath,
        ]);

        try {
            $config = config('database.connections.mysql');
            $database = $config['database'];
            $username = $config['username'];
            $password = $config['password'];
            $host = $config['host'];

            $storagePath = storage_path('app/' . $backupPath);
            $directory = dirname($storagePath);

            if (!is_dir($directory)) {
                mkdir($directory, 0755, true);
            }

            // Path detection for mysqldump
            $mysqldumpPath = 'mysqldump';
            if (PHP_OS_FAMILY === 'Windows') {
                $possiblePaths = [
                    'C:\xampp\mysql\bin\mysqldump.exe',
                    'D:\xampp\mysql\bin\mysqldump.exe',
                    'C:\Program Files\MySQL\MySQL Server 8.0\bin\mysqldump.exe',
                ];
                foreach ($possiblePaths as $p) {
                    if (file_exists($p)) {
                        $mysqldumpPath = '"' . $p . '"';
                        break;
                    }
                }
            }

            // Using mysqldump.
            $command = sprintf(
                '%s --user=%s --password=%s --host=%s %s > %s 2>&1',
                $mysqldumpPath,
                escapeshellarg($username),
                escapeshellarg($password),
                escapeshellarg($host),
                escapeshellarg($database),
                escapeshellarg($storagePath)
            );

            $output = [];
            $resultCode = null;
            exec($command, $output, $resultCode);

            if ($resultCode === 0) {
                $log->update([
                    'status' => 'Completed',
                    'completed_at' => now(),
                    'file_size' => file_exists($storagePath) ? filesize($storagePath) : 0,
                ]);
                return back()->with('success', 'Backup created successfully.');
            } else {
                $log->update([
                    'status' => 'Failed',
                    'completed_at' => now(),
                    'error_message' => implode("\n", $output),
                ]);
                return back()->with('error', 'Backup failed. Check logs for details.');
            }
        } catch (\Exception $e) {
            $log->update([
                'status' => 'Failed',
                'completed_at' => now(),
                'error_message' => $e->getMessage(),
            ]);
            return back()->with('error', 'Backup failed: ' . $e->getMessage());
        }
    }

    public function downloadBackup($id)
    {
        $log = BackupLog::findOrFail($id);

        $storagePath = storage_path('app/' . $log->backup_path);

        if ($log->status !== 'Completed' || !file_exists($storagePath)) {
            return back()->with('error', 'Backup file not found.');
        }

        return response()->download($storagePath);
    }
}
