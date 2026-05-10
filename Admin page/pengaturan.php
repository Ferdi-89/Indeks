<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>R-NET Admin - Pengaturan</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/inter@5.0.8/index.min.css">
  <style>
    body { font-family: 'Inter', sans-serif; }
    ::-webkit-scrollbar { width: 6px; height: 6px; }
    ::-webkit-scrollbar-track { background: #f1f5f9; }
    ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
    ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    .sidebar-active { background-color: rgba(255,255,255,0.1); }
    .modal-overlay { background-color: rgba(0, 0, 0, 0.5); backdrop-filter: blur(4px); }
    .modal-content { transition: all 0.2s ease-out; opacity: 0; transform: scale(0.95); pointer-events: none; }
    .modal-content.show { opacity: 1; transform: scale(1); pointer-events: auto; }
    .tab-active { border-bottom: 3px solid #1e3a8a; color: #1e3a8a; font-weight: 600; }
    .tab-inactive { border-bottom: 3px solid transparent; color: #64748b; }
    .tab-inactive:hover { color: #334155; }
    .toggle-checkbox:checked { right: 0; border-color: #1e3a8a; }
    .toggle-checkbox:checked + .toggle-label { background-color: #1e3a8a; }
  </style>
</head>
<body class="bg-gray-50 text-slate-800 h-screen flex overflow-hidden">

  <!-- Sidebar -->
  <aside class="w-64 bg-[#1e3a8a] text-white flex flex-col flex-shrink-0 transition-all duration-300">
    <div class="p-6 border-b border-blue-800">
      <h1 class="text-xl font-bold tracking-wide flex items-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h.01"/><path d="M2 8.82a15 15 0 0 1 20 0"/><path d="M5 12.859a10 10 0 0 1 14 0"/><path d="M8.5 16.429a5 5 0 0 1 7 0"/></svg>
        R-NET Admin
      </h1>
    </div>
    <nav class="flex-1 p-4 space-y-2">
      <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg text-blue-200 hover:bg-blue-800 hover:text-white transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
        <span>Dasbor</span>
      </a>
      <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg text-blue-200 hover:bg-blue-800 hover:text-white transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" x2="19" y1="8" y2="14"/><line x1="22" x2="16" y1="11" y2="11"/></svg>
        <span>Pendaftaran</span>
      </a>
      <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg text-blue-200 hover:bg-blue-800 hover:text-white transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 12V8H6a2 2 0 0 1-2-2c0-1.1.9-2 2-2h12v4"/><path d="M4 6v12a2 2 0 0 0 2 2h14v-4"/><path d="M18 12a2 2 0 0 0 0 4h4v-4Z"/></svg>
        <span>Paket Internet</span>
      </a>
      <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg text-blue-200 hover:bg-blue-800 hover:text-white transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"/><path d="M15.54 8.46a5 5 0 0 1 0 7.07"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14"/></svg>
        <span>Pengumuman</span>
      </a>
      <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg text-blue-200 hover:bg-blue-800 hover:text-white transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 14c.2-1 .7-1.7 1.5-2.5 1-.9 1.5-2.2 1.5-3.5A6 6 0 0 0 6 8c0 1 .2 2.2 1.5 3.5.7.7 1.3 1.5 1.5 2.5"/><path d="M9 18h6"/><path d="M10 22h4"/></svg>
        <span>Promosi</span>
      </a>
      <a href="#" class="sidebar-active flex items-center gap-3 px-4 py-3 rounded-lg transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/><circle cx="12" cy="12" r="3"/></svg>
        <span class="font-medium">Pengaturan</span>
      </a>
    </nav>
    <div class="p-4 border-t border-blue-800">
      <a href="#" class="flex items-center gap-3 px-4 py-3 text-red-300 hover:bg-blue-800 hover:text-red-200 rounded-lg transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/></svg>
        <span class="font-medium">Keluar</span>
      </a>
    </div>
  </aside>

  <!-- Main Content -->
  <main class="flex-1 flex flex-col overflow-hidden">
    <!-- Header -->
    <header class="bg-white border-b border-gray-200 px-8 py-4 flex justify-between items-center sticky top-0 z-20">
      <h2 class="text-2xl font-bold text-slate-800">Pengaturan</h2>
      <div class="flex items-center gap-6">
        <div class="relative">
          <button class="relative p-2 text-slate-600 hover:text-blue-600 transition rounded-full hover:bg-gray-100">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>
            <span class="absolute top-1 right-1 bg-red-500 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center border-2 border-white">3</span>
          </button>
        </div>
        <div class="flex items-center gap-3 cursor-pointer">
          <div class="text-right hidden sm:block">
            <p class="font-semibold text-sm text-slate-800">Admin R-NET</p>
            <p class="text-xs text-slate-500">Administrator</p>
          </div>
          <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold shadow-sm">AR</div>
        </div>
      </div>
    </header>

    <!-- Scrollable Content -->
    <div class="flex-1 overflow-y-auto p-8 bg-gray-50">
      <div class="mb-6">
        <h3 class="text-2xl font-bold text-slate-800">Pengaturan</h3>
        <p class="text-sm text-slate-500 mt-1">Kelola konfigurasi sistem dan akun</p>
      </div>

      <!-- Tabs -->
      <div class="flex gap-6 border-b border-gray-200 mb-8">
        <button onclick="switchTab('umum')" id="tab-umum" class="pb-3 px-1 text-sm font-medium tab-active transition-colors">Pengaturan Umum</button>
        <button onclick="switchTab('akun')" id="tab-akun" class="pb-3 px-1 text-sm font-medium tab-inactive transition-colors">Pengaturan Akun</button>
        <button onclick="switchTab('sistem')" id="tab-sistem" class="pb-3 px-1 text-sm font-medium tab-inactive transition-colors">Pengaturan Sistem</button>
      </div>

      <!-- Tab: Umum -->
      <div id="content-umum" class="tab-content">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 max-w-4xl">
          <h4 class="text-lg font-bold text-slate-800 mb-6">Informasi Perusahaan</h4>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
              <label class="block text-sm font-medium text-slate-700 mb-2">Nama Perusahaan</label>
              <input type="text" id="companyName" class="w-full px-4 py-3 rounded-lg border border-gray-200 bg-gray-50 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100 outline-none transition" value="R-NET WiFi">
            </div>
            <div class="md:col-span-2">
              <label class="block text-sm font-medium text-slate-700 mb-2">Alamat</label>
              <textarea id="companyAddress" class="w-full px-4 py-3 rounded-lg border border-gray-200 bg-gray-50 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100 outline-none transition" rows="2">Jl. Merdeka No. 123, Kota Sungai Penuh, Jambi</textarea>
            </div>
            <div>
              <label class="block text-sm font-medium text-slate-700 mb-2">Email</label>
              <input type="email" id="companyEmail" class="w-full px-4 py-3 rounded-lg border border-gray-200 bg-gray-50 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100 outline-none transition" value="admin@rnet.id">
            </div>
            <div>
              <label class="block text-sm font-medium text-slate-700 mb-2">No. Telepon</label>
              <input type="tel" id="companyPhone" class="w-full px-4 py-3 rounded-lg border border-gray-200 bg-gray-50 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100 outline-none transition" value="0748-123456">
            </div>
          </div>
          <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-gray-100">
            <button onclick="resetForm('umum')" class="px-5 py-2.5 rounded-lg border border-gray-200 text-slate-600 hover:bg-gray-50 font-medium transition">Reset</button>
            <button onclick="saveSettings('umum')" class="px-5 py-2.5 rounded-lg bg-blue-700 hover:bg-blue-800 text-white font-medium shadow-md transition flex items-center gap-2">
              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
              Simpan Perubahan
            </button>
          </div>
        </div>
      </div>

      <!-- Tab: Akun -->
      <div id="content-akun" class="tab-content hidden">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 max-w-4xl">
          <h4 class="text-lg font-bold text-slate-800 mb-6">Keamanan Akun</h4>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label class="block text-sm font-medium text-slate-700 mb-2">Username</label>
              <input type="text" id="username" class="w-full px-4 py-3 rounded-lg border border-gray-200 bg-gray-50 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100 outline-none transition" value="admin-rnet" disabled>
              <p class="text-xs text-slate-400 mt-1">Username tidak dapat diubah</p>
            </div>
            <div>
              <label class="block text-sm font-medium text-slate-700 mb-2">Email Login</label>
              <input type="email" id="loginEmail" class="w-full px-4 py-3 rounded-lg border border-gray-200 bg-gray-50 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100 outline-none transition" value="admin@rnet.id">
            </div>
            <div>
              <label class="block text-sm font-medium text-slate-700 mb-2">Kata Sandi Lama</label>
              <input type="password" id="oldPassword" class="w-full px-4 py-3 rounded-lg border border-gray-200 bg-gray-50 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100 outline-none transition" placeholder="Masukkan kata sandi lama">
            </div>
            <div>
              <label class="block text-sm font-medium text-slate-700 mb-2">Kata Sandi Baru</label>
              <input type="password" id="newPassword" class="w-full px-4 py-3 rounded-lg border border-gray-200 bg-gray-50 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100 outline-none transition" placeholder="Masukkan kata sandi baru">
            </div>
            <div>
              <label class="block text-sm font-medium text-slate-700 mb-2">Konfirmasi Kata Sandi Baru</label>
              <input type="password" id="confirmPassword" class="w-full px-4 py-3 rounded-lg border border-gray-200 bg-gray-50 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100 outline-none transition" placeholder="Ulangi kata sandi baru">
            </div>
          </div>
          <div class="flex justify-end gap-3 mt-8 pt-6 border-t border-gray-100">
            <button onclick="resetForm('akun')" class="px-5 py-2.5 rounded-lg border border-gray-200 text-slate-600 hover:bg-gray-50 font-medium transition">Reset</button>
            <button onclick="saveSettings('akun')" class="px-5 py-2.5 rounded-lg bg-blue-700 hover:bg-blue-800 text-white font-medium shadow-md transition flex items-center gap-2">
              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
              Simpan Perubahan
            </button>
          </div>
        </div>
      </div>

      <!-- Tab: Sistem -->
      <div id="content-sistem" class="tab-content hidden">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 max-w-4xl space-y-8">
          <!-- Maintenance Mode -->
          <div class="flex items-start justify-between">
            <div>
              <h4 class="text-base font-bold text-slate-800">Mode Maintenance</h4>
              <p class="text-sm text-slate-500 mt-1">Aktifkan untuk menampilkan halaman maintenance kepada pengguna.</p>
            </div>
            <label class="relative inline-flex items-center cursor-pointer">
              <input type="checkbox" id="maintenanceToggle" class="sr-only peer">
              <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-100 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
            </label>
          </div>
          <div class="border-t border-gray-100"></div>

          <!-- Notifications -->
          <div class="flex items-start justify-between">
            <div>
              <h4 class="text-base font-bold text-slate-800">Notifikasi Email</h4>
              <p class="text-sm text-slate-500 mt-1">Kirim notifikasi otomatis ke pelanggan melalui email.</p>
            </div>
            <label class="relative inline-flex items-center cursor-pointer">
              <input type="checkbox" id="emailToggle" class="sr-only peer" checked>
              <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-100 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
            </label>
          </div>
          <div class="border-t border-gray-100"></div>

          <!-- WhatsApp Notifications -->
          <div class="flex items-start justify-between">
            <div>
              <h4 class="text-base font-bold text-slate-800">Notifikasi WhatsApp</h4>
              <p class="text-sm text-slate-500 mt-1">Kirim notifikasi tagihan melalui WhatsApp Gateway.</p>
            </div>
            <label class="relative inline-flex items-center cursor-pointer">
              <input type="checkbox" id="waToggle" class="sr-only peer">
              <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-100 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
            </label>
          </div>
          <div class="border-t border-gray-100"></div>

          <!-- Auto Renewal -->
          <div class="flex items-start justify-between">
            <div>
              <h4 class="text-base font-bold text-slate-800">Perpanjangan Otomatis</h4>
              <p class="text-sm text-slate-500 mt-1">Perpanjang layanan pelanggan secara otomatis saat masa aktif habis.</p>
            </div>
            <label class="relative inline-flex items-center cursor-pointer">
              <input type="checkbox" id="autoRenewToggle" class="sr-only peer">
              <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-100 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
            </label>
          </div>

          <div class="flex justify-end gap-3 pt-4">
            <button onclick="resetForm('sistem')" class="px-5 py-2.5 rounded-lg border border-gray-200 text-slate-600 hover:bg-gray-50 font-medium transition">Reset</button>
            <button onclick="saveSettings('sistem')" class="px-5 py-2.5 rounded-lg bg-blue-700 hover:bg-blue-800 text-white font-medium shadow-md transition flex items-center gap-2">
              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
              Simpan Perubahan
            </button>
          </div>
        </div>
      </div>

    </div>
  </main>

  <!-- Save Confirmation Modal -->
  <div id="saveModal" class="fixed inset-0 z-50 flex items-center justify-center modal-overlay hidden">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-sm mx-4 modal-content hidden p-6 text-center">
      <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4 text-green-600">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
      </div>
      <h3 class="text-lg font-bold text-slate-800 mb-2">Konfirmasi Simpan</h3>
      <p class="text-slate-500 text-sm mb-6">Apakah Anda yakin ingin menyimpan perubahan ini?</p>
      <div class="flex gap-3">
        <button onclick="closeModal('saveModal')" class="flex-1 px-4 py-2.5 rounded-lg border border-gray-200 text-slate-600 hover:bg-gray-50 font-medium transition">Batal</button>
        <button onclick="confirmSave()" class="flex-1 px-4 py-2.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-medium shadow-sm transition">Ya, Simpan</button>
      </div>
    </div>
  </div>

  <!-- Toast Notification -->
  <div id="toast" class="fixed bottom-6 right-6 z-50 transform translate-y-20 opacity-0 transition-all duration-300">
    <div class="bg-green-600 text-white px-6 py-4 rounded-xl shadow-lg flex items-center gap-3">
      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
      <div>
        <p class="font-bold text-sm">Berhasil!</p>
        <p class="text-xs opacity-90" id="toastMessage">Pengaturan telah disimpan.</p>
      </div>
    </div>
  </div>

  <script>
    let currentTab = 'umum';
    let currentSaveTarget = 'umum';

    // Tab Switching
    function switchTab(tab) {
      currentTab = tab;
      
      // Update tab styles
      document.querySelectorAll('[id^="tab-"]').forEach(el => {
        el.classList.remove('tab-active');
        el.classList.add('tab-inactive');
      });
      document.getElementById(`tab-${tab}`).classList.remove('tab-inactive');
      document.getElementById(`tab-${tab}`).classList.add('tab-active');

      // Show/hide content
      document.querySelectorAll('.tab-content').forEach(el => el.classList.add('hidden'));
      document.getElementById(`content-${tab}`).classList.remove('hidden');
    }

    // Save Settings
    function saveSettings(target) {
      currentSaveTarget = target;
      openModal('saveModal');
    }

    // Reset Form
    function resetForm(target) {
      if (target === 'umum') {
        document.getElementById('companyName').value = 'R-NET WiFi';
        document.getElementById('companyAddress').value = 'Jl. Merdeka No. 123, Kota Sungai Penuh, Jambi';
        document.getElementById('companyEmail').value = 'admin@rnet.id';
        document.getElementById('companyPhone').value = '0748-123456';
      } else if (target === 'akun') {
        document.getElementById('loginEmail').value = 'admin@rnet.id';
        document.getElementById('oldPassword').value = '';
        document.getElementById('newPassword').value = '';
        document.getElementById('confirmPassword').value = '';
      } else if (target === 'sistem') {
        document.getElementById('maintenanceToggle').checked = false;
        document.getElementById('emailToggle').checked = true;
        document.getElementById('waToggle').checked = false;
        document.getElementById('autoRenewToggle').checked = false;
      }
      showToast('Form telah direset.');
    }

    // Confirm Save
    function confirmSave() {
      closeModal('saveModal');
      showToast('Pengaturan telah berhasil disimpan!');
    }

    // Modal Logic
    function openModal(modalId) {
      const overlay = document.getElementById(modalId);
      const modal = overlay.querySelector('.modal-content');
      overlay.classList.remove('hidden');
      setTimeout(() => {
        modal.classList.add('show');
      }, 10);
    }

    function closeModal(modalId) {
      const overlay = document.getElementById(modalId);
      const modal = overlay.querySelector('.modal-content');
      modal.classList.remove('show');
      setTimeout(() => {
        overlay.classList.add('hidden');
      }, 200);
    }

    // Toast Notification
    function showToast(message) {
      const toast = document.getElementById('toast');
      document.getElementById('toastMessage').innerText = message;
      toast.classList.remove('translate-y-20', 'opacity-0');
      setTimeout(() => {
        toast.classList.add('translate-y-20', 'opacity-0');
      }, 3000);
    }
  </script>
</body>
</html>

