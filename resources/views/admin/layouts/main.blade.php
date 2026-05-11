<!DOCTYPE html>
<html lang="id" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>R-NET Admin - @yield('title', 'Dasbor')</title>

    <!-- Preconnect hints untuk CDN yang digunakan -->
    <link rel="preconnect" href="https://unpkg.com" crossorigin>
    <link rel="preconnect" href="https://a.tile.openstreetmap.org" crossorigin>

    <!-- Google Fonts: Inter (diload dari Google, bukan Fontsource CDN) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind + DaisyUI: dikompilasi lokal via Vite (menggantikan CDN) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Leaflet: TIDAK diload di sini, lazy-loaded via JS saat modal Detail dibuka -->

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
                <!-- ═══ Notifikasi Live ═══ -->
                <div class="dropdown dropdown-end" id="notif-dropdown">
                    <div tabindex="0" role="button" class="btn btn-ghost btn-circle" id="notif-bell-btn" onclick="notifOpen()">
                        <div class="indicator">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            <span id="notif-badge" class="badge badge-xs badge-error indicator-item text-white hidden">0</span>
                        </div>
                    </div>
                    <div tabindex="0" class="mt-3 z-[1] card card-compact dropdown-content w-80 bg-base-100 shadow-xl border border-base-200" id="notif-panel">
                        <!-- Header -->
                        <div class="flex items-center justify-between px-4 pt-4 pb-2 border-b border-base-200">
                            <span class="font-bold text-base">Notifikasi</span>
                            <div class="flex gap-1">
                                <button onclick="notifReadAll()" class="btn btn-ghost btn-xs text-primary" title="Tandai semua dibaca">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                    Baca semua
                                </button>
                                <button onclick="notifClear()" class="btn btn-ghost btn-xs text-base-content/40" title="Hapus yang sudah dibaca">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/></svg>
                                </button>
                            </div>
                        </div>
                        <!-- List -->
                        <div id="notif-list" class="max-h-72 overflow-y-auto divide-y divide-base-200">
                            <div class="flex flex-col items-center justify-center py-8 text-base-content/40" id="notif-empty">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                                <p class="text-xs mt-2">Tidak ada notifikasi</p>
                            </div>
                        </div>
                        <!-- Footer -->
                        <div class="px-4 py-2 border-t border-base-200 text-center">
                            <span id="notif-footer-text" class="text-xs text-base-content/40">Memuat...</span>
                        </div>
                    </div>
                </div>

                <!-- Profile -->
                <div class="dropdown dropdown-end">
                    <div tabindex="0" role="button" class="btn btn-ghost flex items-center gap-2">
                        <div class="text-right hidden sm:block">
                            <p class="font-bold text-sm leading-none" id="navbar-admin-name">Admin R-NET</p>
                        </div>
                        <div class="avatar placeholder">
                            <div class="bg-primary text-primary-content rounded-full w-10" id="navbar-avatar">
                                <span class="font-bold" id="navbar-initials">AR</span>
                            </div>
                        </div>
                    </div>
                    <ul tabindex="0"
                        class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow-xl bg-base-100 rounded-box w-52 border border-base-200">
                        <li><a href="#profil" data-tab="profil" class="admin-nav-link">Edit Profil</a></li>
                        <li><a href="#pengaturan" data-tab="pengaturan" class="admin-nav-link">Pengaturan</a></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST" class="p-0 m-0 w-full mt-2" data-no-ajax>
                                @csrf
                                <button type="submit" class="text-error w-full text-left py-2 px-4 hover:bg-base-200">Keluar</button>
                            </form>
                        </li>
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
            <li class="mb-1">
                <a href="#server" data-tab="server" class="admin-nav-link hover:bg-blue-800">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="2" y="2" width="20" height="8" rx="2" ry="2"/>
                        <rect x="2" y="14" width="20" height="8" rx="2" ry="2"/>
                        <line x1="6" y1="6" x2="6.01" y2="6"/>
                        <line x1="6" y1="18" x2="6.01" y2="18"/>
                    </svg>
                    Kontrol Server
                </a>
            </li>
        </ul>
    </div>
</div>

@yield('modals')

@yield('scripts')

<script>
// ═══════════════════════════════════════════════════════════════
// Notification Engine — R-NET Admin
// ═══════════════════════════════════════════════════════════════
const NOTIF_API      = '{{ route("admin.api.notifications") }}';
const NOTIF_READ_ALL = '{{ route("admin.api.notifications.read_all") }}';
const NOTIF_CLEAR    = '{{ route("admin.api.notifications.clear") }}';
const CSRF_TOKEN     = document.querySelector('meta[name="csrf-token"]')?.content || '';

let _notifData     = [];
let _notifLoaded   = false;
let _pollInterval  = null;

// Icon SVG map
const NOTIF_ICONS = {
    'user-plus': `<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" y1="8" x2="19" y2="14"/><line x1="22" y1="11" x2="16" y2="11"/></svg>`,
    'alert':     `<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>`,
    'bell':      `<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>`,
};

