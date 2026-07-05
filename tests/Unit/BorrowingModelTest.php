<?php

use App\Models\Borrowing;

uses(Tests\TestCase::class);

test('borrowing status is overdue when due date has passed and status is borrowed', function () {
    $borrowing = new Borrowing([
        'borrow_date' => now()->subDays(5)->toDateString(),
        'due_date' => now()->subDay()->toDateString(),
        'status' => 'borrowed',
    ]);

    expect($borrowing->display_status)->toBe('overdue');
    expect($borrowing->display_status_label)->toBeIn([
        'Overdue',
        'Terlambat',
    ]);
});

test('borrowing status is returned when borrowing has been returned', function () {
    $borrowing = new Borrowing([
        'borrow_date' => now()->subDays(5)->toDateString(),
        'due_date' => now()->subDay()->toDateString(),
        'status' => 'returned',
    ]);

    expect($borrowing->display_status)->toBe('returned');
    expect($borrowing->display_status_label)->toBeIn([
        'Returned',
        'Dikembalikan',
    ]);
});

test('borrowing status is borrowed when due date has not passed', function () {
    $borrowing = new Borrowing([
        'borrow_date' => now()->toDateString(),
        'due_date' => now()->addDays(3)->toDateString(),
        'status' => 'borrowed',
    ]);

    expect($borrowing->display_status)->toBe('borrowed');
    expect($borrowing->display_status_label)->toBeIn([
        'Borrowed',
        'Dipinjam',
    ]);
});
