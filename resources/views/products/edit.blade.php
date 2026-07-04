<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            Edit Barang
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 bg-white dark:bg-gray-800 p-6 rounded shadow">
            <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-1">Kode Barang</label>

                        <input
                            type="text"
                            name="code"
                            value="{{ old('code', $product->code) }}"
                            class="w-full border rounded px-3 py-2"
                        >

                        @error('code')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block mb-1">Nama Barang</label>

                        <input
                            type="text"
                            name="name"
                            value="{{ old('name', $product->name) }}"
                            class="w-full border rounded px-3 py-2"
                        >

                        @error('name')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block mb-1">Kategori</label>

                        <select name="category_id" class="w-full border rounded px-3 py-2">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>

                        @error('category_id')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block mb-1">Stok</label>

                        <input
                            type="number"
                            name="stock"
                            value="{{ old('stock', $product->stock) }}"
                            min="0"
                            class="w-full border rounded px-3 py-2"
                        >

                        @error('stock')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block mb-1">Lokasi Penyimpanan</label>

                        <input
                            type="text"
                            name="location"
                            value="{{ old('location', $product->location) }}"
                            class="w-full border rounded px-3 py-2"
                        >

                        @error('location')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block mb-1">Kondisi Barang</label>

                        <select name="condition" class="w-full border rounded px-3 py-2">
                            <option value="Baik" {{ old('condition', $product->condition) == 'Baik' ? 'selected' : '' }}>Baik</option>
                            <option value="Rusak Ringan" {{ old('condition', $product->condition) == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                            <option value="Rusak Berat" {{ old('condition', $product->condition) == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                        </select>

                        @error('condition')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block mb-1">Gambar Barang</label>

                        @if($product->image)
                            <img
                                src="{{ asset('storage/' . $product->image) }}"
                                alt="{{ $product->name }}"
                                class="w-32 h-32 object-cover rounded mb-3"
                            >
                        @endif

                        <input
                            type="file"
                            name="image"
                            class="w-full border rounded px-3 py-2"
                        >

                        @error('image')
                            <p class="text-red-600 text-sm">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6">
                    <button class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded">
                        Update
                    </button>

                    <a href="{{ route('products.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded">
                        Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
