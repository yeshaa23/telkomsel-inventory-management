<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Telkomsel Inventory') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-red-700 via-red-600 to-gray-900 px-4">

            <!-- Brand Section -->
            <div class="mb-6 text-center">
                <a href="/" class="inline-flex items-center justify-center">
                    <div class="w-20 h-20 bg-white rounded-2xl shadow-lg flex items-center justify-center">
                        <span class="text-4xl font-bold text-red-600">T</span>
                    </div>
                </a>

                <h1 class="mt-4 text-2xl font-bold text-white">
                    Telkomsel Inventory
                </h1>

                <p class="mt-1 text-sm text-red-100">
                    Sistem Manajemen Inventaris Kantor
                </p>
            </div>

            <!-- Auth Card -->
            <div class="w-full sm:max-w-md px-6 py-6 bg-white dark:bg-gray-800 shadow-xl overflow-hidden sm:rounded-2xl border border-gray-100">
                {{ $slot }}
            </div>

            <!-- Footer -->
            <p class="mt-6 text-xs text-red-100 text-center">
                © {{ date('Y') }} Telkomsel Inventory Management System
            </p>
        </div>
    </body>
</html>
