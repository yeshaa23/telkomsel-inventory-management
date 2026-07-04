<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            Detail Kategori
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 bg-white dark:bg-gray-800 p-6 rounded shadow">
            <div class="space-y-3">
                <p>
                    <strong>Nama Kategori:</strong>
                    {{ $category->name }}
                </p>

                <p>
                    <strong>Deskripsi:</strong>
                    {{ $category->description ?? '-' }}
                </p>

                <p>
                    <strong>Jumlah Barang:</strong>
                    {{ $category->products()->count() }}
                </p>
            </div>

            <div class="mt-6">
                <a href="{{ route('categories.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded">
                    Kembali
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
