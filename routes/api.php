<?php

use App\Http\Controllers\Api\ApiBorrowingController;
use App\Http\Controllers\Api\ApiCategoryController;
use App\Http\Controllers\Api\ApiDashboardController;
use App\Http\Controllers\Api\ApiProductController;
use Illuminate\Support\Facades\Route;

Route::get('/dashboard', [ApiDashboardController::class, 'index']);

Route::get('/products', [ApiProductController::class, 'index']);
Route::get('/products/{product}', [ApiProductController::class, 'show']);

Route::get('/categories', [ApiCategoryController::class, 'index']);

Route::get('/borrowings', [ApiBorrowingController::class, 'index']);
Route::get('/borrowings/{borrowing}', [ApiBorrowingController::class, 'show']);
