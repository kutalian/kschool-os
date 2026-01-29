<?php

namespace App\Services;

use App\Models\Book;
use App\Models\BookIssue;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LibraryService
{
    /**
     * Issue a book to a user.
     * Decrements available copies.
     * @throws \Exception
     */
    public function issueBook(int $bookId, int $userId, string $dueDate): BookIssue
    {
        return DB::transaction(function () use ($bookId, $userId, $dueDate) {
            // Lock book row for update to prevent race conditions on stock
            $book = Book::lockForUpdate()->find($bookId);

            if (!$book) {
                throw new \Exception("Book not found.");
            }

            if ($book->available_copies < 1) {
                throw new \Exception("Book is not available currently.");
            }

            // Member limit check
            $activeIssues = BookIssue::where('user_id', $userId)
                ->where('status', 'issued')
                ->count();

            if ($activeIssues >= 5) { // Limit ideally simpler to configure
                throw new \Exception("User has reached the maximum borrowing limit of 5 books.");
            }

            $issue = BookIssue::create([
                'book_id' => $bookId,
                'user_id' => $userId,
                'issue_date' => Carbon::now(),
                'due_date' => Carbon::parse($dueDate), // Ensure Carbon instance
                'status' => 'issued',
            ]);

            $book->decrement('available_copies');

            return $issue;
        });
    }

    /**
     * Staff requests a book.
     * Decrements available copies (effectively reserving it).
     */
    public function requestBook(int $bookId, int $userId): BookIssue
    {
        return DB::transaction(function () use ($bookId, $userId) {
            $book = Book::lockForUpdate()->find($bookId);

            if (!$book || $book->available_copies < 1) {
                throw new \Exception("Book is not available for request.");
            }

            // Check if user already has a pending request or active issue for this book
            $existing = BookIssue::where('book_id', $bookId)
                ->where('user_id', $userId)
                ->whereIn('status', ['requested', 'issued'])
                ->exists();

            if ($existing) {
                throw new \Exception("You already have this book or a pending request for it.");
            }

            $issue = BookIssue::create([
                'book_id' => $bookId,
                'user_id' => $userId,
                'status' => 'requested',
            ]);

            $book->decrement('available_copies');

            return $issue;
        });
    }

    /**
     * Approve a pending request.
     */
    public function approveRequest(int $issueId, string $dueDate): BookIssue
    {
        return DB::transaction(function () use ($issueId, $dueDate) {
            $issue = BookIssue::lockForUpdate()->find($issueId);

            if (!$issue || $issue->status !== 'requested') {
                throw new \Exception("Invalid request.");
            }

            $issue->update([
                'issue_date' => Carbon::now(),
                'due_date' => Carbon::parse($dueDate),
                'status' => 'issued',
            ]);

            return $issue;
        });
    }

    /**
     * Cancel a request.
     * Increments available copies.
     */
    public function cancelRequest(int $issueId): void
    {
        DB::transaction(function () use ($issueId) {
            $issue = BookIssue::lockForUpdate()->find($issueId);

            if (!$issue || $issue->status !== 'requested') {
                throw new \Exception("Invalid request.");
            }

            $issue->book->increment('available_copies');
            $issue->delete();
        });
    }

    /**
     * Return a book.
     * Increments available copies.
     * Calculates fine if overdue.
     */
    public function returnBook(int $issueId, ?string $returnCondition = null): array
    {
        return DB::transaction(function () use ($issueId, $returnCondition) {
            $issue = BookIssue::lockForUpdate()->find($issueId);

            if (!$issue) {
                throw new \Exception("Book issue record not found.");
            }

            if ($issue->status !== 'issued') {
                throw new \Exception("Book is already returned.");
            }

            $returnDate = Carbon::now();
            $fine = 0;

            // Calculate Fine
            if ($returnDate->startOfDay()->gt($issue->due_date)) {
                $daysOverdue = $returnDate->startOfDay()->diffInDays($issue->due_date);
                $finePerDay = 100; // Configurable ideally, hardcoded for now
                $fine = $daysOverdue * $finePerDay;
            }

            $issue->update([
                'status' => 'returned',
                'return_date' => $returnDate,
                'return_condition' => $returnCondition,
                'remarks' => $fine > 0 ? "Fine of ₦{$fine} applied for late return." : null,
            ]);

            $issue->book->increment('available_copies');

            return [
                'issue' => $issue,
                'fine' => $fine
            ];
        });
    }
}
