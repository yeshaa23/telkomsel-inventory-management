<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-bold text-2xl text-gray-800 dark:text-gray-100 leading-tight">
                Edit Kategori
            </h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                Perbarui data kategori barang inventaris.
            </p>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 px-4">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">

                <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100">
                        Form Edit Kategori
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Ubah informasi kategori sesuai kebutuhan.
                    </p>
                </div>

                <div class="p-6">
                    <form action="{{ route('categories.update', $category) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-5">
                            <label for="name" class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-200">
                                Nama Kategori
                            </label>

                            <input type="text"
                                   id="name"
                                   name="name"
                                   value="{{ old('name', $category->name) }}"
                                   class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 rounded-lg shadow-sm focus:border-red-500 focus:ring-red-500">

                            @error('name')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="description" class="block mb-2 text-sm font-semibold text-gray-700 dark:text-gray-200">
                                Deskripsi
                            </label>

                            <textarea id="description"
                                      name="description"
                                      rows="4"
                                      class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100 rounded-lg shadow-sm focus:border-red-500 focus:ring-red-500">{{ old('description', $category->description) }}</textarea>

                            @error('description')
                                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center gap-3">
                            <button type="submit"
                                    class="px-5 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg text-sm font-semibold shadow-sm">
                                Update
                            </button>

                            <a href="{{ route('categories.index') }}"
                               class="px-5 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg text-sm font-semibold shadow-sm">
                                Kembali
                            </a>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
