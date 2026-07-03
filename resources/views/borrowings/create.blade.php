<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-100 leading-tight">
                Tambah Peminjaman
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Catat transaksi peminjaman barang inventaris kantor.
            </p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 px-4">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">

                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100">
                        Form Tambah Peminjaman
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Pilih barang yang akan dipinjam. Sistem akan otomatis mengurangi stok barang.
                    </p>
                </div>

                <div class="p-6">
                    @if($products->count() === 0)
                        <div class="mb-6 bg-yellow-50 border-l-4 border-yellow-500 text-yellow-800 p-4 rounded-lg">
                            <p class="font-semibold">Tidak ada barang yang tersedia.</p>
                            <p class="text-sm mt-1">
                                Tambahkan data barang terlebih dahulu atau pastikan stok barang lebih dari 0.
                            </p>

                            <a href="{{ route('products.create') }}"
                               class="inline-block mt-3 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm font-semibold">
                                Tambah Barang
                            </a>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-800 p-4 rounded-lg">
                            <p class="font-semibold">Data belum valid.</p>
                            <ul class="list-disc list-inside text-sm mt-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('borrowings.store') }}" method="POST">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label for="borrower_name" class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-200">
                                    Nama Peminjam
                                </label>

                                <input type="text"
                                       id="borrower_name"
                                       name="borrower_name"
                                       value="{{ old('borrower_name') }}"
                                       placeholder="Contoh: Budi Santoso"
                                       class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 rounded-lg shadow-sm focus:border-red-500 focus:ring-red-500">

                                @error('borrower_name')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="borrow_date" class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-200">
                                    Tanggal Pinjam
                                </label>

                                <input type="date"
                                       id="borrow_date"
                                       name="borrow_date"
                                       value="{{ old('borrow_date', date('Y-m-d')) }}"
                                       class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 rounded-lg shadow-sm focus:border-red-500 focus:ring-red-500">

                                @error('borrow_date')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="product_id" class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-200">
                                    Barang
                                </label>

                                <select id="product_id"
                                        name="product_id"
                                        class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 rounded-lg shadow-sm focus:border-red-500 focus:ring-red-500">
                                    <option value="">Pilih Barang</option>

                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                            {{ $product->code }} - {{ $product->name }} | Stok: {{ $product->stock }} | Lokasi: {{ $product->location }}
                                        </option>
                                    @endforeach
                                </select>

                                @error('product_id')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="quantity" class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-200">
                                    Jumlah
                                </label>

                                <input type="number"
                                       id="quantity"
                                       name="quantity"
                                       value="{{ old('quantity', 1) }}"
                                       min="1"
                                       placeholder="Contoh: 1"
                                       class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 rounded-lg shadow-sm focus:border-red-500 focus:ring-red-500">

                                @error('quantity')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-7 bg-gray-50 dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                            <p class="text-sm font-semibold text-gray-800 dark:text-gray-100">
                                Catatan Sistem
                            </p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                Setelah data peminjaman disimpan, stok barang akan otomatis berkurang sesuai jumlah yang dipinjam.
                            </p>
                        </div>

                        <div class="flex items-center gap-3 mt-7">
                            <button type="submit"
                                    class="px-5 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm font-semibold shadow-sm"
                                    {{ $products->count() === 0 ? 'disabled' : '' }}>
                                Simpan Peminjaman
                            </button>

                            <a href="{{ route('borrowings.index') }}"
                               class="px-5 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg text-sm font-semibold shadow-sm">
                                Kembali
                            </a>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
