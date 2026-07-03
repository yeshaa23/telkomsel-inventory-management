<?php

use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->middleware('role:Admin,Staff,Manager')
        ->name('dashboard');

    Route::resource('categories', CategoryController::class)
        ->middleware('role:Admin,Staff');

    Route::resource('products', ProductController::class)
        ->middleware('role:Admin,Staff');

    Route::resource('borrowings', BorrowingController::class)
        ->middleware('role:Admin,Staff');

    Route::patch('/borrowings/{borrowing}/return', [BorrowingController::class, 'returnItem'])
        ->middleware('role:Admin,Staff')
        ->name('borrowings.return');

    Route::get('/reports', [ReportController::class, 'index'])
        ->middleware('role:Admin,Manager')
        ->name('reports.index');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
