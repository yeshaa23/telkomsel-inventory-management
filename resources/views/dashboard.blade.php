<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            Dashboard Inventaris
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($lowStockProducts->count() > 0)
                <div class="mb-6 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 rounded">
                    <p class="font-semibold">Notifikasi Stok Menipis</p>
                    <p>Ada {{ $lowStockProducts->count() }} barang dengan stok 1 sampai 5.</p>
                </div>
            @endif

            @if($overdueBorrowings->count() > 0)
                <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded">
                    <p class="font-semibold">Peminjaman Terlambat</p>
                    <p>Ada {{ $overdueBorrowings->count() }} peminjaman yang melewati tanggal jatuh tempo.</p>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                    <p class="text-gray-500">Total Jenis Barang</p>
                    <h3 class="text-3xl font-bold">{{ $totalProducts }}</h3>
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                    <p class="text-gray-500">Total Stok</p>
                    <h3 class="text-3xl font-bold">{{ $availableStock }}</h3>
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                    <p class="text-gray-500">Barang Dipinjam</p>
                    <h3 class="text-3xl font-bold">{{ $borrowedItems }}</h3>
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                    <p class="text-gray-500">Peminjaman Terlambat</p>
                    <h3 class="text-3xl font-bold">{{ $overdueBorrowings->count() }}</h3>
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
                    <p class="text-gray-500">Top Dipinjam</p>
                    <h3 class="text-3xl font-bold">{{ $topBorrowedProducts->first()->total_borrowed ?? 0 }}</h3>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow mb-8">
                <h3 class="text-lg font-semibold mb-4">Grafik Peminjaman per Bulan</h3>
                <canvas id="borrowingChart"></canvas>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold mb-4">Ringkasan Barang per Kategori</h3>

                    <div class="overflow-x-auto">
                        <table class="w-full border">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th class="border px-4 py-2 text-left">Kategori</th>
                                    <th class="border px-4 py-2 text-left">Jenis Barang</th>
                                    <th class="border px-4 py-2 text-left">Total Stok</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($categorySummaries as $category)
                                    <tr>
                                        <td class="border px-4 py-2">{{ $category->category_name }}</td>
                                        <td class="border px-4 py-2">{{ $category->total_product }}</td>
                                        <td class="border px-4 py-2">{{ $category->total_stock }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="border px-4 py-8 text-center text-gray-500">
                                            Belum ada data kategori barang.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold mb-4">Top 5 Barang Paling Sering Dipinjam</h3>

                    <div class="overflow-x-auto">
                        <table class="w-full border">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th class="border px-4 py-2 text-left">Kode</th>
                                    <th class="border px-4 py-2 text-left">Barang</th>
                                    <th class="border px-4 py-2 text-left">Total Dipinjam</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topBorrowedProducts as $product)
                                    <tr>
                                        <td class="border px-4 py-2">{{ $product->code }}</td>
                                        <td class="border px-4 py-2">{{ $product->name }}</td>
                                        <td class="border px-4 py-2">{{ $product->total_borrowed }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="border px-4 py-8 text-center text-gray-500">
                                            Belum ada data peminjaman barang.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                <h3 class="text-lg font-semibold mb-4">Peminjaman Terlambat</h3>

                <div class="overflow-x-auto">
                    <table class="w-full border">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th class="border px-4 py-2 text-left">Nama Peminjam</th>
                                <th class="border px-4 py-2 text-left">Tanggal Pinjam</th>
                                <th class="border px-4 py-2 text-left">Jatuh Tempo</th>
                                <th class="border px-4 py-2 text-left">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($overdueBorrowings as $borrowing)
                                <tr>
                                    <td class="border px-4 py-2">{{ $borrowing->borrower_name }}</td>
                                    <td class="border px-4 py-2">{{ $borrowing->borrow_date?->format('d M Y') }}</td>
                                    <td class="border px-4 py-2">{{ $borrowing->due_date?->format('d M Y') }}</td>
                                    <td class="border px-4 py-2">
                                        <span class="px-2 py-1 rounded text-xs bg-red-100 text-red-700">
                                            Terlambat
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="border px-4 py-8 text-center text-gray-500">
                                        Tidak ada peminjaman yang terlambat.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const monthlyData = @json($monthlyBorrowings);
        const labels = monthlyData.map(item => 'Bulan ' + item.month);
        const data = monthlyData.map(item => item.total);
        const ctx = document.getElementById('borrowingChart');

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah Peminjaman',
                    data: data,
                    borderWidth: 1
                }]
            }
        });
    </script>
</x-app-layout>
