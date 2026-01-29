<?php

namespace App\Http\Controllers\Librarian;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\BookIssue;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBooks = Book::count();
        $issuedBooks = BookIssue::where('status', 'issued')->count();
        $overdueBooks = BookIssue::where('status', 'issued')
            ->where('due_date', '<', now())
            ->count();

        $pendingRequests = BookIssue::where('status', 'requested')->count();

        // Recent Issues
        $recentIssues = BookIssue::with(['book', 'student', 'user'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('librarian.dashboard', compact('totalBooks', 'issuedBooks', 'overdueBooks', 'recentIssues', 'pendingRequests'));
    }
}
