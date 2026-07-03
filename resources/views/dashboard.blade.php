<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
            <div>
                <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-100 leading-tight">
                    Dashboard Inventaris
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    Ringkasan data barang, stok, dan aktivitas peminjaman inventaris kantor.
                </p>
            </div>

            <div class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-lg text-sm font-semibold shadow">
                Telkomsel Inventory
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-4">

            {{-- Notifikasi Stok Menipis --}}
            @if($lowStockProducts->count() > 0)
                <div class="mb-6 bg-yellow-50 border-l-4 border-yellow-500 text-yellow-800 p-4 rounded-lg shadow-sm">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <p class="font-bold">Notifikasi Stok Menipis</p>
                            <p class="text-sm mt-1">
                                Ada {{ $lowStockProducts->count() }} barang dengan stok kurang dari atau sama dengan 5.
                            </p>
                        </div>

                        <span class="px-3 py-1 bg-yellow-200 text-yellow-900 rounded-full text-xs font-semibold">
                            Perlu Dicek
                        </span>
                    </div>
                </div>
            @endif

            {{-- Statistik Utama --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white dark:bg-gray-800 border-t-4 border-red-600 p-6 rounded-xl shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 dark:text-gray-400 text-sm">Total Jenis Barang</p>
                            <h3 class="text-4xl font-bold text-gray-800 dark:text-gray-100 mt-2">
                                {{ $totalProducts }}
                            </h3>
                        </div>

                        <div class="w-12 h-12 rounded-xl bg-red-100 text-red-600 flex items-center justify-center font-bold">
                            TB
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 border-t-4 border-gray-800 dark:border-gray-300 p-6 rounded-xl shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 dark:text-gray-400 text-sm">Total Stok Tersedia</p>
                            <h3 class="text-4xl font-bold text-gray-800 dark:text-gray-100 mt-2">
                                {{ $availableStock }}
                            </h3>
                        </div>

                        <div class="w-12 h-12 rounded-xl bg-gray-100 text-gray-800 flex items-center justify-center font-bold">
                            ST
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 border-t-4 border-red-600 p-6 rounded-xl shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-500 dark:text-gray-400 text-sm">Barang Sedang Dipinjam</p>
                            <h3 class="text-4xl font-bold text-gray-800 dark:text-gray-100 mt-2">
                                {{ $borrowedItems }}
                            </h3>
                        </div>

                        <div class="w-12 h-12 rounded-xl bg-red-100 text-red-600 flex items-center justify-center font-bold">
                            BP
                        </div>
                    </div>
                </div>
            </div>

            {{-- Grafik dan Stok Menipis --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                {{-- Grafik Peminjaman --}}
                <div class="lg:col-span-2 bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm">
                    <div class="flex items-center justify-between mb-5">
                        <div>
                            <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100">
                                Grafik Peminjaman per Bulan
                            </h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Menampilkan jumlah transaksi peminjaman berdasarkan bulan.
                            </p>
                        </div>
                    </div>

                    <div class="h-80">
                        <canvas id="borrowingChart"></canvas>
                    </div>
                </div>

                {{-- Daftar Stok Menipis --}}
                <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm">
                    <div class="mb-4">
                        <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100">
                            Stok Menipis
                        </h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Barang dengan stok ≤ 5.
                        </p>
                    </div>

                    <div class="space-y-3">
                        @forelse($lowStockProducts as $product)
                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-3">
                                <div class="flex items-start justify-between gap-3">
                                    <div>
                                        <p class="font-semibold text-gray-800 dark:text-gray-100">
                                            {{ $product->name }}
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ $product->code }} • {{ $product->location }}
                                        </p>
                                    </div>

                                    <span class="px-2 py-1 bg-red-100 text-red-700 text-xs font-bold rounded">
                                        {{ $product->stock }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    Tidak ada barang dengan stok menipis.
                                </p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Tabel Stok Menipis --}}
            <div class="mt-8 bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm">
                <div class="mb-4">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100">
                        Detail Barang Stok Menipis
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Data ini membantu staff/admin untuk segera melakukan pengecekan atau pengadaan barang.
                    </p>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full border border-gray-200 dark:border-gray-700">
                        <thead class="bg-gray-100 dark:bg-gray-700">
                            <tr>
                                <th class="border border-gray-200 dark:border-gray-700 px-4 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-100">
                                    Kode
                                </th>
                                <th class="border border-gray-200 dark:border-gray-700 px-4 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-100">
                                    Nama Barang
                                </th>
                                <th class="border border-gray-200 dark:border-gray-700 px-4 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-100">
                                    Stok
                                </th>
                                <th class="border border-gray-200 dark:border-gray-700 px-4 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-100">
                                    Lokasi
                                </th>
                                <th class="border border-gray-200 dark:border-gray-700 px-4 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-100">
                                    Kondisi
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($lowStockProducts as $product)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                    <td class="border border-gray-200 dark:border-gray-700 px-4 py-3 text-sm text-gray-700 dark:text-gray-200">
                                        {{ $product->code }}
                                    </td>
                                    <td class="border border-gray-200 dark:border-gray-700 px-4 py-3 text-sm text-gray-700 dark:text-gray-200">
                                        {{ $product->name }}
                                    </td>
                                    <td class="border border-gray-200 dark:border-gray-700 px-4 py-3 text-sm">
                                        <span class="px-2 py-1 bg-red-100 text-red-700 rounded font-semibold">
                                            {{ $product->stock }}
                                        </span>
                                    </td>
                                    <td class="border border-gray-200 dark:border-gray-700 px-4 py-3 text-sm text-gray-700 dark:text-gray-200">
                                        {{ $product->location }}
                                    </td>
                                    <td class="border border-gray-200 dark:border-gray-700 px-4 py-3 text-sm text-gray-700 dark:text-gray-200">
                                        {{ $product->condition }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="border border-gray-200 dark:border-gray-700 px-4 py-6 text-center text-sm text-gray-500 dark:text-gray-400">
                                        Tidak ada data stok menipis.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const monthlyData = @json($monthlyBorrowings);

        const monthNames = {
            1: 'Jan',
            2: 'Feb',
            3: 'Mar',
            4: 'Apr',
            5: 'Mei',
            6: 'Jun',
            7: 'Jul',
            8: 'Agu',
            9: 'Sep',
            10: 'Okt',
            11: 'Nov',
            12: 'Des'
        };

        const labels = monthlyData.length > 0
            ? monthlyData.map(item => monthNames[item.month] ?? ('Bulan ' + item.month))
            : ['Belum ada data'];

        const data = monthlyData.length > 0
            ? monthlyData.map(item => item.total)
            : [0];

        const ctx = document.getElementById('borrowingChart');

        if (ctx) {
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Jumlah Peminjaman',
                        data: data,
                        backgroundColor: 'rgba(220, 38, 38, 0.75)',
                        borderColor: 'rgba(185, 28, 28, 1)',
                        borderWidth: 1,
                        borderRadius: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: true
                        }
                    }
                }
            });
        }
    </script>
</x-app-layout>
