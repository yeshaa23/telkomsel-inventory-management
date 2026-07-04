<?php
use Illuminate\Foundation\Testing\RefreshDatabase;
uses(Tests\TestCase::class, RefreshDatabase::class);
use App\Models\Borrowing;

test('borrowing status is overdue when due date has passed and status is borrowed', function () {
    $borrowing = new Borrowing([
        'borrow_date' => now()->subDays(5),
        'due_date' => now()->subDay(),
        'status' => 'borrowed',
    ]);

    expect($borrowing->display_status)->toBe('overdue');
    expect($borrowing->display_status_label)->toBe('Terlambat');
});

test('borrowing status is returned when borrowing has been returned', function () {
    $borrowing = new Borrowing([
        'borrow_date' => now()->subDays(5),
        'due_date' => now()->subDay(),
        'status' => 'returned',
    ]);

    expect($borrowing->display_status)->toBe('returned');
    expect($borrowing->display_status_label)->toBe('Dikembalikan');
});

test('borrowing status is borrowed when due date has not passed', function () {
    $borrowing = new Borrowing([
        'borrow_date' => now()->toDateString(),
        'due_date' => now()->addDays(3)->toDateString(),
        'status' => 'borrowed',
    ]);

    expect($borrowing->display_status)->toBe('borrowed');
    expect($borrowing->display_status_label)->toBe('Dipinjam');
});
