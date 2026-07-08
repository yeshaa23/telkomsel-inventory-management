<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ApiBorrowingController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'status' => ['nullable', 'in:borrowed,returned,overdue'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:100'],
        ]);

        $borrowings = Borrowing::with('details.product.category')
            ->when(! empty($validated['search']), function ($query) use ($validated) {
                $search = $validated['search'];

                $query->where(function ($query) use ($search) {
                    $query->where('borrower_name', 'like', "%{$search}%")
                        ->orWhere('division', 'like', "%{$search}%")
                        ->orWhereHas('details.product', function ($productQuery) use ($search) {
                            $productQuery->where('name', 'like', "%{$search}%")
                                ->orWhere('code', 'like', "%{$search}%");
                        });
                });
            })
            ->when(! empty($validated['status']), function ($query) use ($validated) {
                if ($validated['status'] === 'overdue') {
                    $query->where('status', 'borrowed')
                        ->whereNotNull('due_date')
                        ->whereDate('due_date', '<', now()->toDateString());

                    return;
                }

                $query->where('status', $validated['status']);
            })
            ->latest()
            ->paginate($validated['per_page'] ?? 10)
            ->withQueryString();

        return response()->json([
            'success' => true,
            'message' => 'Borrowing list retrieved successfully',
            'data' => collect($borrowings->items())
                ->map(fn (Borrowing $borrowing) => $this->formatBorrowing($borrowing))
                ->values(),
            'meta' => [
                'current_page' => $borrowings->currentPage(),
                'last_page' => $borrowings->lastPage(),
                'per_page' => $borrowings->perPage(),
                'total' => $borrowings->total(),
            ],
        ]);
    }

    public function show(Borrowing $borrowing): JsonResponse
    {
        $borrowing->load('details.product.category');

        return response()->json([
            'success' => true,
            'message' => 'Borrowing detail retrieved successfully',
            'data' => $this->formatBorrowing($borrowing),
        ]);
    }

    private function formatBorrowing(Borrowing $borrowing): array
    {
        return [
            'id' => $borrowing->id,
            'borrower_name' => $borrowing->borrower_name,
            'division' => $borrowing->division,
            'borrow_date' => optional($borrowing->borrow_date)->format('Y-m-d'),
            'due_date' => optional($borrowing->due_date)->format('Y-m-d'),
            'return_date' => optional($borrowing->return_date)->format('Y-m-d'),
            'status' => $borrowing->status,
            'display_status' => $borrowing->display_status,
            'display_status_label' => $borrowing->display_status_label,
            'return_condition' => $borrowing->return_condition,
            'return_note' => $borrowing->return_note,
            'total_items' => (int) $borrowing->details->sum('quantity'),
            'items' => $borrowing->details->map(function ($detail) {
                return [
                    'id' => $detail->id,
                    'quantity' => (int) $detail->quantity,
                    'product' => $detail->product ? [
                        'id' => $detail->product->id,
                        'code' => $detail->product->code,
                        'name' => $detail->product->name,
                        'category' => $detail->product->category?->name,
                    ] : null,
                ];
            })->values(),
            'created_at' => optional($borrowing->created_at)->toDateTimeString(),
            'updated_at' => optional($borrowing->updated_at)->toDateTimeString(),
        ];
    }
}
