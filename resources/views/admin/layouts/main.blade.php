<!DOCTYPE html>
<html lang="id" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>R-NET Admin - @yield('title', 'Dasbor')</title>

    <!-- DaisyUI 4 + Tailwind CDN -->
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.10.2/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/inter@5.0.8/index.min.css">
    
    <!-- Leaflet JS for Maps -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>

<body class="bg-base-200">

<div class="drawer lg:drawer-open">
    <input id="admin-drawer" type="checkbox" class="drawer-toggle" />

    <!-- Main Content -->
    <div class="drawer-content flex flex-col h-screen overflow-hidden">

        <!-- Navbar -->
        <div class="navbar bg-base-100 shadow-sm border-b border-base-200 sticky top-0 z-30 px-4 sm:px-8">
            <div class="flex-none lg:hidden">
                <label for="admin-drawer" aria-label="open sidebar" class="btn btn-square btn-ghost">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        class="inline-block w-6 h-6 stroke-current">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </label>
            </div>
            <div class="flex-1">
                <h2 id="navbar-title" class="text-xl md:text-2xl font-bold text-base-content">Dasbor</h2>
            </div>

            <div class="flex-none gap-2">
                <!-- Notifications -->
                <div class="dropdown dropdown-end">
                    <div tabindex="0" role="button" class="btn btn-ghost btn-circle">
                        <div class="indicator">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            <span class="badge badge-sm badge-error indicator-item text-white">3</span>
                        </div>
                    </div>
                    <div tabindex="0"
                        class="mt-3 z-[1] card card-compact dropdown-content w-72 md:w-80 bg-base-100 shadow-xl border border-base-200">
                        <div class="card-body">
                            <span class="font-bold text-lg">Notifikasi</span>
                            <ul class="menu p-0">
                                <li><a>Pendaftaran baru dari Budi</a></li>
                                <li><a>Sistem berjalan normal</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Profile -->
                <div class="dropdown dropdown-end">
                    <div tabindex="0" role="button" class="btn btn-ghost flex items-center gap-2">
                        <div class="text-right hidden sm:block">
                            <p class="font-bold text-sm leading-none">Admin R-NET</p>
                        </div>
                        <div class="avatar placeholder">
                            <div class="bg-primary text-primary-content rounded-full w-10">
                                <span class="font-bold">AR</span>
                            </div>
                        </div>
                    </div>
                    <ul tabindex="0"
                        class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow-xl bg-base-100 rounded-box w-52 border border-base-200">
                        <li><a href="#profil" data-tab="profil" class="admin-nav-link">Edit Profil</a></li>
                        <li><a href="#pengaturan" data-tab="pengaturan" class="admin-nav-link">Pengaturan</a></li>
                        <li><a class="text-error mt-2">Keluar</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Page Content -->
        <main class="flex-1 overflow-y-auto p-4 sm:p-8 bg-base-200">
            @yield('content')
        </main>
    </div>

    <!-- Sidebar -->
    <div class="drawer-side z-40">
        <label for="admin-drawer" aria-label="close sidebar" class="drawer-overlay"></label>

        <ul class="menu p-4 w-72 min-h-full bg-[#1e3a8a] text-white">
            <!-- Brand -->
            <li class="mb-4 pointer-events-none">
                <h1 class="text-xl md:text-2xl font-bold flex items-center gap-3 text-white px-2 py-4 border-b border-blue-800">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 20h.01" />
                        <path d="M2 8.82a15 15 0 0 1 20 0" />
                        <path d="M5 12.859a10 10 0 0 1 14 0" />
                        <path d="M8.5 16.429a5 5 0 0 1 7 0" />
                    </svg>
                    R-NET Admin
                </h1>
            </li>

            <!-- Navigation -->
            <li class="mb-1">
                <a href="#dashboard" data-tab="dashboard" class="admin-nav-link active bg-white/20">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                        <polyline points="9 22 9 12 15 12 15 22" />
                    </svg>
                    Dasbor
                </a>
            </li>
            <li class="mb-1">
                <a href="#pendaftaran" data-tab="pendaftaran" class="admin-nav-link hover:bg-blue-800">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                        <line x1="19" x2="19" y1="8" y2="14" />
                        <line x1="22" x2="16" y1="11" y2="11" />
                    </svg>
                    Pendaftaran
                </a>
            </li>
            <li class="mb-1">
                <a href="#paket" data-tab="paket" class="admin-nav-link hover:bg-blue-800">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 12V8H6a2 2 0 0 1-2-2c0-1.1.9-2 2-2h12v4" />
                        <path d="M4 6v12a2 2 0 0 0 2 2h14v-4" />
                        <path d="M18 12a2 2 0 0 0 0 4h4v-4Z" />
                    </svg>
                    Paket Internet
                </a>
            </li>
            <li class="mb-1">
                <a href="#pengumuman" data-tab="pengumuman" class="admin-nav-link hover:bg-blue-800">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5" />
                        <path d="M15.54 8.46a5 5 0 0 1 0 7.07" />
                        <path d="M19.07 4.93a10 10 0 0 1 0 14.14" />
                    </svg>
                    Pengumuman
                </a>
            </li>
            <li class="mb-1">
                <a href="#promosi" data-tab="promosi" class="admin-nav-link hover:bg-blue-800">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M15 14c.2-1 .7-1.7 1.5-2.5 1-.9 1.5-2.2 1.5-3.5A6 6 0 0 0 6 8c0 1 .2 2.2 1.5 3.5.7.7 1.3 1.5 1.5 2.5" />
                        <path d="M9 18h6" />
                        <path d="M10 22h4" />
                    </svg>
                    Promosi
                </a>
            </li>

            <li class="mt-4 mb-2 pointer-events-none">
                <span class="text-xs uppercase tracking-wider text-blue-300/60 px-2">Akun</span>
            </li>
            <li class="mb-1">
                <a href="#profil" data-tab="profil" class="admin-nav-link hover:bg-blue-800">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                        <circle cx="12" cy="7" r="4" />
                    </svg>
                    Profil
                </a>
            </li>
            <li class="mb-1">
                <a href="#pengaturan" data-tab="pengaturan" class="admin-nav-link hover:bg-blue-800">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z" />
                        <circle cx="12" cy="12" r="3" />
                    </svg>
                    Pengaturan
                </a>
            </li>

            <li class="mt-4 mb-2 pointer-events-none">
                <span class="text-xs uppercase tracking-wider text-blue-300/60 px-2">Sistem</span>
            </li>
            <li class="mb-1">
                <a href="#monitoring" data-tab="monitoring" class="admin-nav-link hover:bg-blue-800">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 12h-4l-3 9L9 3l-3 9H2" />
                    </svg>
                    Monitoring
                </a>
            </li>
        </ul>
    </div>
</div>

@yield('modals')

@yield('scripts')

</body>

</html>
