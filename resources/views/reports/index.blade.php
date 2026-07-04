<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            Laporan Inventaris
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow mb-8">
                <h3 class="text-lg font-semibold mb-4">
                    Export Laporan
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="border rounded p-4">
                        <h4 class="font-semibold mb-3">
                            Laporan Data Barang
                        </h4>

                        <div class="flex flex-wrap gap-2">
                            <a href="{{ route('reports.products.pdf') }}" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded">
                                Export PDF
                            </a>

                            <a href="{{ route('reports.products.excel') }}" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded">
                                Export Excel
                            </a>

                            <a href="{{ route('reports.products.csv') }}" class="px-4 py-2 bg-gray-700 hover:bg-gray-800 text-white rounded">
                                Export CSV
                            </a>
                        </div>
                    </div>

                    <div class="border rounded p-4">
                        <h4 class="font-semibold mb-3">
                            Laporan Peminjaman
                        </h4>

                        <div class="flex flex-wrap gap-2">
                            <a href="{{ route('reports.borrowings.pdf') }}" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded">
                                Export PDF
                            </a>

                            <a href="{{ route('reports.borrowings.excel') }}" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded">
                                Export Excel
                            </a>

                            <a href="{{ route('reports.borrowings.csv') }}" class="px-4 py-2 bg-gray-700 hover:bg-gray-800 text-white rounded">
                                Export CSV
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                    <p class="text-gray-500">Total Jenis Barang</p>
                    <h3 class="text-3xl font-bold">{{ $totalProducts }}</h3>
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                    <p class="text-gray-500">Total Stok Barang</p>
                    <h3 class="text-3xl font-bold">{{ $totalStock }}</h3>
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                    <p class="text-gray-500">Total Transaksi</p>
                    <h3 class="text-3xl font-bold">{{ $totalBorrowings }}</h3>
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                    <p class="text-gray-500">Barang Dipinjam</p>
                    <h3 class="text-3xl font-bold">{{ $totalBorrowedItems }}</h3>
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                    <p class="text-gray-500">Stok Menipis</p>
                    <h3 class="text-3xl font-bold">{{ $lowStockProducts->count() }}</h3>
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                    <p class="text-gray-500">Stok Habis</p>
                    <h3 class="text-3xl font-bold">{{ $outOfStockProducts->count() }}</h3>
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                    <p class="text-gray-500">Barang Rusak</p>
                    <h3 class="text-3xl font-bold">{{ $damagedProducts->count() }}</h3>
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                    <p class="text-gray-500">Peminjaman Terlambat</p>
                    <h3 class="text-3xl font-bold">{{ $overdueBorrowings->count() }}</h3>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow mb-8">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">
                        Laporan Data Barang
                    </h3>

                    <span class="text-sm text-gray-500">
                        Total: {{ $products->count() }} barang
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full border">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th class="border px-4 py-2 text-left">Kode</th>
                                <th class="border px-4 py-2 text-left">Nama Barang</th>
                                <th class="border px-4 py-2 text-left">Kategori</th>
                                <th class="border px-4 py-2 text-left">Stok</th>
                                <th class="border px-4 py-2 text-left">Lokasi</th>
                                <th class="border px-4 py-2 text-left">Kondisi</th>
                                <th class="border px-4 py-2 text-left">Status</th>
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
                                    <td class="border px-4 py-2">{{ $product->stock_status_label }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="border px-4 py-8 text-center text-gray-500">
                                        Belum ada data barang.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow mb-8">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">
                        Laporan Riwayat Peminjaman
                    </h3>

                    <span class="text-sm text-gray-500">
                        Total: {{ $borrowings->count() }} transaksi
                    </span>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full border">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th class="border px-4 py-2 text-left">Nama Peminjam</th>
                                <th class="border px-4 py-2 text-left">Divisi</th>
                                <th class="border px-4 py-2 text-left">Barang</th>
                                <th class="border px-4 py-2 text-left">Jumlah</th>
                                <th class="border px-4 py-2 text-left">Tanggal Pinjam</th>
                                <th class="border px-4 py-2 text-left">Jatuh Tempo</th>
                                <th class="border px-4 py-2 text-left">Tanggal Kembali</th>
                                <th class="border px-4 py-2 text-left">Status</th>
                                <th class="border px-4 py-2 text-left">Kondisi Kembali</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($borrowings as $borrowing)
                                @foreach($borrowing->details as $detail)
                                    <tr>
                                        <td class="border px-4 py-2">{{ $borrowing->borrower_name }}</td>
                                        <td class="border px-4 py-2">{{ $borrowing->division ?? '-' }}</td>
                                        <td class="border px-4 py-2">{{ $detail->product->name ?? '-' }}</td>
                                        <td class="border px-4 py-2">{{ $detail->quantity }}</td>
                                        <td class="border px-4 py-2">{{ $borrowing->borrow_date?->format('d M Y') }}</td>
                                        <td class="border px-4 py-2">{{ $borrowing->due_date?->format('d M Y') ?? '-' }}</td>
                                        <td class="border px-4 py-2">{{ $borrowing->return_date?->format('d M Y') ?? '-' }}</td>
                                        <td class="border px-4 py-2">{{ $borrowing->display_status_label }}</td>
                                        <td class="border px-4 py-2">{{ $borrowing->return_condition ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            @empty
                                <tr>
                                    <td colspan="9" class="border px-4 py-8 text-center text-gray-500">
                                        Belum ada data peminjaman.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold mb-4">
                        Laporan Stok Menipis
                    </h3>

                    <div class="overflow-x-auto">
                        <table class="w-full border">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th class="border px-4 py-2 text-left">Kode</th>
                                    <th class="border px-4 py-2 text-left">Nama Barang</th>
                                    <th class="border px-4 py-2 text-left">Stok</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($lowStockProducts as $product)
                                    <tr>
                                        <td class="border px-4 py-2">{{ $product->code }}</td>
                                        <td class="border px-4 py-2">{{ $product->name }}</td>
                                        <td class="border px-4 py-2">{{ $product->stock }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="border px-4 py-8 text-center text-gray-500">
                                            Tidak ada barang dengan stok menipis.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold mb-4">
                        Laporan Peminjaman Terlambat
                    </h3>

                    <div class="overflow-x-auto">
                        <table class="w-full border">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th class="border px-4 py-2 text-left">Nama Peminjam</th>
                                    <th class="border px-4 py-2 text-left">Tanggal Pinjam</th>
                                    <th class="border px-4 py-2 text-left">Jatuh Tempo</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($overdueBorrowings as $borrowing)
                                    <tr>
                                        <td class="border px-4 py-2">{{ $borrowing->borrower_name }}</td>
                                        <td class="border px-4 py-2">{{ $borrowing->borrow_date?->format('d M Y') }}</td>
                                        <td class="border px-4 py-2">{{ $borrowing->due_date?->format('d M Y') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="border px-4 py-8 text-center text-gray-500">
                                            Tidak ada peminjaman terlambat.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
