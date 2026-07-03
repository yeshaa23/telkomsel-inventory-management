<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Laporan Inventaris
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white p-6 rounded-lg shadow">
                    <p class="text-gray-500">Total Jenis Barang</p>
                    <h3 class="text-3xl font-bold text-gray-800">{{ $totalProducts }}</h3>
                </div>

                <div class="bg-white p-6 rounded-lg shadow">
                    <p class="text-gray-500">Total Stok Barang</p>
                    <h3 class="text-3xl font-bold text-gray-800">{{ $totalStock }}</h3>
                </div>

                <div class="bg-white p-6 rounded-lg shadow">
                    <p class="text-gray-500">Total Transaksi Peminjaman</p>
                    <h3 class="text-3xl font-bold text-gray-800">{{ $totalBorrowings }}</h3>
                </div>

                <div class="bg-white p-6 rounded-lg shadow">
                    <p class="text-gray-500">Barang Sedang Dipinjam</p>
                    <h3 class="text-3xl font-bold text-gray-800">{{ $totalBorrowedItems }}</h3>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow mb-8">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">Laporan Data Barang</h3>
                    <span class="text-sm text-gray-500">Total: {{ $products->count() }} barang</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full border">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="border px-4 py-2 text-left">Kode</th>
                                <th class="border px-4 py-2 text-left">Nama Barang</th>
                                <th class="border px-4 py-2 text-left">Kategori</th>
                                <th class="border px-4 py-2 text-left">Stok</th>
                                <th class="border px-4 py-2 text-left">Lokasi</th>
                                <th class="border px-4 py-2 text-left">Kondisi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $product)
                                <tr>
                                    <td class="border px-4 py-2">{{ $product->code }}</td>
                                    <td class="border px-4 py-2">{{ $product->name }}</td>
                                    <td class="border px-4 py-2">{{ $product->category->name ?? '-' }}</td>
                                    <td class="border px-4 py-2">{{ $product->stock }}</td>
                                    <td class="border px-4 py-2">{{ $product->location }}</td>
                                    <td class="border px-4 py-2">{{ $product->condition }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="border px-4 py-2 text-center text-gray-500">
                                        Belum ada data barang.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow mb-8">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">Laporan Riwayat Peminjaman</h3>
                    <span class="text-sm text-gray-500">Total: {{ $borrowings->count() }} transaksi</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full border">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="border px-4 py-2 text-left">Nama Peminjam</th>
                                <th class="border px-4 py-2 text-left">Barang</th>
                                <th class="border px-4 py-2 text-left">Jumlah</th>
                                <th class="border px-4 py-2 text-left">Tanggal Pinjam</th>
                                <th class="border px-4 py-2 text-left">Tanggal Kembali</th>
                                <th class="border px-4 py-2 text-left">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($borrowings as $borrowing)
                                @foreach($borrowing->details as $detail)
                                    <tr>
                                        <td class="border px-4 py-2">{{ $borrowing->borrower_name }}</td>
                                        <td class="border px-4 py-2">{{ $detail->product->name ?? '-' }}</td>
                                        <td class="border px-4 py-2">{{ $detail->quantity }}</td>
                                        <td class="border px-4 py-2">{{ $borrowing->borrow_date }}</td>
                                        <td class="border px-4 py-2">{{ $borrowing->return_date ?? '-' }}</td>
                                        <td class="border px-4 py-2">
                                            @if($borrowing->status == 'borrowed')
                                                <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded">
                                                    Dipinjam
                                                </span>
                                            @else
                                                <span class="px-2 py-1 bg-green-100 text-green-700 rounded">
                                                    Dikembalikan
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @empty
                                <tr>
                                    <td colspan="6" class="border px-4 py-2 text-center text-gray-500">
                                        Belum ada data peminjaman.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-semibold mb-4">Laporan Stok Menipis</h3>

                <div class="overflow-x-auto">
                    <table class="w-full border">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="border px-4 py-2 text-left">Kode</th>
                                <th class="border px-4 py-2 text-left">Nama Barang</th>
                                <th class="border px-4 py-2 text-left">Kategori</th>
                                <th class="border px-4 py-2 text-left">Stok</th>
                                <th class="border px-4 py-2 text-left">Lokasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($lowStockProducts as $product)
                                <tr>
                                    <td class="border px-4 py-2">{{ $product->code }}</td>
                                    <td class="border px-4 py-2">{{ $product->name }}</td>
                                    <td class="border px-4 py-2">{{ $product->category->name ?? '-' }}</td>
                                    <td class="border px-4 py-2">{{ $product->stock }}</td>
                                    <td class="border px-4 py-2">{{ $product->location }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="border px-4 py-2 text-center text-gray-500">
                                        Tidak ada barang dengan stok menipis.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
