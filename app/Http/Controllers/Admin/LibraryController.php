<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\BookCategory;
use App\Models\BookIssue;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LibraryController extends Controller
{
    public function index(Request $request)
    {
        $view = $request->get('view', 'books'); // 'books', 'categories', 'issued'

        if ($view === 'categories') {
            $categories = BookCategory::withCount('books')->get();
            return view('admin.library.index', compact('categories', 'view'));
        } elseif ($view === 'issued') {
            $issues = BookIssue::with(['book', 'user'])
                ->where('status', 'issued')
                ->orderBy('due_date', 'asc')
                ->get();
            return view('admin.library.index', compact('issues', 'view'));
        } else {
            // Books list
            $books = Book::with('category')->latest()->get();
            $categories = BookCategory::all(); // For filter/add modal
            return view('admin.library.index', compact('books', 'categories', 'view'));
        }
    }

    public function store_book(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category_id' => 'required|exists:book_categories,id',
            'quantity' => 'required|integer|min:1',
            'shelf_location' => 'nullable|string',
            'isbn' => 'nullable|string',
            'cover_image' => 'nullable|image|max:2048', // 2MB Max
        ]);

        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('books', 'public');
            $validated['cover_image'] = $path;
        }

        $validated['available_copies'] = $validated['quantity'];

        Book::create($validated);

        return redirect()->back()->with('success', 'Book added successfully.');
    }

    public function store_category(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:book_categories,name|max:255',
        ]);

        BookCategory::create($validated);

        return redirect()->back()->with('success', 'Category added successfully.');
    }

    public function create_issue(Book $book)
    {
        return view('admin.library.issue', compact('book'));
    }

    public function history(Book $book)
    {
        $history = BookIssue::with('user')
            ->where('book_id', $book->id)
            ->latest()
            ->paginate(20);

        return view('admin.library.history', compact('book', 'history'));
    }

    public function all_history()
    {
        $history = BookIssue::with(['book', 'user'])
            ->latest()
            ->paginate(20);

        return view('admin.library.history', compact('history'));
    }

    public function issue_book(Request $request)
    {
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
            'user_id' => 'required|exists:users,id',
            'due_date' => 'required|date|after:today',
        ]);

        DB::transaction(function () use ($validated) {
            $book = Book::lockForUpdate()->find($validated['book_id']);

            if ($book->available_copies < 1) {
                // throw new \Exception('Book is not available currently.');
                return redirect()->back()->with('error', 'Book is not available currently.');
            }

            BookIssue::create([
                'book_id' => $validated['book_id'],
                'user_id' => $validated['user_id'],
                'issue_date' => Carbon::now(),
                'due_date' => $validated['due_date'],
                'status' => 'issued',
            ]);

            $book->decrement('available_copies');
        });

        if (session('error')) {
            return redirect()->back()->with('error', session('error'));
        }

        return redirect()->back()->with('success', 'Book issued successfully.');
    }

    public function return_book(Request $request)
    {
        $request->validate([
            'issue_id' => 'required|exists:book_issues,id',
            'return_condition' => 'nullable|string|max:255',
        ]);

        DB::transaction(function () use ($request) {
            $issue = BookIssue::lockForUpdate()->find($request->issue_id);

            if ($issue->status !== 'issued') {
                return; // Already returned
            }

            $issue->update([
                'status' => 'returned',
                'return_date' => Carbon::now(),
                'return_condition' => $request->return_condition,
            ]);

            $issue->book->increment('available_copies');
        });

        return redirect()->back()->with('success', 'Book returned successfully.');
    }

    public function edit(Book $book)
    {
        $categories = BookCategory::all();
        return view('admin.library.edit', compact('book', 'categories'));
    }

    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category_id' => 'required|exists:book_categories,id',
            'quantity' => 'required|integer|min:1',
            'shelf_location' => 'nullable|string',
            'isbn' => 'nullable|string',
        ]);

        // Adjust available copies if total quantity changed
        if ($book->quantity != $validated['quantity']) {
            $diff = $validated['quantity'] - $book->quantity;
            $validated['available_copies'] = $book->available_copies + $diff;

            if ($validated['available_copies'] < 0) {
                return redirect()->back()->with('error', 'Cannot reduce quantity below currently issued amount.');
            }
        }

        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('books', 'public');
            $validated['cover_image'] = $path;
        }

        $book->update($validated);

        return redirect()->route('library.index', ['view' => 'books'])->with('success', 'Book updated successfully.');
    }

    public function confirm_delete(Book $book)
    {
        $activeIssues = $book->issues()->where('status', 'issued')->count();
        $totalHistory = $book->issues()->count();

        return view('admin.library.delete', compact('book', 'activeIssues', 'totalHistory'));
    }

    public function destroy(Book $book)
    {
        if ($book->available_copies != $book->quantity) {
            return redirect()->back()->with('error', 'Cannot delete book while copies are issued.');
        }

        $book->delete();

        return redirect()->route('library.index', ['view' => 'books'])->with('success', 'Book deleted successfully.');
    }

    public function search_users(Request $request)
    {
        $query = $request->get('q');

        $users = User::whereIn('role', ['student', 'staff'])
            ->where(function ($q) use ($query) {
                $q->where('username', 'LIKE', "%{$query}%")
                    ->orWhere('email', 'LIKE', "%{$query}%")
                    ->orWhereHas('student', function ($subQ) use ($query) {
                        $subQ->where('name', 'LIKE', "%{$query}%");
                    })
                    ->orWhereHas('staff', function ($subQ) use ($query) {
                        $subQ->where('name', 'LIKE', "%{$query}%");
                    });
            })
            ->limit(10)
            ->get();

        // Transform for frontend
        $results = $users->map(function ($user) {
            $name = $user->username;
            if ($user->student)
                $name .= " (" . $user->student->name . ")";
            if ($user->staff)
                $name .= " (" . $user->staff->name . ")";

            return [
                'id' => $user->id,
                'username' => $name, // Display name
                'role' => $user->role
            ];
        });

        return response()->json($results);
    }


}
