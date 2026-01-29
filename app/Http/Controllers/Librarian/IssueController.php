<?php

namespace App\Http\Controllers\Librarian;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\BookIssue;
use App\Models\Student;
use App\Models\User;
use App\Services\LibraryService;

class IssueController extends Controller
{
    protected $libraryService;

    public function __construct(LibraryService $libraryService)
    {
        $this->libraryService = $libraryService;
    }

    public function index()
    {
        $requests = BookIssue::where('status', 'requested')
            ->with(['book', 'user'])
            ->latest()
            ->paginate(15);

        return view('librarian.issue.index', compact('requests'));
    }
    public function create()
    {
        $books = Book::where('available_copies', '>', 0)->get();
        // Ideally we should search students via AJAX, but for now loading all students
        $students = Student::all();

        return view('librarian.issue.create', compact('books', 'students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'student_id' => 'required|exists:students,id',
            'due_date' => 'required|date|after:today',
        ]);

        $book = Book::find($request->book_id);

        if ($book->available_copies < 1) {
            return back()->with('error', 'Book is currently unavailable.');
        }

        // Check if student already has this book issued
        $existingIssue = BookIssue::where('book_id', $book->id)
            ->where('user_id', Student::find($request->student_id)->user_id ?? 0) // Assuming user_id linkage specific logic might vary
            ->where('status', 'issued')
            ->exists();

        // Note: The schema links book_issues to `user_id`. We need to get the User ID from the Student.
        $student = Student::findOrFail($request->student_id);
        $userId = $student->user_id; // Check if student model has user_id. If not, we might need a workaround or schema adjustment.

        if (!$userId) {
            // Fallback or Error: This depends on if Student is always a User. 
            // In this ERP, Students are Users.
            return back()->with('error', 'Selected student does not have a valid user account.');
        }

        BookIssue::create([
            'book_id' => $book->id,
            'user_id' => $userId,
            'issue_date' => now(),
            'due_date' => $request->due_date,
            'status' => 'issued',
            'remarks' => $request->remarks,
        ]);

        $book->decrement('available_copies');

        return redirect()->route('librarian.dashboard')->with('success', 'Book issued successfully.');
    }

    public function returnBook($id)
    {
        $issue = BookIssue::findOrFail($id);

        if ($issue->status != 'issued') {
            return back()->with('error', 'Book is already returned or lost.');
        }

        $issue->update([
            'return_date' => now(),
            'status' => 'returned'
        ]);

        $issue->book->increment('available_copies');

        return back()->with('success', 'Book returned successfully.');
    }

    public function approve(Request $request, $id)
    {
        $request->validate([
            'due_date' => 'required|date|after:today'
        ]);

        try {
            $this->libraryService->approveRequest($id, $request->due_date);
            return back()->with('success', 'Request approved and book issued.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function cancel($id)
    {
        try {
            $this->libraryService->cancelRequest($id);
            return back()->with('success', 'Request cancelled and book returned to stock.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
