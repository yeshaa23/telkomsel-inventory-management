<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            Data Barang
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white dark:bg-gray-800 p-6 rounded shadow">
            @if(session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-6 flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-semibold">Master Data Barang</h3>
                    <p class="text-sm text-gray-500">
                        Kelola data inventaris, stok, lokasi penyimpanan, dan kondisi barang.
                    </p>
                </div>

                <a href="{{ route('products.create') }}" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded">
                    Tambah Barang
                </a>
            </div>

            <form method="GET" action="{{ route('products.index') }}" class="grid grid-cols-1 md:grid-cols-6 gap-3 mb-6">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari kode/nama/lokasi"
                    class="border rounded px-3 py-2"
                >

                <select name="category_id" class="border rounded px-3 py-2">
                    <option value="">Semua Kategori</option>

                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>

                <select name="condition" class="border rounded px-3 py-2">
                    <option value="">Semua Kondisi</option>
                    <option value="Baik" {{ request('condition') == 'Baik' ? 'selected' : '' }}>Baik</option>
                    <option value="Rusak Ringan" {{ request('condition') == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                    <option value="Rusak Berat" {{ request('condition') == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                </select>

                <select name="stock_status" class="border rounded px-3 py-2">
                    <option value="">Semua Status</option>
                    <option value="available" {{ request('stock_status') == 'available' ? 'selected' : '' }}>Tersedia</option>
                    <option value="low_stock" {{ request('stock_status') == 'low_stock' ? 'selected' : '' }}>Stok Menipis</option>
                    <option value="out_of_stock" {{ request('stock_status') == 'out_of_stock' ? 'selected' : '' }}>Habis</option>
                    <option value="damaged" {{ request('stock_status') == 'damaged' ? 'selected' : '' }}>Rusak</option>
                </select>

                <select name="sort" class="border rounded px-3 py-2">
                    <option value="">Terbaru</option>
                    <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Nama A-Z</option>
                    <option value="stock_asc" {{ request('sort') == 'stock_asc' ? 'selected' : '' }}>Stok Terendah</option>
                    <option value="stock_desc" {{ request('sort') == 'stock_desc' ? 'selected' : '' }}>Stok Tertinggi</option>
                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                </select>

                <div class="flex gap-2">
                    <button class="px-4 py-2 bg-gray-700 text-white rounded">
                        Filter
                    </button>

                    <a href="{{ route('products.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded">
                        Reset
                    </a>
                </div>
            </form>

            <div class="overflow-x-auto">
                <table class="w-full border">
                    <thead class="bg-gray-100 dark:bg-gray-700">
                        <tr>
                            <th class="border px-4 py-2 text-left">Kode</th>
                            <th class="border px-4 py-2 text-left">Nama</th>
                            <th class="border px-4 py-2 text-left">Kategori</th>
                            <th class="border px-4 py-2 text-left">Stok</th>
                            <th class="border px-4 py-2 text-left">Lokasi</th>
                            <th class="border px-4 py-2 text-left">Kondisi</th>
                            <th class="border px-4 py-2 text-left">Status</th>
                            <th class="border px-4 py-2 text-left">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td class="border px-4 py-2">{{ $product->code }}</td>
                                <td class="border px-4 py-2">{{ $product->name }}</td>
                                <td class="border px-4 py-2">{{ $product->category->name ?? '-' }}</td>
                                <td class="border px-4 py-2">{{ $product->stock }}</td>
                                <td class="border px-4 py-2">{{ $product->location }}</td>
                                <td class="border px-4 py-2">{{ $product->condition }}</td>

                                <td class="border px-4 py-2">
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
                                </td>

                                <td class="border px-4 py-2">
                                    <a href="{{ route('products.show', $product) }}" class="text-blue-600">
                                        Detail
                                    </a>
                                    |
                                    <a href="{{ route('products.edit', $product) }}" class="text-yellow-600">
                                        Edit
                                    </a>
                                    |
                                    <form id="delete-product-{{ $product->id }}" action="{{ route('products.destroy', $product) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="button"
                                            onclick="openConfirmModal('Yakin ingin menghapus barang ini? Data yang dihapus tidak dapat dikembalikan.', 'delete-product-{{ $product->id }}')"
                                            class="text-red-600"
                                        >
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="border px-4 py-10 text-center text-gray-500">
                                    <p class="font-semibold">Belum ada data barang.</p>
                                    <p class="text-sm mt-1">
                                        Klik tombol Tambah Barang untuk mulai mencatat inventaris.
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
