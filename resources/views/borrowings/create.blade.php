<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            Tambah Peminjaman
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 bg-white dark:bg-gray-800 p-6 rounded shadow">
            <form action="{{ route('borrowings.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="block mb-1">Nama Peminjam</label>

                    <input
                        type="text"
                        name="borrower_name"
                        value="{{ old('borrower_name') }}"
                        class="w-full border rounded px-3 py-2"
                    >

                    @error('borrower_name')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block mb-1">Divisi</label>

                    <select
                        name="division"
                        class="w-full border rounded px-3 py-2"
                    >
                        <option value="">Pilih Divisi</option>
                        <option value="IT" {{ old('division') == 'IT' ? 'selected' : '' }}>IT</option>
                        <option value="Finance" {{ old('division') == 'Finance' ? 'selected' : '' }}>Finance</option>
                        <option value="Human Resources" {{ old('division') == 'Human Resources' ? 'selected' : '' }}>Human Resources</option>
                        <option value="Marketing" {{ old('division') == 'Marketing' ? 'selected' : '' }}>Marketing</option>
                        <option value="Sales" {{ old('division') == 'Sales' ? 'selected' : '' }}>Sales</option>
                        <option value="Operations" {{ old('division') == 'Operations' ? 'selected' : '' }}>Operations</option>
                        <option value="Customer Service" {{ old('division') == 'Customer Service' ? 'selected' : '' }}>Customer Service</option>
                        <option value="General Affairs" {{ old('division') == 'General Affairs' ? 'selected' : '' }}>General Affairs</option>
                        <option value="Lainnya" {{ old('division') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>

                    @error('division')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block mb-1">Tanggal Pinjam</label>

                        <input
                            type="date"
                            name="borrow_date"
                            value="{{ old('borrow_date', date('Y-m-d')) }}"
                            class="w-full border rounded px-3 py-2"
                        >

                        @error('borrow_date')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block mb-1">Tanggal Jatuh Tempo</label>

                        <input
                            type="date"
                            name="due_date"
                            value="{{ old('due_date') }}"
                            class="w-full border rounded px-3 py-2"
                        >

                        <p class="text-sm text-gray-500 mt-1">
                            Digunakan untuk mendeteksi peminjaman terlambat.
                        </p>

                        @error('due_date')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block mb-1">Barang</label>

                    <select name="product_id" class="w-full border rounded px-3 py-2">
                        <option value="">Pilih Barang</option>

                        @foreach($products as $product)
                            <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                {{ $product->code }} - {{ $product->name }} | Stok: {{ $product->stock }}
                            </option>
                        @endforeach
                    </select>

                    @error('product_id')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block mb-1">Jumlah</label>

                    <input
                        type="number"
                        name="quantity"
                        value="{{ old('quantity', 1) }}"
                        min="1"
                        class="w-full border rounded px-3 py-2"
                    >

                    @error('quantity')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <button class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded">
                    Simpan
                </button>

                <a href="{{ route('borrowings.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded">
                    Kembali
                </a>
            </form>
        </div>
    </div>
</x-app-layout>
