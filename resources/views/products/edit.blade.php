<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-100 leading-tight">
                Edit Barang
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Perbarui data barang inventaris kantor.
            </p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 px-4">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">

                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100">
                        Form Edit Barang
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Ubah data barang sesuai kebutuhan.
                    </p>
                </div>

                <div class="p-6">
                    <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label for="code" class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-200">
                                    Kode Barang
                                </label>
                                <input type="text"
                                       id="code"
                                       name="code"
                                       value="{{ old('code', $product->code) }}"
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
                                       value="{{ old('name', $product->name) }}"
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
                                        <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
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
                                       value="{{ old('stock', $product->stock) }}"
                                       min="0"
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
                                       value="{{ old('location', $product->location) }}"
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
                                    <option value="Baik" {{ old('condition', $product->condition) == 'Baik' ? 'selected' : '' }}>Baik</option>
                                    <option value="Rusak Ringan" {{ old('condition', $product->condition) == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                                    <option value="Rusak Berat" {{ old('condition', $product->condition) == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                                </select>
                                @error('condition')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="image" class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-200">
                                    Gambar Barang
                                </label>

                                @if($product->image)
                                    <div class="mb-3">
                                        <img src="{{ asset('storage/' . $product->image) }}"
                                             alt="{{ $product->name }}"
                                             class="w-32 h-32 object-cover rounded-lg border">
                                        <p class="text-xs text-gray-500 mt-1">
                                            Gambar saat ini.
                                        </p>
                                    </div>
                                @endif

                                <input type="file"
                                       id="image"
                                       name="image"
                                       accept="image/*"
                                       class="w-full border border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 rounded-lg shadow-sm px-3 py-2 focus:border-red-500 focus:ring-red-500">
                                <p class="text-xs text-gray-500 mt-1">
                                    Kosongkan jika tidak ingin mengubah gambar.
                                </p>
                                @error('image')
                                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex items-center gap-3 mt-7">
                            <button type="submit"
                                    class="px-5 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm font-semibold shadow-sm">
                                Update
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
