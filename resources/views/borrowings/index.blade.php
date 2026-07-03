<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-100 leading-tight">
                Riwayat Peminjaman
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Kelola data peminjaman, pengembalian, dan status barang inventaris kantor.
            </p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-4">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">

                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                        <div>
                            <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100">
                                Daftar Peminjaman Barang
                            </h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Data ini mencatat barang yang sedang dipinjam maupun sudah dikembalikan.
                            </p>
                        </div>

                        <a href="{{ route('borrowings.create') }}"
                           class="inline-flex items-center justify-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm font-semibold shadow-sm">
                            + Tambah Peminjaman
                        </a>
                    </div>
                </div>

                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="w-full border border-gray-200 dark:border-gray-700">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th class="border border-gray-200 dark:border-gray-700 px-4 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-100">
                                        No
                                    </th>
                                    <th class="border border-gray-200 dark:border-gray-700 px-4 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-100">
                                        Nama Peminjam
                                    </th>
                                    <th class="border border-gray-200 dark:border-gray-700 px-4 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-100">
                                        Barang
                                    </th>
                                    <th class="border border-gray-200 dark:border-gray-700 px-4 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-100">
                                        Jumlah
                                    </th>
                                    <th class="border border-gray-200 dark:border-gray-700 px-4 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-100">
                                        Tanggal Pinjam
                                    </th>
                                    <th class="border border-gray-200 dark:border-gray-700 px-4 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-100">
                                        Tanggal Kembali
                                    </th>
                                    <th class="border border-gray-200 dark:border-gray-700 px-4 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-100">
                                        Status
                                    </th>
                                    <th class="border border-gray-200 dark:border-gray-700 px-4 py-3 text-center text-sm font-semibold text-gray-700 dark:text-gray-100">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($borrowings as $borrowing)
                                    @php
                                        $totalQuantity = $borrowing->details->sum('quantity');
                                        $firstDetail = $borrowing->details->first();
                                    @endphp

                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="border border-gray-200 dark:border-gray-700 px-4 py-3 text-sm text-gray-700 dark:text-gray-200">
                                            {{ $loop->iteration + ($borrowings->currentPage() - 1) * $borrowings->perPage() }}
                                        </td>

                                        <td class="border border-gray-200 dark:border-gray-700 px-4 py-3 text-sm font-semibold text-gray-800 dark:text-gray-100">
                                            {{ $borrowing->borrower_name }}
                                        </td>

                                        <td class="border border-gray-200 dark:border-gray-700 px-4 py-3 text-sm text-gray-700 dark:text-gray-200">
                                            @if($firstDetail && $firstDetail->product)
                                                <div class="font-semibold">
                                                    {{ $firstDetail->product->name }}
                                                </div>
                                                <div class="text-xs text-gray-500 dark:text-gray-400">
                                                    {{ $firstDetail->product->code }} • {{ $firstDetail->product->location }}
                                                </div>
                                            @else
                                                -
                                            @endif
                                        </td>

                                        <td class="border border-gray-200 dark:border-gray-700 px-4 py-3 text-sm">
                                            <span class="px-2 py-1 bg-red-100 text-red-700 rounded text-xs font-bold">
                                                {{ $totalQuantity }}
                                            </span>
                                        </td>

                                        <td class="border border-gray-200 dark:border-gray-700 px-4 py-3 text-sm text-gray-700 dark:text-gray-200">
                                            {{ \Carbon\Carbon::parse($borrowing->borrow_date)->format('d M Y') }}
                                        </td>

                                        <td class="border border-gray-200 dark:border-gray-700 px-4 py-3 text-sm text-gray-700 dark:text-gray-200">
                                            {{ $borrowing->return_date ? \Carbon\Carbon::parse($borrowing->return_date)->format('d M Y') : '-' }}
                                        </td>

                                        <td class="border border-gray-200 dark:border-gray-700 px-4 py-3 text-sm">
                                            @if($borrowing->status === 'borrowed')
                                                <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded text-xs font-bold">
                                                    Sedang Dipinjam
                                                </span>
                                            @else
                                                <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs font-bold">
                                                    Dikembalikan
                                                </span>
                                            @endif
                                        </td>

                                        <td class="border border-gray-200 dark:border-gray-700 px-4 py-3 text-sm">
                                            <div class="flex items-center justify-center gap-2">
                                                <a href="{{ route('borrowings.show', $borrowing) }}"
                                                   class="px-3 py-1 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded text-xs font-semibold">
                                                    Detail
                                                </a>

                                                @if($borrowing->status === 'borrowed')
                                                    <form action="{{ route('borrowings.return', $borrowing) }}" method="POST">
                                                        @csrf
                                                        @method('PATCH')

                                                        <button type="submit"
                                                                onclick="return confirm('Konfirmasi pengembalian barang ini?')"
                                                                class="px-3 py-1 bg-green-100 hover:bg-green-200 text-green-700 rounded text-xs font-semibold">
                                                            Kembalikan
                                                        </button>
                                                    </form>
                                                @endif

                                                <form action="{{ route('borrowings.destroy', $borrowing) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit"
                                                            onclick="return confirm('Yakin ingin menghapus riwayat peminjaman ini?')"
                                                            class="px-3 py-1 bg-red-100 hover:bg-red-200 text-red-700 rounded text-xs font-semibold">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="border border-gray-200 dark:border-gray-700 px-4 py-8 text-center text-sm text-gray-500 dark:text-gray-400">
                                            Belum ada data peminjaman.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-5">
                        {{ $borrowings->links() }}
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
