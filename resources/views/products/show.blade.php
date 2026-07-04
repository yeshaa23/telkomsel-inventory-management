<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            Detail Barang
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 bg-white dark:bg-gray-800 p-6 rounded shadow">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    @if($product->image)
                        <img
                            src="{{ asset('storage/' . $product->image) }}"
                            alt="{{ $product->name }}"
                            class="w-full h-56 object-cover rounded"
                        >
                    @else
                        <div class="w-full h-56 bg-gray-100 dark:bg-gray-700 rounded flex items-center justify-center text-gray-500">
                            Tidak ada gambar
                        </div>
                    @endif
                </div>

                <div class="md:col-span-2 space-y-3">
                    <p><strong>Kode:</strong> {{ $product->code }}</p>
                    <p><strong>Nama:</strong> {{ $product->name }}</p>
                    <p><strong>Kategori:</strong> {{ $product->category->name ?? '-' }}</p>
                    <p><strong>Stok:</strong> {{ $product->stock }}</p>
                    <p><strong>Lokasi:</strong> {{ $product->location }}</p>
                    <p><strong>Kondisi:</strong> {{ $product->condition }}</p>

                    <p>
                        <strong>Status:</strong>

                        @if($product->stock_status === 'available')
                            <span class="px-2 py-1 rounded text-xs bg-green-100 text-green-700">
                                {{ $product->stock_status_label }}
                            </span>
                        @elseif($product->stock_status === 'low_stock')
                            <span class="px-2 py-1 rounded text-xs bg-yellow-100 text-yellow-700">
                                {{ $product->stock_status_label }}
                            </span>
                        @elseif($product->stock_status === 'out_of_stock')
                            <span class="px-2 py-1 rounded text-xs bg-red-100 text-red-700">
                                {{ $product->stock_status_label }}
                            </span>
                        @else
                            <span class="px-2 py-1 rounded text-xs bg-orange-100 text-orange-700">
                                {{ $product->stock_status_label }}
                            </span>
                        @endif
                    </p>
                </div>
            </div>

            <div class="mt-6">
                <a href="{{ route('products.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded">
                    Kembali
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
