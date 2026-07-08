<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiProductController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'category_id' => ['nullable', 'integer', 'exists:categories,id'],
            'status' => ['nullable', 'in:available,low_stock,out_of_stock,damaged'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
        ]);

        $products = Product::with('category')
            ->when(! empty($validated['search']), function ($query) use ($validated) {
                $search = $validated['search'];

                $query->where(function ($query) use ($search) {
                    $query->where('code', 'like', "%{$search}%")
                        ->orWhere('name', 'like', "%{$search}%")
                        ->orWhere('location', 'like', "%{$search}%")
                        ->orWhereHas('category', function ($categoryQuery) use ($search) {
                            $categoryQuery->where('name', 'like', "%{$search}%");
                        });
                });
            })
            ->when(! empty($validated['category_id']), function ($query) use ($validated) {
                $query->where('category_id', $validated['category_id']);
            })
            ->when(! empty($validated['status']), function ($query) use ($validated) {
                match ($validated['status']) {
                    'available' => $query->where('good_stock', '>', 5),
                    'low_stock' => $query->whereBetween('good_stock', [1, 5]),
                    'out_of_stock' => $query->where('good_stock', '<=', 0),
                    'damaged' => $query->where(function ($query) {
                        $query->where('minor_damage_stock', '>', 0)
                            ->orWhere('major_damage_stock', '>', 0);
                    }),
                };
            })
            ->latest()
            ->paginate($validated['per_page'] ?? 10)
            ->withQueryString();

        return response()->json([
            'success' => true,
            'message' => 'Product list retrieved successfully',
            'data' => collect($products->items())
                ->map(fn (Product $product) => $this->formatProduct($product))
                ->values(),
            'meta' => [
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'per_page' => $products->perPage(),
                'total' => $products->total(),
            ],
        ]);
    }

    public function show(Product $product): JsonResponse
    {
        $product->load('category');

        return response()->json([
            'success' => true,
            'message' => 'Product detail retrieved successfully',
            'data' => $this->formatProduct($product),
        ]);
    }

    private function formatProduct(Product $product): array
    {
        return [
            'id' => $product->id,
            'code' => $product->code,
            'name' => $product->name,
            'category' => $product->category ? [
                'id' => $product->category->id,
                'name' => $product->category->name,
            ] : null,
            'stock' => [
                'total' => (int) $product->stock,
                'available' => (int) $product->available_stock,
                'damaged' => (int) $product->damaged_stock,
                'good' => (int) $product->good_stock,
                'minor_damage' => (int) $product->minor_damage_stock,
                'major_damage' => (int) $product->major_damage_stock,
            ],
            'location' => $product->location,
            'condition' => $product->condition,
            'condition_summary' => $product->condition_summary,
            'stock_status' => $product->stock_status,
            'stock_status_label' => $product->stock_status_label,
            'image' => $product->image,
            'image_url' => $product->image ? asset('storage/' . $product->image) : null,
            'created_at' => optional($product->created_at)->toDateTimeString(),
            'updated_at' => optional($product->updated_at)->toDateTimeString(),
        ];
    }
}
