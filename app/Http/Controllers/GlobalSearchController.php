<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Borrowing;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GlobalSearchController extends Controller
{
    public function index(Request $request): View
    {
        $query = trim((string) $request->input('q', ''));
        $user = $request->user();

        $products = collect();
        $categories = collect();
        $borrowings = collect();
        $activityLogs = collect();

        if ($query !== '') {
            if ($user->hasRole(['Admin', 'Staff'])) {
                $products = Product::with('category')
                    ->where(function ($builder) use ($query) {
                        $builder
                            ->where('code', 'like', "%{$query}%")
                            ->orWhere('name', 'like', "%{$query}%")
                            ->orWhere('location', 'like', "%{$query}%")
                            ->orWhere('condition', 'like', "%{$query}%")
                            ->orWhereHas('category', function ($categoryQuery) use ($query) {
                                $categoryQuery->where('name', 'like', "%{$query}%");
                            });
                    })
                    ->latest()
                    ->limit(6)
                    ->get();

                $categories = Category::where('name', 'like', "%{$query}%")
                    ->orWhere('description', 'like', "%{$query}%")
                    ->latest()
                    ->limit(6)
                    ->get();

                $borrowings = Borrowing::with('details.product')
                    ->where(function ($builder) use ($query) {
                        $builder
                            ->where('borrower_name', 'like', "%{$query}%")
                            ->orWhere('division', 'like', "%{$query}%")
                            ->orWhere('status', 'like', "%{$query}%")
                            ->orWhereDate('borrow_date', $query)
                            ->orWhereDate('due_date', $query)
                            ->orWhereDate('return_date', $query)
                            ->orWhereHas('details.product', function ($productQuery) use ($query) {
                                $productQuery
                                    ->where('name', 'like', "%{$query}%")
                                    ->orWhere('code', 'like', "%{$query}%")
                                    ->orWhere('location', 'like', "%{$query}%");
                            });
                    })
                    ->latest()
                    ->limit(6)
                    ->get();
            }

            if ($user->hasRole('Admin')) {
                $activityLogs = ActivityLog::with('user')
                    ->where(function ($builder) use ($query) {
                        $builder
                            ->where('action', 'like', "%{$query}%")
                            ->orWhere('module', 'like', "%{$query}%")
                            ->orWhere('description', 'like', "%{$query}%")
                            ->orWhereHas('user', function ($userQuery) use ($query) {
                                $userQuery
                                    ->where('name', 'like', "%{$query}%")
                                    ->orWhere('email', 'like', "%{$query}%");
                            });
                    })
                    ->latest()
                    ->limit(6)
                    ->get();
            }
        }

        $totalResults =
            $products->count()
            + $categories->count()
            + $borrowings->count()
            + $activityLogs->count();

        return view('search.index', [
            'query' => $query,
            'products' => $products,
            'categories' => $categories,
            'borrowings' => $borrowings,
            'activityLogs' => $activityLogs,
            'totalResults' => $totalResults,
        ]);
    }
}
