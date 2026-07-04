<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            Riwayat Peminjaman
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white dark:bg-gray-800 p-6 rounded shadow">
            @if(session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <div class="mb-6 flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-semibold">Data Peminjaman Barang</h3>
                    <p class="text-sm text-gray-500">
                        Kelola peminjaman, pengembalian, dan keterlambatan barang.
                    </p>
                </div>

                <a href="{{ route('borrowings.create') }}" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded">
                    Tambah Peminjaman
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full border">
                    <thead class="bg-gray-100 dark:bg-gray-700">
                        <tr>
                            <th class="border px-4 py-2 text-left">Nama Peminjam</th>
                            <th class="border px-4 py-2 text-left">Tanggal Pinjam</th>
                            <th class="border px-4 py-2 text-left">Jatuh Tempo</th>
                            <th class="border px-4 py-2 text-left">Tanggal Kembali</th>
                            <th class="border px-4 py-2 text-left">Status</th>
                            <th class="border px-4 py-2 text-left">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($borrowings as $borrowing)
                            <tr>
                                <td class="border px-4 py-2">{{ $borrowing->borrower_name }}</td>
                                <td class="border px-4 py-2">{{ $borrowing->borrow_date?->format('d M Y') }}</td>
                                <td class="border px-4 py-2">{{ $borrowing->due_date?->format('d M Y') ?? '-' }}</td>
                                <td class="border px-4 py-2">{{ $borrowing->return_date?->format('d M Y') ?? '-' }}</td>

                                <td class="border px-4 py-2">
                                    @if($borrowing->display_status === 'overdue')
                                        <span class="px-2 py-1 bg-red-100 text-red-700 rounded text-xs">
                                            Terlambat
                                        </span>
                                    @elseif($borrowing->display_status === 'borrowed')
                                        <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded text-xs">
                                            Dipinjam
                                        </span>
                                    @else
                                        <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs">
                                            Dikembalikan
                                        </span>
                                    @endif
                                </td>

                                <td class="border px-4 py-2">
                                    <a href="{{ route('borrowings.show', $borrowing) }}" class="text-blue-600">
                                        Detail
                                    </a>

                                    @if($borrowing->status === 'borrowed')
                                        |
                                        <a href="{{ route('borrowings.return.form', $borrowing) }}" class="text-green-600">
                                            Kembalikan
                                        </a>
                                    @endif

                                    |
                                    <form id="delete-borrowing-{{ $borrowing->id }}" action="{{ route('borrowings.destroy', $borrowing) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="button"
                                            onclick="openConfirmModal('Yakin ingin menghapus riwayat peminjaman ini? Jika masih dipinjam, stok akan dikembalikan.', 'delete-borrowing-{{ $borrowing->id }}')"
                                            class="text-red-600"
                                        >
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="border px-4 py-10 text-center text-gray-500">
                                    <p class="font-semibold">Belum ada data peminjaman.</p>
                                    <p class="text-sm mt-1">
                                        Klik Tambah Peminjaman untuk mencatat transaksi peminjaman barang.
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $borrowings->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
