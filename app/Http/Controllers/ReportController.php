<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\BorrowingDetail;
use App\Models\Product;

class ReportController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->latest()->get();

        $borrowings = Borrowing::with('details.product')
            ->latest()
            ->get();

        $totalProducts = Product::count();
        $totalStock = Product::sum('stock');
        $totalBorrowings = Borrowing::count();

        $totalBorrowedItems = BorrowingDetail::whereHas('borrowing', function ($query) {
            $query->where('status', 'borrowed');
        })->sum('quantity');

        $lowStockProducts = Product::with('category')
            ->where('stock', '<=', 5)
            ->get();

        return view('reports.index', compact(
            'products',
            'borrowings',
            'totalProducts',
            'totalStock',
            'totalBorrowings',
            'totalBorrowedItems',
            'lowStockProducts'
        ));
    }
}
