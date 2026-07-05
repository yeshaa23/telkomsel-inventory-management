<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register - Telkomsel Inventory</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-50 text-slate-900 antialiased">
    <main class="min-h-screen">
        <div class="grid min-h-screen lg:grid-cols-[1.15fr_0.85fr]">
            <section class="hidden bg-gradient-to-br from-red-700 via-red-600 to-red-800 px-12 py-10 text-white lg:flex lg:flex-col lg:justify-between">
                <div>
                    <div class="flex items-center gap-4">
                        <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-white shadow-lg">
                            <img
                                src="{{ asset('images/telkomsel-logo.png') }}"
                                alt="Telkomsel Logo"
                                class="h-10 w-10 object-contain"
                            >
                        </div>

                        <div>
                            <h1 class="text-2xl font-bold tracking-tight">
                                Telkomsel Inventory
                            </h1>
                            <p class="text-sm text-red-100">
                                Internal Asset Management System
                            </p>
                        </div>
                    </div>

                    <div class="mt-24 max-w-3xl">
                        <span class="inline-flex rounded-full border border-white/20 bg-white/10 px-4 py-2 text-xs font-semibold">
                            Inventory Center
                        </span>

                        <h2 class="mt-8 text-5xl font-extrabold leading-tight tracking-tight xl:text-6xl">
                            Create an account based on inventory access needs.
                        </h2>

                        <p class="mt-8 max-w-2xl text-lg leading-8 text-red-50">
                            Register a new account and choose the proper role so users can access features based on their responsibilities.
                        </p>
                    </div>
                </div>

                <div class="grid gap-4 xl:grid-cols-3">
                    <div class="rounded-2xl border border-white/15 bg-white/10 p-5 backdrop-blur">
                        <h3 class="text-sm font-bold">
                            Inventory Tracking
                        </h3>
                        <p class="mt-2 text-xs leading-5 text-red-50">
                            Stock, location, condition, and product status
                        </p>
                    </div>

                    <div class="rounded-2xl border border-white/15 bg-white/10 p-5 backdrop-blur">
                        <h3 class="text-sm font-bold">
                            Borrowing Management
                        </h3>
                        <p class="mt-2 text-xs leading-5 text-red-50">
                            Borrowing records, returns, and due date tracking
                        </p>
                    </div>

                    <div class="rounded-2xl border border-white/15 bg-white/10 p-5 backdrop-blur">
                        <h3 class="text-sm font-bold">
                            Reports
                        </h3>
                        <p class="mt-2 text-xs leading-5 text-red-50">
                            Dashboard, export, and audit log
                        </p>
                    </div>
                </div>
            </section>

            <section class="flex min-h-screen items-center justify-center px-6 py-10 sm:px-10 lg:px-12">
                <div class="w-full max-w-md">
                    <div class="mb-8 lg:hidden">
                        <div class="flex items-center gap-3">
                            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-red-50 shadow-sm">
                                <img
                                    src="{{ asset('images/telkomsel-logo.png') }}"
                                    alt="Telkomsel Logo"
                                    class="h-9 w-9 object-contain"
                                >
                            </div>

                            <div>
                                <h1 class="text-xl font-bold text-slate-900">
                                    Telkomsel Inventory
                                </h1>
                                <p class="text-sm text-slate-500">
                                    Internal Asset Management System
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-3xl bg-white p-8 shadow-xl ring-1 ring-slate-200 sm:p-10">
                        <div class="mb-8">
                            <div class="mb-5 flex h-14 w-14 items-center justify-center rounded-2xl bg-red-50">
                                <img
                                    src="{{ asset('images/telkomsel-logo.png') }}"
                                    alt="Telkomsel Logo"
                                    class="h-10 w-10 object-contain"
                                >
                            </div>

                            <h2 class="text-3xl font-bold tracking-tight text-slate-900">
                                Create New Account
                            </h2>

                            <p class="mt-2 text-sm leading-6 text-slate-500">
                                Fill in the account details and choose a user role to start using the system.
                            </p>
                        </div>

                        <form method="POST" action="{{ route('register') }}" class="space-y-5">
                            @csrf

                            <div>
                                <label for="name" class="mb-2 block text-sm font-medium text-slate-700">
                                    Name
                                </label>

                                <input
                                    id="name"
                                    type="text"
                                    name="name"
                                    value="{{ old('name') }}"
                                    required
                                    autofocus
                                    autocomplete="name"
                                    placeholder="Enter your name"
                                    class="block w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-900 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-red-500 focus:ring-2 focus:ring-red-100"
                                >

                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <div>
                                <label for="email" class="mb-2 block text-sm font-medium text-slate-700">
                                    Email
                                </label>

                                <input
                                    id="email"
                                    type="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    required
                                    autocomplete="username"
                                    placeholder="name@example.com"
                                    class="block w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-900 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-red-500 focus:ring-2 focus:ring-red-100"
                                >

                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <div>
                                <label for="role_id" class="mb-2 block text-sm font-medium text-slate-700">
                                    Role
                                </label>

                                <select
                                    id="role_id"
                                    name="role_id"
                                    required
                                    class="block w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-900 shadow-sm outline-none transition focus:border-red-500 focus:ring-2 focus:ring-red-100"
                                >
                                    <option value="">
                                        Select role
                                    </option>

                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                            {{ ucfirst($role->name) }}
                                        </option>
                                    @endforeach
                                </select>

                                <x-input-error :messages="$errors->get('role_id')" class="mt-2" />
                            </div>

                            <div>
                                <label for="password" class="mb-2 block text-sm font-medium text-slate-700">
                                    Password
                                </label>

                                <input
                                    id="password"
                                    type="password"
                                    name="password"
                                    required
                                    autocomplete="new-password"
                                    placeholder="Enter your password"
                                    class="block w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-900 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-red-500 focus:ring-2 focus:ring-red-100"
                                >

                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <div>
                                <label for="password_confirmation" class="mb-2 block text-sm font-medium text-slate-700">
                                    Confirm Password
                                </label>

                                <input
                                    id="password_confirmation"
                                    type="password"
                                    name="password_confirmation"
                                    required
                                    autocomplete="new-password"
                                    placeholder="Confirm your password"
                                    class="block w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-900 shadow-sm outline-none transition placeholder:text-slate-400 focus:border-red-500 focus:ring-2 focus:ring-red-100"
                                >

                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </div>

                            <button
                                type="submit"
                                class="flex w-full items-center justify-center rounded-xl bg-red-600 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-red-200 transition hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
                            >
                                Register
                            </button>

                            <p class="text-center text-sm text-slate-600">
                                Already have an account?

                                <a href="{{ route('login') }}" class="font-semibold text-red-600 hover:text-red-700 hover:underline">
                                    Login here
                                </a>
                            </p>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </main>
</body>
</html>
