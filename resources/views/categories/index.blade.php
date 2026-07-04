<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            Data Kategori
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
                    <h3 class="text-lg font-semibold">
                        Master Data Kategori
                    </h3>

                    <p class="text-sm text-gray-500">
                        Kelola kategori barang untuk membantu pengelompokan inventaris kantor.
                    </p>
                </div>

                <a href="{{ route('categories.create') }}" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded">
                    Tambah Kategori
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full border">
                    <thead class="bg-gray-100 dark:bg-gray-700">
                        <tr>
                            <th class="border px-4 py-2 text-left">No</th>
                            <th class="border px-4 py-2 text-left">Nama Kategori</th>
                            <th class="border px-4 py-2 text-left">Deskripsi</th>
                            <th class="border px-4 py-2 text-left">Jumlah Barang</th>
                            <th class="border px-4 py-2 text-left">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($categories as $category)
                            <tr>
                                <td class="border px-4 py-2">
                                    {{ $loop->iteration }}
                                </td>

                                <td class="border px-4 py-2">
                                    {{ $category->name }}
                                </td>

                                <td class="border px-4 py-2">
                                    {{ $category->description ?? '-' }}
                                </td>

                                <td class="border px-4 py-2">
                                    {{ $category->products()->count() }}
                                </td>

                                <td class="border px-4 py-2">
                                    <a href="{{ route('categories.show', $category) }}" class="text-blue-600">
                                        Detail
                                    </a>
                                    |
                                    <a href="{{ route('categories.edit', $category) }}" class="text-yellow-600">
                                        Edit
                                    </a>
                                    |
                                    <form id="delete-category-{{ $category->id }}" action="{{ route('categories.destroy', $category) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="button"
                                            onclick="openConfirmModal('Yakin ingin menghapus kategori ini? Barang pada kategori ini juga dapat ikut terhapus.', 'delete-category-{{ $category->id }}')"
                                            class="text-red-600"
                                        >
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="border px-4 py-10 text-center text-gray-500">
                                    <p class="font-semibold">Belum ada data kategori.</p>
                                    <p class="text-sm mt-1">
                                        Klik Tambah Kategori untuk mulai mengelompokkan barang inventaris.
                                    </p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $categories->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
