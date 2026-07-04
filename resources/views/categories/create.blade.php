<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            Tambah Kategori
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 bg-white dark:bg-gray-800 p-6 rounded shadow">
            <form action="{{ route('categories.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="block mb-1">
                        Nama Kategori
                    </label>

                    <input
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        class="w-full border rounded px-3 py-2"
                    >

                    @error('name')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block mb-1">
                        Deskripsi
                    </label>

                    <textarea
                        name="description"
                        rows="4"
                        class="w-full border rounded px-3 py-2"
                    >{{ old('description') }}</textarea>

                    @error('description')
                        <p class="text-red-600 text-sm">{{ $message }}</p>
                    @enderror
                </div>

                <button class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded">
                    Simpan
                </button>

                <a href="{{ route('categories.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded">
                    Kembali
                </a>
            </form>
        </div>
    </div>
</x-app-layout>
