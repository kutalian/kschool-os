<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BookCategory;
use App\Models\Book;
use App\Models\BookIssue;
use App\Models\User;
use Carbon\Carbon;

class LibrarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create Categories
        $categories = [
            'Fiction' => 'Novels, stories and imaginative works',
            'Science' => 'Physics, Chemistry, Biology',
            'Mathematics' => 'Algebra, Calculus, Geometry',
            'Literature' => 'Classic and modern literature',
            'Technology' => 'Computer Science, AI, Engineering',
            'History' => 'World History, Civilizations',
        ];

        $catIds = [];
        foreach ($categories as $name => $desc) {
            $cat = BookCategory::firstOrCreate(
                ['name' => $name],
                ['description' => $desc]
            );
            $catIds[$name] = $cat->id;
        }

        // 2. Create Books
        $books = [
            // Fiction
            ['title' => 'To Kill a Mockingbird', 'author' => 'Harper Lee', 'cat' => 'Fiction', 'qty' => 5],
            ['title' => 'The Great Gatsby', 'author' => 'F. Scott Fitzgerald', 'cat' => 'Fiction', 'qty' => 3],
            // Science
            ['title' => 'A Brief History of Time', 'author' => 'Stephen Hawking', 'cat' => 'Science', 'qty' => 4],
            ['title' => 'The Selfish Gene', 'author' => 'Richard Dawkins', 'cat' => 'Science', 'qty' => 2],
            // Math
            ['title' => 'Calculus: Early Transcendentals', 'author' => 'James Stewart', 'cat' => 'Mathematics', 'qty' => 10],
            // Tech
            ['title' => 'Clean Code', 'author' => 'Robert C. Martin', 'cat' => 'Technology', 'qty' => 6],
            ['title' => 'Introduction to Algorithms', 'author' => 'Cormen et al.', 'cat' => 'Technology', 'qty' => 4],
            // History
            ['title' => 'Sapiens: A Brief History of Humankind', 'author' => 'Yuval Noah Harari', 'cat' => 'History', 'qty' => 8],
        ];

        foreach ($books as $b) {
            Book::firstOrCreate(
                ['title' => $b['title']],
                [
                    'author' => $b['author'],
                    'category_id' => $catIds[$b['cat']],
                    'quantity' => $b['qty'],
                    'available_copies' => $b['qty'], // Initially all available
                    'shelf_location' => 'Shelf ' . rand(1, 10) . '-' . chr(rand(65, 90)),
                    'isbn' => rand(1000000000, 9999999999),
                ]
            );
        }

        // 3. Issue some books
        $users = User::where('role', 'student')->inRandomOrder()->limit(5)->get();
        $booksDb = Book::all();

        if ($users->count() > 0 && $booksDb->count() > 0) {
            foreach ($users as $user) {
                $book = $booksDb->random();
                if ($book->available_copies > 0) {
                    BookIssue::create([
                        'book_id' => $book->id,
                        'user_id' => $user->id,
                        'issue_date' => Carbon::now()->subDays(rand(1, 10)),
                        'due_date' => Carbon::now()->addDays(rand(5, 14)),
                        'status' => 'issued'
                    ]);
                    $book->decrement('available_copies');
                }
            }
        }
    }
}
