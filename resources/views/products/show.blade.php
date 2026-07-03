<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-100 leading-tight">
                Detail Barang
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Informasi lengkap barang inventaris kantor.
            </p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 px-4">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">

                <div class="p-6 border-b border-gray-200 dark:border-gray-700 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100">
                            {{ $product->name }}
                        </h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Kode Barang: {{ $product->code }}
                        </p>
                    </div>

                    @if($product->stock <= 5)
                        <span class="inline-flex px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-bold">
                            Stok Menipis
                        </span>
                    @else
                        <span class="inline-flex px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">
                            Stok Aman
                        </span>
                    @endif
                </div>

                <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="md:col-span-1">
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}"
                                 alt="{{ $product->name }}"
                                 class="w-full h-64 object-cover rounded-xl border">
                        @else
                            <div class="w-full h-64 rounded-xl bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-gray-500">
                                Tidak ada gambar
                            </div>
                        @endif
                    </div>

                    <div class="md:col-span-2">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                                <p class="text-sm text-gray-500 dark:text-gray-400">Kode Barang</p>
                                <p class="mt-1 text-gray-800 dark:text-gray-100 font-semibold">
                                    {{ $product->code }}
                                </p>
                            </div>

                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                                <p class="text-sm text-gray-500 dark:text-gray-400">Nama Barang</p>
                                <p class="mt-1 text-gray-800 dark:text-gray-100 font-semibold">
                                    {{ $product->name }}
                                </p>
                            </div>

                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                                <p class="text-sm text-gray-500 dark:text-gray-400">Kategori</p>
                                <p class="mt-1 text-gray-800 dark:text-gray-100 font-semibold">
                                    {{ $product->category->name ?? '-' }}
                                </p>
                            </div>

                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                                <p class="text-sm text-gray-500 dark:text-gray-400">Stok</p>
                                <p class="mt-1 text-gray-800 dark:text-gray-100 font-semibold">
                                    {{ $product->stock }}
                                </p>
                            </div>

                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                                <p class="text-sm text-gray-500 dark:text-gray-400">Lokasi Penyimpanan</p>
                                <p class="mt-1 text-gray-800 dark:text-gray-100 font-semibold">
                                    {{ $product->location }}
                                </p>
                            </div>

                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                                <p class="text-sm text-gray-500 dark:text-gray-400">Kondisi Barang</p>
                                <p class="mt-1 text-gray-800 dark:text-gray-100 font-semibold">
                                    {{ $product->condition }}
                                </p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 mt-7">
                            <a href="{{ route('products.edit', $product) }}"
                               class="px-5 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm font-semibold shadow-sm">
                                Edit
                            </a>

                            <a href="{{ route('products.index') }}"
                               class="px-5 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg text-sm font-semibold shadow-sm">
                                Kembali
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
