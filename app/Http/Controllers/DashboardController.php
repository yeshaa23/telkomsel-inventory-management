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

        $lowStockProducts = Product::where('stock', '<=', 5)->get();

        $monthlyBorrowings = Borrowing::select(
                DB::raw('MONTH(borrow_date) as month'),
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return view('dashboard', compact(
            'totalProducts',
            'availableStock',
            'borrowedItems',
            'lowStockProducts',
            'monthlyBorrowings'
        ));
    }
}
