<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gilang Inventory</title>

    @vite(['resources/css/app.css', 'resources/css/responsive.css'])
    @stack('styles')
</head>
<body class="bg-gray-50">
    <nav class="bg-white shadow p-3 sm:p-4 sticky top-0 z-40">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex items-center">
                <h1 class="text-lg sm:text-xl font-bold text-gray-800">📦 Gilang Inventory</h1>
            </div>
            <div class="flex items-center space-x-2 sm:space-x-4">
                <a href="/dashboard" class="text-blue-600 hover:text-blue-800 text-sm sm:text-base">Dashboard</a>
                <a href="#" class="text-gray-600 hover:text-gray-800 text-sm sm:text-base">Profil</a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm sm:text-base">Keluar</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mx-auto flex flex-col md:flex-row mt-2 sm:mt-4">
        <!-- Sidebar Navigation -->
        <div class="w-full md:w-64 bg-white shadow-lg md:min-h-screen">
            <div class="p-3 sm:p-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <span class="text-base sm:text-lg font-semibold text-gray-800">Menu Navigasi</span>
                    <button id="mobile-menu-button" class="md:hidden rounded-lg focus:outline-none focus:shadow-outline bg-gray-100 hover:bg-gray-200 p-2">
                        <svg fill="currentColor" viewBox="0 0 20 20" class="w-5 h-5">
                            <path id="mobile-menu-icon" fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
            </div>
            <nav class="mt-2 p-2 overflow-y-auto max-h-[60vh] md:max-h-full" id="sidebar-nav">
                <a href="/dashboard" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gradient-to-r hover:from-blue-50 hover:to-blue-100 hover:text-blue-700 {{ request()->is('dashboard') ? 'bg-blue-100 text-blue-700' : 'text-gray-500' }} flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Dashboard
                </a>
                
                <a href="/scan" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gradient-to-r hover:from-blue-50 hover:to-blue-100 hover:text-blue-700 {{ request()->is('scan') ? 'bg-blue-100 text-blue-700' : 'text-gray-500' }} flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                    </svg>
                    Scan Barcode
                </a>

                <div class="py-2 px-4 text-xs font-semibold text-gray-400 uppercase tracking-wide mt-4">
                    Manajemen
                </div>

                <a href="/section/product" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gradient-to-r hover:from-blue-50 hover:to-blue-100 hover:text-blue-700 {{ request()->is('section/product') ? 'bg-blue-100 text-blue-700' : 'text-gray-500' }} flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m-8-4l8 4m8-4v10l-8 4m0-10L4 7m8 4v10"></path>
                    </svg>
                    Produk
                </a>

                <a href="/inventory/transactions" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gradient-to-r hover:from-blue-50 hover:to-blue-100 hover:text-blue-700 {{ request()->is('inventory/transactions*') ? 'bg-blue-100 text-blue-700' : 'text-gray-500' }} flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                    </svg>
                    Transaksi
                </a>

                <a href="/inventory/stock-levels" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gradient-to-r hover:from-blue-50 hover:to-blue-100 hover:text-blue-700 {{ request()->is('inventory/stock-levels*') ? 'bg-blue-100 text-blue-700' : 'text-gray-500' }} flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Laporan Stok
                </a>

                <a href="/inventory/activity-log" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gradient-to-r hover:from-blue-50 hover:to-blue-100 hover:text-blue-700 {{ request()->is('inventory/activity-log*') ? 'bg-blue-100 text-blue-700' : 'text-gray-500' }} flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Log Aktivitas
                </a>

                <!-- Admin Section -->
                <div class="py-2 px-4 text-xs font-semibold text-gray-400 uppercase tracking-wide mt-4">
                    Admin
                </div>

                <a href="/admin/users" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gradient-to-r hover:from-blue-50 hover:to-blue-100 hover:text-blue-700 {{ request()->is('admin/users*') ? 'bg-blue-100 text-blue-700' : 'text-gray-500' }} flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                    Pengguna
                </a>

                <a href="/admin/settings" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gradient-to-r hover:from-blue-50 hover:to-blue-100 hover:text-blue-700 {{ request()->is('admin/settings*') ? 'bg-blue-100 text-blue-700' : 'text-gray-500' }} flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Pengaturan
                </a>

                <a href="/admin/logs" class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gradient-to-r hover:from-blue-50 hover:to-blue-100 hover:text-blue-700 {{ request()->is('admin/logs*') ? 'bg-blue-100 text-blue-700' : 'text-gray-500' }} flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Log Sistem
                </a>
            </nav>
        </div>

        <!-- Main Content -->
        <main class="w-full px-3 sm:px-4 py-3 sm:py-6">
            <!-- Dynamic Back Button (Mobile) -->
            <div id="back-button" class="mb-3 hidden">
                <a href="javascript:history.back()" class="inline-flex items-center px-3 py-1 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-lg text-sm transition-all duration-200">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    <span>Kembali</span>
                </a>
            </div>
            
            <!-- Toast notification -->
            <div id="toast" class="fixed bottom-4 right-4 flex items-center p-4 mb-4 w-full max-w-xs text-gray-500 bg-white rounded-lg shadow-lg border border-gray-200 transition-opacity duration-300 ease-in-out hidden z-50" role="alert">
                <div class="inline-flex flex-shrink-0 justify-center items-center w-8 h-8 text-green-500 bg-green-100 rounded-lg">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div id="toastMessage" class="ml-3 text-sm font-normal"></div>
                <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-white text-gray-400 hover:text-gray-900 rounded-lg focus:ring-2 focus:ring-gray-300 p-1.5 hover:bg-gray-100 inline-flex h-8 w-8" data-dismiss-target="#toast" aria-label="Close">
                    <span class="sr-only">Close</span>
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>

            @yield('content')
        </main>
    </div>

    @vite('resources/js/app.js')
    @stack('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Mobile menu toggle
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const sidebarNav = document.getElementById('sidebar-nav');
            const backButton = document.getElementById('back-button');
            
            if (mobileMenuButton && sidebarNav) {
                mobileMenuButton.addEventListener('click', function() {
                    sidebarNav.classList.toggle('hidden');
                    sidebarNav.classList.toggle('block');
                });

                // Only hide the menu on mobile initially
                if (window.innerWidth < 768) {
                    sidebarNav.classList.add('hidden');
                }

                // Resize handler to handle responsive behavior
                window.addEventListener('resize', function() {
                    if (window.innerWidth >= 768) {
                        sidebarNav.classList.remove('hidden');
                    } else {
                        sidebarNav.classList.add('hidden');
                    }
                });
                
                // Make sure all links in sidebar are visible
                const sidebarLinks = sidebarNav.querySelectorAll('a');
                sidebarLinks.forEach(link => {
                    if (link.classList.contains('hidden')) {
                        link.classList.remove('hidden');
                        link.classList.add('block');
                    }
                });
            }
            
            // Show back button on inner pages (not on dashboard)
            const currentPath = window.location.pathname;
            if (backButton && currentPath !== '/' && currentPath !== '/dashboard') {
                backButton.classList.remove('hidden');
                backButton.classList.add('block', 'md:hidden');
            }
            
            // Close sidebar when clicking a link on mobile
            const sidebarLinks = document.querySelectorAll('#sidebar-nav a');
            sidebarLinks.forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth < 768) {
                        sidebarNav.classList.add('hidden');
                        sidebarNav.classList.remove('block');
                    }
                });
            });
        });
    </script>
</body>
</html>
