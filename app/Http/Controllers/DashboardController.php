<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\BorrowingDetail;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $availableStock = Product::sum('stock');

        $borrowedItems = BorrowingDetail::whereHas('borrowing', function ($query) {
            $query->where('status', 'borrowed');
        })->sum('quantity');

        $lowStockProducts = Product::with('category')
            ->whereBetween('stock', [1, 5])
            ->get();

        $outOfStockProducts = Product::with('category')
            ->where('stock', '<=', 0)
            ->get();

        $damagedProducts = Product::with('category')
            ->where('condition', '!=', 'Baik')
            ->get();

        $overdueBorrowings = Borrowing::with('details.product')
            ->where('status', 'borrowed')
            ->whereNotNull('due_date')
            ->whereDate('due_date', '<', now())
            ->latest()
            ->get();

        $monthlyBorrowings = Borrowing::select(
                DB::raw('MONTH(borrow_date) as month'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $categorySummaries = Product::select(
                'categories.name as category_name',
                DB::raw('COUNT(products.id) as total_product'),
                DB::raw('SUM(products.stock) as total_stock')
            )
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->groupBy('categories.name')
            ->orderBy('categories.name')
            ->get();

        $topBorrowedProducts = BorrowingDetail::select(
                'products.name',
                'products.code',
                DB::raw('SUM(borrowing_details.quantity) as total_borrowed')
            )
            ->join('products', 'products.id', '=', 'borrowing_details.product_id')
            ->groupBy('products.id', 'products.name', 'products.code')
            ->orderByDesc('total_borrowed')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'totalProducts',
            'availableStock',
            'borrowedItems',
            'lowStockProducts',
            'outOfStockProducts',
            'damagedProducts',
            'overdueBorrowings',
            'monthlyBorrowings',
            'categorySummaries',
            'topBorrowedProducts'
        ));
    }
}
