<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-100 leading-tight">
                Detail Peminjaman
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Informasi lengkap transaksi peminjaman barang inventaris.
            </p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 px-4">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">

                <div class="p-6 border-b border-gray-200 dark:border-gray-700 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100">
                            {{ $borrowing->borrower_name }}
                        </h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Transaksi peminjaman #{{ $borrowing->id }}
                        </p>
                    </div>

                    @if($borrowing->status === 'borrowed')
                        <span class="inline-flex px-3 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-bold">
                            Sedang Dipinjam
                        </span>
                    @else
                        <span class="inline-flex px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">
                            Sudah Dikembalikan
                        </span>
                    @endif
                </div>

                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-7">
                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Nama Peminjam</p>
                            <p class="mt-1 text-gray-800 dark:text-gray-100 font-semibold">
                                {{ $borrowing->borrower_name }}
                            </p>
                        </div>

                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Tanggal Pinjam</p>
                            <p class="mt-1 text-gray-800 dark:text-gray-100 font-semibold">
                                {{ \Carbon\Carbon::parse($borrowing->borrow_date)->format('d M Y') }}
                            </p>
                        </div>

                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                            <p class="text-sm text-gray-500 dark:text-gray-400">Tanggal Kembali</p>
                            <p class="mt-1 text-gray-800 dark:text-gray-100 font-semibold">
                                {{ $borrowing->return_date ? \Carbon\Carbon::parse($borrowing->return_date)->format('d M Y') : '-' }}
                            </p>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100">
                            Barang yang Dipinjam
                        </h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Daftar barang pada transaksi peminjaman ini.
                        </p>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full border border-gray-200 dark:border-gray-700">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th class="border border-gray-200 dark:border-gray-700 px-4 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-100">
                                        Gambar
                                    </th>
                                    <th class="border border-gray-200 dark:border-gray-700 px-4 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-100">
                                        Kode
                                    </th>
                                    <th class="border border-gray-200 dark:border-gray-700 px-4 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-100">
                                        Nama Barang
                                    </th>
                                    <th class="border border-gray-200 dark:border-gray-700 px-4 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-100">
                                        Kategori
                                    </th>
                                    <th class="border border-gray-200 dark:border-gray-700 px-4 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-100">
                                        Lokasi
                                    </th>
                                    <th class="border border-gray-200 dark:border-gray-700 px-4 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-100">
                                        Jumlah
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($borrowing->details as $detail)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="border border-gray-200 dark:border-gray-700 px-4 py-3">
                                            @if($detail->product && $detail->product->image)
                                                <img src="{{ asset('storage/' . $detail->product->image) }}"
                                                     alt="{{ $detail->product->name }}"
                                                     class="w-14 h-14 object-cover rounded-lg border">
                                            @else
                                                <div class="w-14 h-14 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-xs text-gray-500">
                                                    No Image
                                                </div>
                                            @endif
                                        </td>

                                        <td class="border border-gray-200 dark:border-gray-700 px-4 py-3 text-sm font-semibold text-gray-800 dark:text-gray-100">
                                            {{ $detail->product->code ?? '-' }}
                                        </td>

                                        <td class="border border-gray-200 dark:border-gray-700 px-4 py-3 text-sm text-gray-700 dark:text-gray-200">
                                            {{ $detail->product->name ?? '-' }}
                                        </td>

                                        <td class="border border-gray-200 dark:border-gray-700 px-4 py-3 text-sm text-gray-700 dark:text-gray-200">
                                            {{ $detail->product->category->name ?? '-' }}
                                        </td>

                                        <td class="border border-gray-200 dark:border-gray-700 px-4 py-3 text-sm text-gray-700 dark:text-gray-200">
                                            {{ $detail->product->location ?? '-' }}
                                        </td>

                                        <td class="border border-gray-200 dark:border-gray-700 px-4 py-3 text-sm">
                                            <span class="px-2 py-1 bg-red-100 text-red-700 rounded text-xs font-bold">
                                                {{ $detail->quantity }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="border border-gray-200 dark:border-gray-700 px-4 py-8 text-center text-sm text-gray-500 dark:text-gray-400">
                                            Tidak ada detail barang pada transaksi ini.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-7 flex flex-col md:flex-row md:items-center gap-3">
                        @if($borrowing->status === 'borrowed')
                            <form action="{{ route('borrowings.return', $borrowing) }}" method="POST">
                                @csrf
                                @method('PATCH')

                                <button type="submit"
                                        onclick="return confirm('Konfirmasi pengembalian barang ini?')"
                                        class="px-5 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-semibold shadow-sm">
                                    Kembalikan Barang
                                </button>
                            </form>
                        @endif

                        <a href="{{ route('borrowings.index') }}"
                           class="px-5 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg text-sm font-semibold shadow-sm text-center">
                            Kembali
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
