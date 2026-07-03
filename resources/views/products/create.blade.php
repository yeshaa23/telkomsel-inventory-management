<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-100 leading-tight">
                Tambah Barang
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Tambahkan data barang baru ke sistem inventaris kantor.
            </p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 px-4">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">

                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100">
                        Form Tambah Barang
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Lengkapi kode, kategori, stok, lokasi, kondisi, dan gambar barang jika ada.
                    </p>
                </div>

                <div class="p-6">
                    @if($categories->count() === 0)
                        <div class="mb-6 bg-yellow-50 border-l-4 border-yellow-500 text-yellow-800 p-4 rounded-lg">
                            <p class="font-semibold">Kategori belum tersedia.</p>
                            <p class="text-sm mt-1">
                                Tambahkan kategori terlebih dahulu sebelum membuat data barang.
                            </p>
                            <a href="{{ route('categories.create') }}"
                               class="inline-block mt-3 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm font-semibold">
                                Tambah Kategori
                            </a>
                        </div>
                    @endif

                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label for="code" class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-200">
                                    Kode Barang
                                </label>
                                <input type="text"
                                       id="code"
                                       name="code"
                                       value="{{ old('code') }}"
                                       placeholder="Contoh: BRG-001"
                                       class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 rounded-lg shadow-sm focus:border-red-500 focus:ring-red-500">
                                @error('code')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="name" class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-200">
                                    Nama Barang
                                </label>
                                <input type="text"
                                       id="name"
                                       name="name"
                                       value="{{ old('name') }}"
                                       placeholder="Contoh: Laptop Lenovo ThinkPad"
                                       class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 rounded-lg shadow-sm focus:border-red-500 focus:ring-red-500">
                                @error('name')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="category_id" class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-200">
                                    Kategori
                                </label>
                                <select id="category_id"
                                        name="category_id"
                                        class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 rounded-lg shadow-sm focus:border-red-500 focus:ring-red-500">
                                    <option value="">Pilih Kategori</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="stock" class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-200">
                                    Stok
                                </label>
                                <input type="number"
                                       id="stock"
                                       name="stock"
                                       value="{{ old('stock') }}"
                                       min="0"
                                       placeholder="Contoh: 10"
                                       class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 rounded-lg shadow-sm focus:border-red-500 focus:ring-red-500">
                                @error('stock')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="location" class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-200">
                                    Lokasi Penyimpanan
                                </label>
                                <input type="text"
                                       id="location"
                                       name="location"
                                       value="{{ old('location') }}"
                                       placeholder="Contoh: Gudang A / Rak 1"
                                       class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 rounded-lg shadow-sm focus:border-red-500 focus:ring-red-500">
                                @error('location')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="condition" class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-200">
                                    Kondisi Barang
                                </label>
                                <select id="condition"
                                        name="condition"
                                        class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 rounded-lg shadow-sm focus:border-red-500 focus:ring-red-500">
                                    <option value="">Pilih Kondisi</option>
                                    <option value="Baik" {{ old('condition') == 'Baik' ? 'selected' : '' }}>Baik</option>
                                    <option value="Rusak Ringan" {{ old('condition') == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                                    <option value="Rusak Berat" {{ old('condition') == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                                </select>
                                @error('condition')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="image" class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-200">
                                    Upload Gambar Barang
                                </label>
                                <input type="file"
                                       id="image"
                                       name="image"
                                       accept="image/*"
                                       class="w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 rounded-lg shadow-sm px-3 py-2 focus:border-red-500 focus:ring-red-500">
                                <p class="text-xs text-gray-500 mt-1">
                                    Format: JPG, JPEG, PNG. Maksimal 2MB.
                                </p>
                                @error('image')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex items-center gap-3 mt-7">
                            <button type="submit"
                                    class="px-5 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm font-semibold shadow-sm">
                                Simpan
                            </button>

                            <a href="{{ route('products.index') }}"
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
