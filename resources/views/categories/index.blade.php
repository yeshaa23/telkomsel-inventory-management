<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-100 leading-tight">
                Data Kategori
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Kelola kategori barang inventaris kantor.
            </p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-4">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">

                <div class="p-6 border-b border-gray-200 dark:border-gray-700 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100">
                            Daftar Kategori
                        </h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            Data kategori digunakan untuk mengelompokkan barang inventaris.
                        </p>
                    </div>

                    <a href="{{ route('categories.create') }}"
                       class="inline-flex items-center justify-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm font-semibold shadow-sm">
                        + Tambah Kategori
                    </a>
                </div>

                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="w-full border border-gray-200 dark:border-gray-700">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th class="border border-gray-200 dark:border-gray-700 px-4 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-100">
                                        No
                                    </th>
                                    <th class="border border-gray-200 dark:border-gray-700 px-4 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-100">
                                        Nama Kategori
                                    </th>
                                    <th class="border border-gray-200 dark:border-gray-700 px-4 py-3 text-left text-sm font-semibold text-gray-700 dark:text-gray-100">
                                        Deskripsi
                                    </th>
                                    <th class="border border-gray-200 dark:border-gray-700 px-4 py-3 text-center text-sm font-semibold text-gray-700 dark:text-gray-100">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($categories as $category)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                        <td class="border border-gray-200 dark:border-gray-700 px-4 py-3 text-sm text-gray-700 dark:text-gray-200">
                                            {{ $loop->iteration + ($categories->currentPage() - 1) * $categories->perPage() }}
                                        </td>

                                        <td class="border border-gray-200 dark:border-gray-700 px-4 py-3 text-sm font-semibold text-gray-800 dark:text-gray-100">
                                            {{ $category->name }}
                                        </td>

                                        <td class="border border-gray-200 dark:border-gray-700 px-4 py-3 text-sm text-gray-700 dark:text-gray-200">
                                            {{ $category->description ?? '-' }}
                                        </td>

                                        <td class="border border-gray-200 dark:border-gray-700 px-4 py-3 text-sm">
                                            <div class="flex items-center justify-center gap-2">
                                                <a href="{{ route('categories.show', $category) }}"
                                                   class="px-3 py-1 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded text-xs font-semibold">
                                                    Detail
                                                </a>

                                                <a href="{{ route('categories.edit', $category) }}"
                                                   class="px-3 py-1 bg-yellow-100 hover:bg-yellow-200 text-yellow-700 rounded text-xs font-semibold">
                                                    Edit
                                                </a>

                                                <form action="{{ route('categories.destroy', $category) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit"
                                                            onclick="return confirm('Yakin ingin menghapus kategori ini?')"
                                                            class="px-3 py-1 bg-red-100 hover:bg-red-200 text-red-700 rounded text-xs font-semibold">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="border border-gray-200 dark:border-gray-700 px-4 py-8 text-center text-sm text-gray-500 dark:text-gray-400">
                                            Belum ada data kategori.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-5">
                        {{ $categories->links() }}
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
