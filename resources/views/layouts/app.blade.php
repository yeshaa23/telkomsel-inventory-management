<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Telkomsel Inventory') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet">

        <script>
            try {
                if (localStorage.getItem('theme') === 'dark') {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            } catch (error) {
                document.documentElement.classList.remove('dark');
            }
        </script>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <body class="font-sans antialiased text-slate-900 dark:text-white">
        <div class="gsm-shell">
            <aside id="app-sidebar" class="gsm-sidebar">
                <div>
                    <div class="gsm-brand-card">
                        <div class="gsm-logo-mark">
                            <img
                                src="{{ asset('images/telkomsel-logo.png') }}"
                                alt="Telkomsel Logo"
                                onerror="this.style.display='none'; this.nextElementSibling.style.display='grid';"
                            >

                            <span class="gsm-logo-fallback" style="display: none;">T</span>
                        </div>

                        <div class="gsm-brand-text">
                            <h1>Telkomsel</h1>
                            <p>Inventory Center</p>
                        </div>
                    </div>

                    <nav class="gsm-nav">
                        <p class="gsm-nav-title">Menu Utama</p>

                        <a href="{{ route('dashboard') }}"
                            class="gsm-nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <span class="gsm-nav-icon">⌂</span>
                            <span>Dashboard</span>
                        </a>

                        @if(auth()->user()->hasRole(['Admin', 'Staff']))
                            <a href="{{ route('categories.index') }}"
                                class="gsm-nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}">
                                <span class="gsm-nav-icon">▦</span>
                                <span>Kategori</span>
                            </a>

                            <a href="{{ route('products.index') }}"
                                class="gsm-nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">
                                <span class="gsm-nav-icon">◈</span>
                                <span>Barang</span>
                            </a>

                            <a href="{{ route('borrowings.index') }}"
                                class="gsm-nav-link {{ request()->routeIs('borrowings.*') ? 'active' : '' }}">
                                <span class="gsm-nav-icon">↔</span>
                                <span>Peminjaman</span>
                            </a>
                        @endif

                        @if(auth()->user()->hasRole(['Admin', 'Manager']))
                            <a href="{{ route('reports.index') }}"
                                class="gsm-nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                                <span class="gsm-nav-icon">▤</span>
                                <span>Laporan</span>
                            </a>
                        @endif

                        @if(auth()->user()->hasRole('Admin'))
                            <a href="{{ route('activity-logs.index') }}"
                                class="gsm-nav-link {{ request()->routeIs('activity-logs.*') ? 'active' : '' }}">
                                <span class="gsm-nav-icon">◎</span>
                                <span>Riwayat Aktivitas</span>
                            </a>
                        @endif
                    </nav>
                </div>

                <div class="gsm-sidebar-footer">
                    <p class="font-semibold">Inventory Monitoring</p>
                    <span>Kelola aset kantor secara cepat, rapi, dan terkontrol.</span>
                </div>
            </aside>

            <div id="sidebar-overlay" class="gsm-sidebar-overlay"></div>

            <div class="gsm-main">
                <header class="gsm-topbar">
                    <button
                        type="button"
                        id="sidebar-toggle"
                        class="gsm-sidebar-toggle"
                        aria-label="Toggle sidebar"
                        aria-expanded="true"
                    >
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>

                    <div class="gsm-page-title">
                        @isset($header)
                            {{ $header }}
                        @else
                            <h2>Dashboard</h2>
                        @endisset
                    </div>

                    <div class="gsm-top-actions">
                        @if(auth()->user()->hasRole(['Admin', 'Staff']))
                            <form method="GET" action="{{ route('products.index') }}" class="gsm-search hidden md:flex">
                                <button type="submit" class="gsm-search-submit" aria-label="Search inventory">
                                    <svg viewBox="0 0 24 24" aria-hidden="true">
                                        <path
                                            d="M10.8 18.2a7.4 7.4 0 1 1 0-14.8 7.4 7.4 0 0 1 0 14.8Zm0-2a5.4 5.4 0 1 0 0-10.8 5.4 5.4 0 0 0 0 10.8Zm6.2.2 3.2 3.2-1.4 1.4-3.2-3.2 1.4-1.4Z"
                                            fill="currentColor"
                                        />
                                    </svg>
                                </button>

                                <input
                                    type="search"
                                    name="search"
                                    value="{{ request('search') }}"
                                    placeholder="Search inventory"
                                    autocomplete="off"
                                >
                            </form>
                        @endif

                        <button
                            type="button"
                            id="theme-toggle"
                            class="gsm-icon-button gsm-theme-button"
                            aria-label="Switch to dark mode"
                            title="Dark Mode"
                        >
                            <span id="theme-toggle-icon" aria-hidden="true">☾</span>
                        </button>

                        <a href="{{ route('profile.edit') }}" class="gsm-profile-pill">
                            <span>{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                            <strong>{{ auth()->user()->name }}</strong>
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <button type="submit" class="gsm-logout-button">
                                Logout
                            </button>
                        </form>
                    </div>
                </header>

                <main class="gsm-content">
                    {{ $slot }}
                </main>
            </div>
        </div>

        <div id="confirm-modal" class="hidden fixed inset-0 bg-slate-950/60 backdrop-blur-sm items-center justify-center z-50 px-4">
            <div class="gsm-modal-card">
                <div class="gsm-modal-icon">!</div>

                <h3>Konfirmasi Aksi</h3>

                <p id="confirm-message">
                    Apakah Anda yakin?
                </p>

                <div class="flex justify-end gap-2 mt-6">
                    <button type="button" onclick="closeConfirmModal()" class="gsm-button-secondary">
                        Batal
                    </button>

                    <button type="button" onclick="submitConfirmForm()" class="gsm-button-danger">
                        Ya, Lanjutkan
                    </button>
                </div>
            </div>
        </div>

        <script>
            let selectedFormId = null;

            function openConfirmModal(message, formId) {
                selectedFormId = formId;

                const confirmMessage = document.getElementById('confirm-message');
                const confirmModal = document.getElementById('confirm-modal');

                if (confirmMessage && confirmModal) {
                    confirmMessage.textContent = message;
                    confirmModal.classList.remove('hidden');
                    confirmModal.classList.add('flex');
                }
            }

            function closeConfirmModal() {
                selectedFormId = null;

                const confirmModal = document.getElementById('confirm-modal');

                if (confirmModal) {
                    confirmModal.classList.add('hidden');
                    confirmModal.classList.remove('flex');
                }
            }

            function submitConfirmForm() {
                if (!selectedFormId) {
                    return;
                }

                const form = document.getElementById(selectedFormId);

                if (form) {
                    form.submit();
                }
            }

            document.addEventListener('DOMContentLoaded', function () {
                const body = document.body;
                const themeToggle = document.getElementById('theme-toggle');
                const themeIcon = document.getElementById('theme-toggle-icon');
                const sidebarToggle = document.getElementById('sidebar-toggle');
                const sidebarOverlay = document.getElementById('sidebar-overlay');

                function isMobileView() {
                    return window.innerWidth < 768;
                }

                function isDarkMode() {
                    return document.documentElement.classList.contains('dark');
                }

                function updateThemeButton() {
                    const dark = isDarkMode();

                    if (themeIcon) {
                        themeIcon.textContent = dark ? '☀' : '☾';
                    }

                    if (themeToggle) {
                        themeToggle.setAttribute('title', dark ? 'Light Mode' : 'Dark Mode');
                        themeToggle.setAttribute('aria-label', dark ? 'Switch to light mode' : 'Switch to dark mode');
                    }
                }

                function updateSidebarButton() {
                    if (!sidebarToggle) {
                        return;
                    }

                    const expanded = isMobileView()
                        ? body.classList.contains('gsm-mobile-sidebar-open')
                        : !body.classList.contains('gsm-sidebar-collapsed');

                    sidebarToggle.setAttribute('aria-expanded', expanded ? 'true' : 'false');
                }

                updateThemeButton();

                if (themeToggle) {
                    themeToggle.addEventListener('click', function () {
                        document.documentElement.classList.toggle('dark');

                        localStorage.setItem('theme', isDarkMode() ? 'dark' : 'light');

                        updateThemeButton();
                    });
                }

                if (localStorage.getItem('sidebar') === 'collapsed' && !isMobileView()) {
                    body.classList.add('gsm-sidebar-collapsed');
                }

                updateSidebarButton();

                if (sidebarToggle) {
                    sidebarToggle.addEventListener('click', function () {
                        if (isMobileView()) {
                            body.classList.toggle('gsm-mobile-sidebar-open');
                        } else {
                            body.classList.toggle('gsm-sidebar-collapsed');

                            localStorage.setItem(
                                'sidebar',
                                body.classList.contains('gsm-sidebar-collapsed') ? 'collapsed' : 'expanded'
                            );
                        }

                        updateSidebarButton();
                    });
                }

                if (sidebarOverlay) {
                    sidebarOverlay.addEventListener('click', function () {
                        body.classList.remove('gsm-mobile-sidebar-open');
                        updateSidebarButton();
                    });
                }

                window.addEventListener('resize', function () {
                    if (!isMobileView()) {
                        body.classList.remove('gsm-mobile-sidebar-open');
                    }

                    updateSidebarButton();
                });
            });
        </script>
    </body>
</html>
