<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\BookIssue;
use App\Services\LibraryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LibraryController extends Controller
{
    protected $libraryService;

    public function __construct(LibraryService $libraryService)
    {
        $this->libraryService = $libraryService;
    }

    public function index()
    {
        $bookIssues = BookIssue::where('user_id', Auth::id())
            ->with('book')
            ->latest('created_at')
            ->paginate(10);

        return view('staff.library.index', compact('bookIssues'));
    }

    public function available(Request $request)
    {
        $query = Book::with('category')->where('available_copies', '>', 0);

        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                    ->orWhere('author', 'LIKE', "%{$search}%")
                    ->orWhere('isbn', 'LIKE', "%{$search}%");
            });
        }

        $books = $query->paginate(12);
        return view('staff.library.available', compact('books'));
    }

    public function requestBook(Book $book)
    {
        try {
            $this->libraryService->requestBook($book->id, Auth::id());
            return redirect()->route('staff.library.index')->with('success', 'Book requested successfully. You can pick it up from the library later.');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
