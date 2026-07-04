<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            Detail Peminjaman
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 bg-white dark:bg-gray-800 p-6 rounded shadow">
            <div class="mb-6 space-y-2">
                <p><strong>Nama Peminjam:</strong> {{ $borrowing->borrower_name }}</p>
                <p><strong>Tanggal Pinjam:</strong> {{ $borrowing->borrow_date?->format('d M Y') }}</p>
                <p><strong>Jatuh Tempo:</strong> {{ $borrowing->due_date?->format('d M Y') ?? '-' }}</p>
                <p><strong>Tanggal Kembali:</strong> {{ $borrowing->return_date?->format('d M Y') ?? '-' }}</p>
                <p><strong>Status:</strong> {{ $borrowing->display_status_label }}</p>
                <p><strong>Kondisi Saat Kembali:</strong> {{ $borrowing->return_condition ?? '-' }}</p>
                <p><strong>Catatan Pengembalian:</strong> {{ $borrowing->return_note ?? '-' }}</p>
            </div>

            <h3 class="text-lg font-semibold mt-6 mb-2">Barang Dipinjam</h3>

            <div class="overflow-x-auto">
                <table class="w-full border">
                    <thead class="bg-gray-100 dark:bg-gray-700">
                        <tr>
                            <th class="border px-4 py-2 text-left">Kode</th>
                            <th class="border px-4 py-2 text-left">Nama Barang</th>
                            <th class="border px-4 py-2 text-left">Jumlah</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($borrowing->details as $detail)
                            <tr>
                                <td class="border px-4 py-2">{{ $detail->product->code ?? '-' }}</td>
                                <td class="border px-4 py-2">{{ $detail->product->name ?? '-' }}</td>
                                <td class="border px-4 py-2">{{ $detail->quantity }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                <a href="{{ route('borrowings.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded">
                    Kembali
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
