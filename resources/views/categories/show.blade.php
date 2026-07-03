<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-100 leading-tight">
                Detail Kategori
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Informasi detail kategori barang inventaris.
            </p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 px-4">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">

                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100">
                        {{ $category->name }}
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Detail data kategori.
                    </p>
                </div>

                <div class="p-6 space-y-5">
                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Nama Kategori</p>
                        <p class="mt-1 text-gray-800 dark:text-gray-100 font-semibold">
                            {{ $category->name }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Deskripsi</p>
                        <p class="mt-1 text-gray-800 dark:text-gray-100">
                            {{ $category->description ?? '-' }}
                        </p>
                    </div>

                    <div>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Tanggal Dibuat</p>
                        <p class="mt-1 text-gray-800 dark:text-gray-100">
                            {{ $category->created_at->format('d M Y H:i') }}
                        </p>
                    </div>

                    <div class="flex items-center gap-3 pt-4">
                        <a href="{{ route('categories.edit', $category) }}"
                           class="px-5 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm font-semibold shadow-sm">
                            Edit
                        </a>

                        <a href="{{ route('categories.index') }}"
                           class="px-5 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg text-sm font-semibold shadow-sm">
                            Kembali
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