const NOTIF_TYPE_COLORS = {
    info:    'text-info    bg-info/10',
    success: 'text-success bg-success/10',
    warning: 'text-warning bg-warning/10',
    danger:  'text-error   bg-error/10',
};

// ── Fetch notifikasi dari server ──
async function notifFetch(silent = false) {
    try {
        const res  = await fetch(NOTIF_API, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
        const data = await res.json();
        _notifData   = data.notifications || [];
        _notifLoaded = true;
        notifRender(_notifData, data.unread);
    } catch (e) {
        if (!silent) {
            document.getElementById('notif-footer-text').textContent = 'Gagal memuat notifikasi.';
        }
    }
}

// ── Render daftar notifikasi ──
function notifRender(items, unread) {
    const badge    = document.getElementById('notif-badge');
    const list     = document.getElementById('notif-list');
    const empty    = document.getElementById('notif-empty');
    const footer   = document.getElementById('notif-footer-text');

    // Badge
    if (unread > 0) {
        badge.textContent = unread > 99 ? '99+' : unread;
        badge.classList.remove('hidden');
        badge.classList.add('animate-bounce');
        setTimeout(() => badge.classList.remove('animate-bounce'), 1000);
    } else {
        badge.classList.add('hidden');
    }

    // Footer count
    footer.textContent = unread > 0
        ? `${unread} notifikasi belum dibaca`
        : items.length > 0 ? 'Semua sudah dibaca' : '';

    if (items.length === 0) {
        list.innerHTML = '';
        list.appendChild(empty);
        return;
    }

    // Render items
    list.innerHTML = items.map(n => {
        const icon    = NOTIF_ICONS[n.icon] || NOTIF_ICONS.bell;
        const color   = NOTIF_TYPE_COLORS[n.type] || NOTIF_TYPE_COLORS.info;
        const readCls = n.is_read ? 'opacity-60' : 'bg-primary/5 font-medium';
        const dot     = n.is_read ? '' : '<span class="w-2 h-2 rounded-full bg-primary shrink-0 mt-1"></span>';
        const tabAttr = n.link_tab ? `data-tab="${n.link_tab}"` : '';

        return `<div class="flex gap-3 px-4 py-3 cursor-pointer hover:bg-base-200 transition-colors ${readCls}"
                     onclick="notifMarkRead(${n.id}, '${n.link_tab || ''}')" ${tabAttr}>
            <div class="shrink-0 w-9 h-9 rounded-full flex items-center justify-center ${color}">${icon}</div>
            <div class="flex-1 min-w-0">
                <p class="text-sm leading-snug truncate">${n.title}</p>
                <p class="text-xs text-base-content/50 truncate mt-0.5">${n.body || ''}</p>
                <p class="text-xs text-base-content/30 mt-0.5">${n.time_ago}</p>
            </div>
            ${dot}
        </div>`;
    }).join('');
}

// ── Buka dropdown & fetch ──
function notifOpen() {
    if (!_notifLoaded) notifFetch();
    // Auto-refresh saat dibuka
    else notifFetch(true);
}

// ── Tandai satu sebagai dibaca & navigasi ke tab ──
async function notifMarkRead(id, tab) {
    // Update lokal dulu (optimistik)
    _notifData = _notifData.map(n => n.id === id ? { ...n, is_read: true } : n);
    const unread = _notifData.filter(n => !n.is_read).length;
    notifRender(_notifData, unread);

    // Tutup dropdown
    document.activeElement?.blur();

    // Navigasi ke tab
    if (tab && typeof switchTab === 'function') switchTab(tab);

    // Kirim ke server
    try {
        await fetch(`/admin/api/notifications/${id}/read`, {
            method: 'PATCH',
            headers: { 'X-CSRF-TOKEN': CSRF_TOKEN, 'X-Requested-With': 'XMLHttpRequest' }
        });
    } catch (e) { /* silent */ }
}

// ── Tandai semua dibaca ──
async function notifReadAll() {
    _notifData = _notifData.map(n => ({ ...n, is_read: true }));
    notifRender(_notifData, 0);
    try {
        await fetch(NOTIF_READ_ALL, {
            method: 'PATCH',
            headers: { 'X-CSRF-TOKEN': CSRF_TOKEN, 'X-Requested-With': 'XMLHttpRequest' }
        });
    } catch (e) { /* silent */ }
}

// ── Hapus notifikasi yang sudah dibaca ──
async function notifClear() {
    _notifData = _notifData.filter(n => !n.is_read);
    const unread = _notifData.filter(n => !n.is_read).length;
    notifRender(_notifData, unread);
    try {
        await fetch(NOTIF_CLEAR, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': CSRF_TOKEN, 'X-Requested-With': 'XMLHttpRequest' }
        });
    } catch (e) { /* silent */ }
}

// ── Auto-polling setiap 60 detik ──
document.addEventListener('DOMContentLoaded', () => {
    // Fetch awal (count saja, silent)
    notifFetch(true);
    // Poll
    _pollInterval = setInterval(() => notifFetch(true), 60_000);
});
</script>

</body>
</html>
