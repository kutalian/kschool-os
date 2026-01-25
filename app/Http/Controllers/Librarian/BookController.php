<?php

namespace App\Http\Controllers\Librarian;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\BookCategory;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::with('category');

        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('author', 'like', "%{$search}%")
                    ->orWhere('isbn', 'like', "%{$search}%");
            });
        }

        $books = $query->latest()->paginate(10);
        return view('librarian.books.index', compact('books'));
    }

    public function create()
    {
        $categories = BookCategory::all();
        return view('librarian.books.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'nullable|string|max:20|unique:books,isbn',
            'publisher' => 'nullable|string|max:255',
            'category_id' => 'required|exists:book_categories,id',
            'quantity' => 'required|integer|min:1',
            'cover_image' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('books', 'public');
            $validated['cover_image'] = $path;
        }

        $validated['available_copies'] = $validated['quantity'];

        Book::create($validated);

        return redirect()->route('librarian.books.index')->with('success', 'Book added successfully.');
    }

    public function edit(Book $book)
    {
        $categories = BookCategory::all();
        return view('librarian.books.edit', compact('book', 'categories'));
    }

    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => 'nullable|string|max:20|unique:books,isbn,' . $book->id,
            'publisher' => 'nullable|string|max:255',
            'category_id' => 'required|exists:book_categories,id',
            'quantity' => 'required|integer|min:1',
            'cover_image' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('books', 'public');
            $validated['cover_image'] = $path;
        }

        // Adjust available copies based on quantity change
        $qtyDiff = $validated['quantity'] - $book->quantity;
        $validated['available_copies'] = $book->available_copies + $qtyDiff;

        $book->update($validated);

        return redirect()->route('librarian.books.index')->with('success', 'Book updated successfully.');
    }

    public function destroy(Book $book)
    {
        if ($book->issues()->where('status', 'issued')->exists()) {
            return back()->with('error', 'Cannot delete book with active issues.');
        }

        $book->delete();
        return redirect()->route('librarian.books.index')->with('success', 'Book deleted successfully.');
    }
}
