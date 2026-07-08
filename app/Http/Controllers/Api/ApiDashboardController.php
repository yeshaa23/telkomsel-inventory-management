<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use App\Models\BorrowingDetail;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class ApiDashboardController extends Controller
{
    public function index(): JsonResponse
    {
        $monthlyBorrowings = Borrowing::select('borrow_date')
            ->whereNotNull('borrow_date')
            ->get()
            ->groupBy(function ($borrowing) {
                return Carbon::parse($borrowing->borrow_date)->format('Y-m');
            })
            ->sortKeys()
            ->map(function ($items, string $period) {
                $date = Carbon::createFromFormat('Y-m-d', $period . '-01');

                return [
                    'period' => $period,
                    'label' => $date->translatedFormat('F Y'),
                    'month' => (int) $date->format('m'),
                    'year' => (int) $date->format('Y'),
                    'total' => $items->count(),
                ];
            })
            ->values();

        $categorySummaries = Product::select(
                'categories.name as category_name',
                DB::raw('COUNT(products.id) as total_product'),
                DB::raw('SUM(products.stock) as total_stock'),
                DB::raw('SUM(products.good_stock) as good_stock'),
                DB::raw('SUM(products.minor_damage_stock + products.major_damage_stock) as damaged_stock')
            )
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->groupBy('categories.name')
            ->orderBy('categories.name')
            ->get()
            ->map(function ($category) {
                return [
                    'category_name' => $category->category_name,
                    'total_product' => (int) $category->total_product,
                    'total_stock' => (int) $category->total_stock,
                    'good_stock' => (int) $category->good_stock,
                    'damaged_stock' => (int) $category->damaged_stock,
                ];
            });

        $topBorrowedProducts = BorrowingDetail::select(
                'products.name',
                'products.code',
                DB::raw('SUM(borrowing_details.quantity) as total_borrowed')
            )
            ->join('products', 'products.id', '=', 'borrowing_details.product_id')
            ->groupBy('products.id', 'products.name', 'products.code')
            ->orderByDesc('total_borrowed')
            ->limit(5)
            ->get()
            ->map(function ($product) {
                return [
                    'code' => $product->code,
                    'name' => $product->name,
                    'total_borrowed' => (int) $product->total_borrowed,
                ];
            });

        return response()->json([
            'success' => true,
            'message' => 'Dashboard data retrieved successfully',
            'data' => [
                'summary' => [
                    'total_products' => Product::count(),
                    'total_stock' => (int) Product::sum('stock'),
                    'available_stock' => (int) Product::sum('good_stock'),
                    'damaged_stock' => (int) Product::sum('minor_damage_stock') + (int) Product::sum('major_damage_stock'),
                    'borrowed_items' => (int) BorrowingDetail::whereHas('borrowing', function ($query) {
                        $query->where('status', 'borrowed');
                    })->sum('quantity'),
                    'low_stock_products' => Product::whereBetween('good_stock', [1, 5])->count(),
                    'out_of_stock_products' => Product::where('good_stock', '<=', 0)->count(),
                    'overdue_borrowings' => Borrowing::where('status', 'borrowed')
                        ->whereNotNull('due_date')
                        ->whereDate('due_date', '<', now()->toDateString())
                        ->count(),
                ],
                'monthly_borrowings' => $monthlyBorrowings,
                'category_summaries' => $categorySummaries,
                'top_borrowed_products' => $topBorrowedProducts,
            ],
        ]);
    }
}
