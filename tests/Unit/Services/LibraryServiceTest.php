<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Services\LibraryService;
use App\Models\Book;
use App\Models\BookIssue;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

class LibraryServiceTest extends TestCase
{
    use RefreshDatabase;

    protected LibraryService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new LibraryService();
    }

    public function test_it_can_issue_book_successfully()
    {
        $book = Book::factory()->create(['quantity' => 5, 'available_copies' => 5]);
        $user = User::factory()->create();

        $issue = $this->service->issueBook($book->id, $user->id, now()->addDays(7));

        $this->assertDatabaseHas('book_issues', ['id' => $issue->id, 'status' => 'issued']);
        $this->assertDatabaseHas('books', ['id' => $book->id, 'available_copies' => 4]);
    }

    public function test_it_throws_exception_if_book_unavailable()
    {
        $book = Book::factory()->create(['quantity' => 5, 'available_copies' => 0]);
        $user = User::factory()->create();

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Book is not available currently.");

        $this->service->issueBook($book->id, $user->id, now()->addDays(7));
    }

    public function test_it_calculates_fine_for_late_return()
    {
        $book = Book::factory()->create(['available_copies' => 0]); // Assuming issued
        $user = User::factory()->create();

        // Create an overdue issue
        $issue = BookIssue::create([
            'book_id' => $book->id,
            'user_id' => $user->id,
            'issue_date' => now()->subDays(10),
            'due_date' => now()->subDays(3), // 3 days overdue
            'status' => 'issued'
        ]);

        $result = $this->service->returnBook($issue->id);

        $this->assertEquals(300, $result['fine']); // 3 days * 100
        $this->assertEquals('returned', $result['issue']->status);
        $this->assertEquals(1, $book->fresh()->available_copies);
    }
}
