<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\JsonResponse;

class ApiCategoryController extends Controller
{
    public function index(): JsonResponse
    {
        $categories = Category::withCount('products')
            ->orderBy('name')
            ->get()
            ->map(function (Category $category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'description' => $category->description,
                    'total_products' => $category->products_count,
                    'created_at' => optional($category->created_at)->toDateTimeString(),
                    'updated_at' => optional($category->updated_at)->toDateTimeString(),
                ];
            });

        return response()->json([
            'success' => true,
            'message' => 'Category list retrieved successfully',
            'data' => $categories,
        ]);
    }
}
