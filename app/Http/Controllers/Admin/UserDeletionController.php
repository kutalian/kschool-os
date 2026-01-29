<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserDeletionController extends Controller
{
    public function index()
    {
        $requests = User::whereNotNull('deletion_requested_at')
            ->orderBy('deletion_requested_at', 'desc')
            ->paginate(15);

        return view('admin.users.deletions', compact('requests'));
    }

    public function approve(User $user)
    {
        if (!$user->deletion_requested_at) {
            return redirect()->back()->with('error', 'No deletion request found for this user.');
        }

        DB::transaction(function () use ($user) {
            // Delete associated staff, student, or parent record if exists
            if ($user->staff)
                $user->staff->delete();
            if ($user->student)
                $user->student->delete();
            if ($user->parent)
                $user->parent->delete();

            $user->delete();
        });

        return redirect()->back()->with('success', 'User account permanently deleted.');
    }

    public function reject(User $user)
    {
        if (!$user->deletion_requested_at) {
            return redirect()->back()->with('error', 'No deletion request found for this user.');
        }

        $user->update([
            'deletion_requested_at' => null,
            'deletion_reason' => null,
        ]);

        return redirect()->back()->with('success', 'Deletion request rejected. User account restored.');
    }
}
