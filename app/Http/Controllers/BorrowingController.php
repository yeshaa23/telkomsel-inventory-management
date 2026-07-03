<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use App\Models\BorrowingDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BorrowingController extends Controller
{
    public function index()
    {
        $borrowings = Borrowing::with('details.product')->latest()->paginate(10);
        return view('borrowings.index', compact('borrowings'));
    }

    public function create()
    {
        $products = Product::where('stock', '>', 0)->get();
        return view('borrowings.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'borrower_name' => 'required|string|max:255',
            'borrow_date' => 'required|date',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($product->stock < $request->quantity) {
            return back()->withErrors(['quantity' => 'Stok barang tidak mencukupi.'])->withInput();
        }

        DB::transaction(function () use ($request, $product) {
            $borrowing = Borrowing::create([
                'borrower_name' => $request->borrower_name,
                'borrow_date' => $request->borrow_date,
                'status' => 'borrowed',
            ]);

            BorrowingDetail::create([
                'borrowing_id' => $borrowing->id,
                'product_id' => $product->id,
                'quantity' => $request->quantity,
            ]);

            $product->decrement('stock', $request->quantity);
        });

        return redirect()->route('borrowings.index')->with('success', 'Peminjaman berhasil ditambahkan.');
    }

    public function show(Borrowing $borrowing)
    {
        $borrowing->load('details.product');
        return view('borrowings.show', compact('borrowing'));
    }

    public function returnItem(Borrowing $borrowing)
    {
        if ($borrowing->status === 'returned') {
            return back()->with('error', 'Barang sudah dikembalikan.');
        }

        DB::transaction(function () use ($borrowing) {
            foreach ($borrowing->details as $detail) {
                $detail->product->increment('stock', $detail->quantity);
            }

            $borrowing->update([
                'status' => 'returned',
                'return_date' => now()->toDateString(),
            ]);
        });

        return redirect()->route('borrowings.index')->with('success', 'Barang berhasil dikembalikan.');
    }

    public function destroy(Borrowing $borrowing)
    {
        $borrowing->delete();

        return redirect()->route('borrowings.index')->with('success', 'Riwayat peminjaman berhasil dihapus.');
    }
}
