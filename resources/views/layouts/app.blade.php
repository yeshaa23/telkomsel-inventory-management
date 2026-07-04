<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Telkomsel Inventory') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet">

        <script>
            if (
                localStorage.getItem('theme') === 'dark' ||
                (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)
            ) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        </script>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="font-sans antialiased bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">
        <div class="min-h-screen flex">
            <aside class="w-64 bg-white dark:bg-gray-800 border-r dark:border-gray-700 hidden md:block">
                <div class="p-6 border-b dark:border-gray-700">
                    <h1 class="text-xl font-bold text-red-600">
                        Telkomsel Inventory
                    </h1>

                    <p class="text-sm text-gray-500 dark:text-gray-300 mt-1">
                        Sistem Manajemen Inventaris
                    </p>
                </div>

                <nav class="p-4 space-y-2">
                    <a href="{{ route('dashboard') }}"
                        class="block px-4 py-2 rounded transition {{ request()->routeIs('dashboard') ? 'bg-red-600 text-white' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                        Dashboard
                    </a>

                    @if(auth()->user()->hasRole(['Admin', 'Staff']))
                        <a href="{{ route('categories.index') }}"
                            class="block px-4 py-2 rounded transition {{ request()->routeIs('categories.*') ? 'bg-red-600 text-white' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                            Kategori
                        </a>

                        <a href="{{ route('products.index') }}"
                            class="block px-4 py-2 rounded transition {{ request()->routeIs('products.*') ? 'bg-red-600 text-white' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                            Barang
                        </a>

                        <a href="{{ route('borrowings.index') }}"
                            class="block px-4 py-2 rounded transition {{ request()->routeIs('borrowings.*') ? 'bg-red-600 text-white' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                            Peminjaman
                        </a>
                    @endif

                    @if(auth()->user()->hasRole(['Admin', 'Manager']))
                        <a href="{{ route('reports.index') }}"
                            class="block px-4 py-2 rounded transition {{ request()->routeIs('reports.*') ? 'bg-red-600 text-white' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                            Laporan
                        </a>
                    @endif

                    @if(auth()->user()->hasRole('Admin'))
                        <a href="{{ route('activity-logs.index') }}"
                            class="block px-4 py-2 rounded transition {{ request()->routeIs('activity-logs.*') ? 'bg-red-600 text-white' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                            Riwayat Aktivitas
                        </a>
                    @endif
                </nav>
            </aside>

            <div class="flex-1 min-w-0">
                <header class="bg-white dark:bg-gray-800 border-b dark:border-gray-700 sticky top-0 z-30">
                    <div class="px-6 py-4 flex justify-between items-center gap-4">
                        <div>
                            @isset($header)
                                {{ $header }}
                            @else
                                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
                                    Dashboard
                                </h2>
                            @endisset
                        </div>

                        <div class="flex items-center gap-3">
                            <button
                                type="button"
                                id="theme-toggle"
                                class="px-3 py-2 rounded bg-gray-200 text-gray-800 dark:bg-gray-700 dark:text-gray-100 text-sm"
                            >
                                <span id="theme-toggle-text">Dark Mode</span>
                            </button>

                            <a href="{{ route('profile.edit') }}" class="text-sm hover:underline">
                                {{ auth()->user()->name }}
                            </a>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <button class="px-3 py-2 bg-red-600 hover:bg-red-700 text-white rounded text-sm">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="md:hidden px-4 pb-4">
                        <div class="grid grid-cols-2 gap-2 text-sm">
                            <a href="{{ route('dashboard') }}"
                                class="px-3 py-2 rounded text-center {{ request()->routeIs('dashboard') ? 'bg-red-600 text-white' : 'bg-gray-100 dark:bg-gray-700' }}">
                                Dashboard
                            </a>

                            @if(auth()->user()->hasRole(['Admin', 'Staff']))
                                <a href="{{ route('products.index') }}"
                                    class="px-3 py-2 rounded text-center {{ request()->routeIs('products.*') ? 'bg-red-600 text-white' : 'bg-gray-100 dark:bg-gray-700' }}">
                                    Barang
                                </a>

                                <a href="{{ route('borrowings.index') }}"
                                    class="px-3 py-2 rounded text-center {{ request()->routeIs('borrowings.*') ? 'bg-red-600 text-white' : 'bg-gray-100 dark:bg-gray-700' }}">
                                    Peminjaman
                                </a>
                            @endif

                            @if(auth()->user()->hasRole(['Admin', 'Manager']))
                                <a href="{{ route('reports.index') }}"
                                    class="px-3 py-2 rounded text-center {{ request()->routeIs('reports.*') ? 'bg-red-600 text-white' : 'bg-gray-100 dark:bg-gray-700' }}">
                                    Laporan
                                </a>
                            @endif
                        </div>
                    </div>
                </header>

                <main>
                    {{ $slot }}
                </main>
            </div>
        </div>

        <div id="confirm-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 items-center justify-center z-50 px-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-md p-6">
                <h3 class="text-lg font-semibold mb-2">
                    Konfirmasi Aksi
                </h3>

                <p id="confirm-message" class="text-gray-600 dark:text-gray-300 mb-6">
                    Apakah Anda yakin?
                </p>

                <div class="flex justify-end gap-2">
                    <button
                        type="button"
                        onclick="closeConfirmModal()"
                        class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded"
                    >
                        Batal
                    </button>

                    <button
                        type="button"
                        onclick="submitConfirmForm()"
                        class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded"
                    >
                        Ya, Lanjutkan
                    </button>
                </div>
            </div>
        </div>

        <script>
            let selectedFormId = null;

            function openConfirmModal(message, formId) {
                selectedFormId = formId;

                document.getElementById('confirm-message').textContent = message;
                document.getElementById('confirm-modal').classList.remove('hidden');
                document.getElementById('confirm-modal').classList.add('flex');
            }

            function closeConfirmModal() {
                selectedFormId = null;

                document.getElementById('confirm-modal').classList.add('hidden');
                document.getElementById('confirm-modal').classList.remove('flex');
            }

            function submitConfirmForm() {
                if (selectedFormId) {
                    document.getElementById(selectedFormId).submit();
                }
            }

            document.addEventListener('DOMContentLoaded', function () {
                const toggleButton = document.getElementById('theme-toggle');
                const toggleText = document.getElementById('theme-toggle-text');

                function updateThemeText() {
                    if (!toggleText) {
                        return;
                    }

                    if (document.documentElement.classList.contains('dark')) {
                        toggleText.textContent = 'Light Mode';
                    } else {
                        toggleText.textContent = 'Dark Mode';
                    }
                }

                updateThemeText();

                if (toggleButton) {
                    toggleButton.addEventListener('click', function () {
                        document.documentElement.classList.toggle('dark');

                        if (document.documentElement.classList.contains('dark')) {
                            localStorage.setItem('theme', 'dark');
                        } else {
                            localStorage.setItem('theme', 'light');
                        }

                        updateThemeText();
                    });
                }
            });
        </script>
    </body>
</html>
