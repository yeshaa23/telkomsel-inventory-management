<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            Pengembalian Barang
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 bg-white dark:bg-gray-800 p-6 rounded shadow">
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-2">Detail Peminjaman</h3>

                <p><strong>Nama Peminjam:</strong> {{ $borrowing->borrower_name }}</p>
                <p><strong>Tanggal Pinjam:</strong> {{ $borrowing->borrow_date?->format('d M Y') }}</p>
                <p><strong>Jatuh Tempo:</strong> {{ $borrowing->due_date?->format('d M Y') ?? '-' }}</p>
            </div>

            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-2">Barang Dipinjam</h3>

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
            </div>

            <form action="{{ route('borrowings.return', $borrowing) }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="mb-4">
                    <label class="block mb-1">Kondisi Saat Dikembalikan</label>

                    <select name="return_condition" class="w-full border rounded px-3 py-2">
                        <option value="">Pilih Kondisi</option>
                        <option value="Baik" {{ old('return_condition') == 'Baik' ? 'selected' : '' }}>Baik</option>
                        <option value="Rusak Ringan" {{ old('return_condition') == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                        <option value="Rusak Berat" {{ old('return_condition') == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                    </select>

                    @error('return_condition')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block mb-1">Catatan Pengembalian</label>

                    <textarea
                        name="return_note"
                        rows="4"
                        placeholder="Contoh: Barang lengkap, ada lecet kecil, kabel hilang, dan sebagainya."
                        class="w-full border rounded px-3 py-2"
                    >{{ old('return_note') }}</textarea>

                    @error('return_note')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <button class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded">
                    Simpan Pengembalian
                </button>

                <a href="{{ route('borrowings.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded">
                    Kembali
                </a>
            </form>
        </div>
    </div>
</x-app-layout>
