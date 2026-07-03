<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-100 leading-tight">
                Data Barang
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Kelola data barang inventaris kantor, stok, lokasi penyimpanan, dan kondisi barang.
            </p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-4">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">

                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                        <div>
                            <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100">
                                Daftar Barang Inventaris
                            </h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Data barang dapat dicari berdasarkan nama, kode, atau lokasi penyimpanan.
                            </p>
                        </div>

                        <a href="{{ route('products.create') }}"
                           class="inline-flex items-center justify-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm font-semibold shadow-sm">
                            + Tambah Barang
                        </a>
                    </div>

                    <div class="mt-5">
                        <form method="GET" action="{{ route('products.index') }}" class="flex flex-col md:flex-row gap-3">
                            <input type="text"
                                   name="search"
                                   value="{{ $search ?? '' }}"
                                   placeholder="Cari berdasarkan kode, nama, atau lokasi barang..."
                                   class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 rounded-lg shadow-sm focus:border-red-500 focus:ring-red-500">

                            <button type="submit"
                                    class="px-5 py-2 bg-gray-800 hover:bg-gray-900 text-white rounded-lg text-sm font-semibold shadow-sm">
                                Cari
                            </button>

                            <a href="{{ route('products.index') }}"
                               class="px-5 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg text-sm font-semibold shadow-sm text-center">
                                Reset
                            </a>
                        </form>
                    </div>
                </div>

                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="w-full border border-gray-200 dark:border-gray-700">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th class="border border-gray-200 dark:border-gray-700 px-4 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-100">
                                        Gambar
                                    </th>
                                    <th class="border border-gray-200 dark:border-gray-700 px-4 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-100">
                                        Kode
                                    </th>
                                    <th class="border border-gray-200 dark:border-gray-700 px-4 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-100">
                                        Nama Barang
                                    </th>
                                    <th class="border border-gray-200 dark:border-gray-700 px-4 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-100">
                                        Kategori
                                    </th>
                                    <th class="border border-gray-200 dark:border-gray-700 px-4 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-100">
                                        Stok
                                    </th>
                                    <th class="border border-gray-200 dark:border-gray-700 px-4 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-100">
                                        Lokasi
                                    </th>
                                    <th class="border border-gray-200 dark:border-gray-700 px-4 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-100">
                                        Kondisi
                                    </th>
                                    <th class="border border-gray-200 dark:border-gray-700 px-4 py-3 text-center text-sm font-semibold text-gray-700 dark:text-gray-100">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($products as $product)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="border border-gray-200 dark:border-gray-700 px-4 py-3">
                                            @if($product->image)
                                                <img src="{{ asset('storage/' . $product->image) }}"
                                                     alt="{{ $product->name }}"
                                                     class="w-14 h-14 object-cover rounded-lg border">
                                            @else
                                                <div class="w-14 h-14 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-xs text-gray-500">
                                                    No Image
                                                </div>
                                            @endif
                                        </td>

                                        <td class="border border-gray-200 dark:border-gray-700 px-4 py-3 text-sm font-semibold text-gray-800 dark:text-gray-100">
                                            {{ $product->code }}
                                        </td>

                                        <td class="border border-gray-200 dark:border-gray-700 px-4 py-3 text-sm text-gray-700 dark:text-gray-200">
                                            {{ $product->name }}
                                        </td>

                                        <td class="border border-gray-200 dark:border-gray-700 px-4 py-3 text-sm text-gray-700 dark:text-gray-200">
                                            {{ $product->category->name ?? '-' }}
                                        </td>

                                        <td class="border border-gray-200 dark:border-gray-700 px-4 py-3 text-sm">
                                            @if($product->stock <= 5)
                                                <span class="px-2 py-1 bg-red-100 text-red-700 rounded text-xs font-bold">
                                                    {{ $product->stock }}
                                                </span>
                                            @else
                                                <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs font-bold">
                                                    {{ $product->stock }}
                                                </span>
                                            @endif
                                        </td>

                                        <td class="border border-gray-200 dark:border-gray-700 px-4 py-3 text-sm text-gray-700 dark:text-gray-200">
                                            {{ $product->location }}
                                        </td>

                                        <td class="border border-gray-200 dark:border-gray-700 px-4 py-3 text-sm">
                                            @if($product->condition === 'Baik')
                                                <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs font-semibold">
                                                    Baik
                                                </span>
                                            @elseif($product->condition === 'Rusak Ringan')
                                                <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded text-xs font-semibold">
                                                    Rusak Ringan
                                                </span>
                                            @else
                                                <span class="px-2 py-1 bg-red-100 text-red-700 rounded text-xs font-semibold">
                                                    Rusak Berat
                                                </span>
                                            @endif
                                        </td>

                                        <td class="border border-gray-200 dark:border-gray-700 px-4 py-3 text-sm">
                                            <div class="flex items-center justify-center gap-2">
                                                <a href="{{ route('products.show', $product) }}"
                                                   class="px-3 py-1 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded text-xs font-semibold">
                                                    Detail
                                                </a>

                                                <a href="{{ route('products.edit', $product) }}"
                                                   class="px-3 py-1 bg-yellow-100 hover:bg-yellow-200 text-yellow-700 rounded text-xs font-semibold">
                                                    Edit
                                                </a>

                                                <form action="{{ route('products.destroy', $product) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit"
                                                            onclick="return confirm('Yakin ingin menghapus barang ini?')"
                                                            class="px-3 py-1 bg-red-100 hover:bg-red-200 text-red-700 rounded text-xs font-semibold">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="border border-gray-200 dark:border-gray-700 px-4 py-8 text-center text-sm text-gray-500 dark:text-gray-400">
                                            Belum ada data barang.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-5">
                        {{ $products->links() }}
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
