<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>R-NET Admin - Pendaftaran</title>
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
      <a href="#" onclick="switchPage('dashboard')" class="flex items-center gap-3 px-4 py-3 rounded-lg text-blue-200 hover:bg-blue-800 hover:text-white transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
        <span>Dasbor</span>
      </a>
      <a href="#" class="sidebar-active flex items-center gap-3 px-4 py-3 rounded-lg transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" x2="19" y1="8" y2="14"/><line x1="22" x2="16" y1="11" y2="11"/></svg>
        <span class="font-medium">Pendaftaran</span>
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
      <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg text-blue-200 hover:bg-blue-800 hover:text-white transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/><circle cx="12" cy="12" r="3"/></svg>
        <span>Pengaturan</span>
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
      <h2 class="text-2xl font-bold text-slate-800" id="pageTitle">Pendaftaran</h2>
      <div class="flex items-center gap-6">
        <!-- Notification -->
        <div class="relative">
          <button class="relative p-2 text-slate-600 hover:text-blue-600 transition rounded-full hover:bg-gray-100">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 8a6 6 0 0 1 12 0c0 7 3 9 3 9H3s3-2 3-9"/><path d="M10.3 21a1.94 1.94 0 0 0 3.4 0"/></svg>
            <span class="absolute top-1 right-1 bg-red-500 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center border-2 border-white">3</span>
          </button>
        </div>
        <!-- Profile -->
        <div class="flex items-center gap-3 cursor-pointer">
          <div class="text-right hidden sm:block">
            <p class="font-semibold text-sm text-slate-800">Admin R-NET</p>
            <p class="text-xs text-slate-500">Administrator</p>
          </div>
          <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold shadow-sm">AR</div>
        </div>
      </div>
    </header>

    <!-- Scrollable Content - Registration Page -->
    <div class="flex-1 overflow-y-auto p-8 bg-gray-50">
      <div class="flex justify-between items-center mb-6">
        <div>
          <h3 class="text-2xl font-bold text-slate-800">Data Pendaftaran</h3>
          <p class="text-sm text-slate-500 mt-1">Kelola semua pendaftaran pelanggan baru</p>
        </div>
        <button onclick="openAddModal()" class="bg-blue-700 hover:bg-blue-800 text-white px-5 py-3 rounded-lg shadow-lg flex items-center gap-2 font-medium transition-colors">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
          Tambah Pendaftaran
        </button>
      </div>

      <!-- Table Card -->
      <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
          <table class="w-full text-left border-collapse">
            <thead>
              <tr class="bg-gray-50 text-slate-500 text-sm border-b border-gray-200">
                <th class="py-4 px-6 font-semibold">Nama Lengkap</th>
                <th class="py-4 px-6 font-semibold">Nomor Telepon</th>
                <th class="py-4 px-6 font-semibold">Alamat</th>
                <th class="py-4 px-6 font-semibold">Tanggal Daftar</th>
                <th class="py-4 px-6 font-semibold">Status</th>
                <th class="py-4 px-6 font-semibold text-center">Aksi</th>
              </tr>
            </thead>
            <tbody class="text-slate-700 divide-y divide-gray-100" id="registrationTableBody">
              <!-- Rows will be populated by JS -->
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </main>

  <!-- Form Modal (Add/Edit) -->
  <div id="formModal" class="fixed inset-0 z-50 flex items-center justify-center modal-overlay hidden">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl mx-4 modal-content hidden">
      <div class="p-6 border-b border-gray-100 flex justify-between items-center">
        <h3 class="text-lg font-bold text-slate-800" id="formModalTitle">Tambah Pendaftaran</h3>
        <button onclick="closeModal('formModal')" class="text-slate-400 hover:text-slate-600 transition">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
      </div>
      <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <label class="block text-sm font-medium text-slate-700 mb-2">Nama Lengkap</label>
          <input type="text" class="w-full px-4 py-3 rounded-lg border border-gray-200 bg-gray-50 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100 outline-none transition" id="inputNama">
        </div>
        <div>
          <label class="block text-sm font-medium text-slate-700 mb-2">Nomor Telepon</label>
          <input type="text" class="w-full px-4 py-3 rounded-lg border border-gray-200 bg-gray-50 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100 outline-none transition" id="inputTelepon">
        </div>
        <div class="md:col-span-2">
          <label class="block text-sm font-medium text-slate-700 mb-2">Alamat</label>
          <textarea class="w-full px-4 py-3 rounded-lg border border-gray-200 bg-gray-50 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100 outline-none transition" rows="2" id="inputAlamat"></textarea>
        </div>
        <div>
          <label class="block text-sm font-medium text-slate-700 mb-2">Latitude</label>
          <input type="text" class="w-full px-4 py-3 rounded-lg border border-gray-200 bg-gray-50 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100 outline-none transition" placeholder="-6.175392" id="inputLat">
        </div>
        <div>
          <label class="block text-sm font-medium text-slate-700 mb-2">Longitude</label>
          <input type="text" class="w-full px-4 py-3 rounded-lg border border-gray-200 bg-gray-50 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100 outline-none transition" placeholder="106.827153" id="inputLong">
        </div>
        <div>
          <label class="block text-sm font-medium text-slate-700 mb-2">Tanggal Daftar</label>
          <input type="date" class="w-full px-4 py-3 rounded-lg border border-gray-200 bg-gray-50 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100 outline-none transition" id="inputDate">
        </div>
        <div>
          <label class="block text-sm font-medium text-slate-700 mb-2">Status</label>
          <select class="w-full px-4 py-3 rounded-lg border border-gray-200 bg-gray-50 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100 outline-none transition" id="inputStatus">
            <option value="Menunggu">Menunggu</option>
            <option value="Disetujui">Disetujui</option>
            <option value="Ditolak">Ditolak</option>
          </select>
        </div>
        <div class="md:col-span-2">
          <label class="block text-sm font-medium text-slate-700 mb-2">URL Foto Rumah</label>
          <input type="text" class="w-full px-4 py-3 rounded-lg border border-gray-200 bg-gray-50 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100 outline-none transition" placeholder="https://..." id="inputPhoto">
        </div>
      </div>
      <div class="p-6 border-t border-gray-100 flex justify-end gap-3">
        <button onclick="closeModal('formModal')" class="px-5 py-2.5 rounded-lg border border-gray-200 text-slate-600 hover:bg-gray-50 font-medium transition">Batal</button>
        <button onclick="saveData()" class="px-5 py-2.5 rounded-lg bg-blue-700 hover:bg-blue-800 text-white font-medium shadow-md transition">Simpan</button>
      </div>
    </div>
  </div>

  <!-- Detail Modal -->
  <div id="detailModal" class="fixed inset-0 z-50 flex items-center justify-center modal-overlay hidden">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-2xl mx-4 modal-content hidden overflow-hidden">
      <div class="p-6 border-b border-gray-100 flex justify-between items-center">
        <h3 class="text-lg font-bold text-slate-800">Detail Pendaftar</h3>
        <button onclick="closeModal('detailModal')" class="text-slate-400 hover:text-slate-600 transition">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
      </div>
      <div class="p-6">
        <div class="rounded-xl overflow-hidden mb-6 h-48 w-full bg-gray-200 relative group">
          <img id="detailPhoto" src="" alt="Foto Rumah" class="w-full h-full object-cover">
        </div>
        <div class="grid grid-cols-2 gap-6 text-sm">
          <div>
            <p class="text-slate-500 mb-1">Nama</p>
            <p class="font-bold text-slate-800 text-base" id="detailNama">-</p>
          </div>
          <div>
            <p class="text-slate-500 mb-1">Telepon</p>
            <p class="font-bold text-slate-800 text-base" id="detailTelepon">-</p>
          </div>
          <div>
            <p class="text-slate-500 mb-1">Tanggal Daftar</p>
            <p class="font-bold text-slate-800 flex items-center gap-2">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-slate-400"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
              <span id="detailDate">-</span>
            </p>
          </div>
          <div>
            <p class="text-slate-500 mb-1">Status</p>
            <span id="detailStatus" class="inline-block px-3 py-1 rounded-full text-xs font-bold">-</span>
          </div>
          <div class="col-span-2">
            <p class="text-slate-500 mb-1">Alamat</p>
            <p class="font-bold text-slate-800" id="detailAlamat">-</p>
          </div>
        </div>
        <div class="mt-6 bg-blue-50 p-4 rounded-xl flex items-start gap-3">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-600 mt-0.5"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
          <div>
            <p class="text-blue-900 font-semibold text-sm">Titik Koordinat</p>
            <p class="text-blue-800 text-sm mt-1 font-mono" id="detailCoords">-</p>
            <a href="#" class="text-blue-600 text-xs font-medium mt-1 inline-block hover:underline">Buka di Google Maps →</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Delete Confirmation Modal -->
  <div id="deleteModal" class="fixed inset-0 z-50 flex items-center justify-center modal-overlay hidden">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-sm mx-4 modal-content hidden p-6 text-center">
      <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4 text-red-600">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
      </div>
      <h3 class="text-lg font-bold text-slate-800 mb-2">Hapus Pendaftaran?</h3>
      <p class="text-slate-500 text-sm mb-6">Yakin ingin menghapus pendaftaran ini? Tindakan ini tidak dapat dibatalkan.</p>
      <div class="flex gap-3">
        <button onclick="closeModal('deleteModal')" class="flex-1 px-4 py-2.5 rounded-lg border border-gray-200 text-slate-600 hover:bg-gray-50 font-medium transition">Batal</button>
        <button onclick="confirmDelete()" class="flex-1 px-4 py-2.5 rounded-lg bg-red-600 hover:bg-red-700 text-white font-medium shadow-sm transition">Hapus</button>
      </div>
    </div>
  </div>

  <script>
    // Dummy Data
    let registrations = [
      { id: 1, nama: "Budi Santoso", telepon: "081234567890", alamat: "Jl. Merdeka No. 123, Jakarta", date: "29 Apr 2026", status: "Menunggu", lat: "-6.175392", long: "106.827153", photo: "https://images.unsplash.com/photo-1568605114967-8130f3a36994?w=600" },
      { id: 2, nama: "Siti Aminah", telepon: "082345678901", alamat: "Jl. Sudirman No. 456, Bandung", date: "28 Apr 2026", status: "Disetujui", lat: "-6.9175", long: "107.6191", photo: "https://images.unsplash.com/photo-1570129477492-45c003edd2be?w=600" },
      { id: 3, nama: "Ahmad Rizki", telepon: "083456789012", alamat: "Jl. Gatot Subroto No. 789, Surabaya", date: "28 Apr 2026", status: "Menunggu", lat: "-7.2575", long: "112.7521", photo: "https://images.unsplash.com/photo-1600596542815-2495db98dada?w=600" },
      { id: 4, nama: "Dewi Lestari", telepon: "084567890123", alamat: "Jl. Thamrin No. 321, Medan", date: "27 Apr 2026", status: "Ditolak", lat: "3.5952", long: "98.6722", photo: "https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=600" },
      { id: 5, nama: "Rudi Hartono", telepon: "085678901234", alamat: "Jl. Ahmad Yani No. 654, Semarang", date: "26 Apr 2026", status: "Disetujui", lat: "-6.9666", long: "110.4196", photo: "https://images.unsplash.com/photo-1512917774080-9991f1c4c750?w=600" }
    ];

    let deleteId = null;
    let editId = null;

    // Render Table
    function renderTable() {
      const tbody = document.getElementById('registrationTableBody');
      tbody.innerHTML = '';

      registrations.forEach(item => {
        let statusClass = '';
        if (item.status === 'Menunggu') statusClass = 'bg-yellow-100 text-yellow-800';
        else if (item.status === 'Disetujui') statusClass = 'bg-green-100 text-green-800';
        else statusClass = 'bg-red-100 text-red-800';

        const tr = document.createElement('tr');
        tr.className = 'hover:bg-gray-50 transition group';
        tr.innerHTML = `
          <td class="py-4 px-6 font-medium text-slate-800">${item.nama}</td>
          <td class="py-4 px-6 text-slate-600">${item.telepon}</td>
          <td class="py-4 px-6 text-slate-600 max-w-xs truncate">${item.alamat}</td>
          <td class="py-4 px-6 text-slate-600">${item.date}</td>
          <td class="py-4 px-6">
            <span class="px-3 py-1 rounded-full text-xs font-bold ${statusClass}">${item.status}</span>
          </td>
          <td class="py-4 px-6 text-center">
            <div class="flex justify-center gap-2">
              <button onclick="openDetail(${item.id})" class="p-2 rounded-lg hover:bg-blue-50 text-blue-500 transition" title="Lihat Detail">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
              </button>
              <button onclick="openEdit(${item.id})" class="p-2 rounded-lg hover:bg-green-50 text-green-600 transition" title="Edit">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
              </button>
              <button onclick="openDeleteConfirm(${item.id})" class="p-2 rounded-lg hover:bg-red-50 text-red-500 transition" title="Hapus">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
              </button>
            </div>
          </td>
        `;
        tbody.appendChild(tr);
      });
    }

    // Modal Logic
    function openModal(modalId) {
      const overlay = document.getElementById(modalId);
      const modal = overlay.querySelector('.modal-content');
      overlay.classList.remove('hidden');
      // Small delay for animation
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

    // Add Logic
    function openAddModal() {
      editId = null;
      document.getElementById('formModalTitle').innerText = 'Tambah Pendaftaran';
      document.getElementById('inputNama').value = '';
      document.getElementById('inputTelepon').value = '';
      document.getElementById('inputAlamat').value = '';
      document.getElementById('inputLat').value = '';
      document.getElementById('inputLong').value = '';
      document.getElementById('inputDate').value = '2026-04-29';
      document.getElementById('inputStatus').value = 'Menunggu';
      document.getElementById('inputPhoto').value = '';
      openModal('formModal');
    }

    // Edit Logic
    function openEdit(id) {
      const item = registrations.find(r => r.id === id);
      if (!item) return;
      editId = id;
      document.getElementById('formModalTitle').innerText = 'Edit Pendaftaran';
      document.getElementById('inputNama').value = item.nama;
      document.getElementById('inputTelepon').value = item.telepon;
      document.getElementById('inputAlamat').value = item.alamat;
      document.getElementById('inputLat').value = item.lat;
      document.getElementById('inputLong').value = item.long;
      document.getElementById('inputDate').value = '2026-04-29'; // Format adjustment if needed
      document.getElementById('inputStatus').value = item.status;
      document.getElementById('inputPhoto').value = item.photo;
      openModal('formModal');
    }

    // Save Logic
    function saveData() {
      const nama = document.getElementById('inputNama').value;
      const telepon = document.getElementById('inputTelepon').value;
      const alamat = document.getElementById('inputAlamat').value;
      const lat = document.getElementById('inputLat').value;
      const long = document.getElementById('inputLong').value;
      const status = document.getElementById('inputStatus').value;
      const photo = document.getElementById('inputPhoto').value || 'https://images.unsplash.com/photo-1568605114967-8130f3a36994?w=600';

      if (editId) {
        // Update
        const idx = registrations.findIndex(r => r.id === editId);
        if (idx !== -1) {
          registrations[idx] = { ...registrations[idx], nama, telepon, alamat, lat, long, status, photo };
        }
      } else {
        // Create
        const newId = registrations.length > 0 ? Math.max(...registrations.map(r => r.id)) + 1 : 1;
        registrations.unshift({
          id: newId,
          nama, telepon, alamat, date: "29 Apr 2026", status, lat, long, photo
        });
      }
      renderTable();
      closeModal('formModal');
    }

    // Detail Logic
    function openDetail(id) {
      const item = registrations.find(r => r.id === id);
      if (!item) return;
      document.getElementById('detailPhoto').src = item.photo;
      document.getElementById('detailNama').innerText = item.nama;
      document.getElementById('detailTelepon').innerText = item.telepon;
      document.getElementById('detailDate').innerText = item.date;
      document.getElementById('detailAlamat').innerText = item.alamat;

      const statusEl = document.getElementById('detailStatus');
      statusEl.innerText = item.status;
      if (item.status === 'Menunggu') statusEl.className = 'inline-block px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-800';
      else if (item.status === 'Disetujui') statusEl.className = 'inline-block px-3 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800';
      else statusEl.className = 'inline-block px-3 py-1 rounded-full text-xs font-bold bg-red-100 text-red-800';

      document.getElementById('detailCoords').innerText = `${item.lat}, ${item.long}`;

      openModal('detailModal');
    }

    // Delete Logic
    function openDeleteConfirm(id) {
      deleteId = id;
      openModal('deleteModal');
    }

    function confirmDelete() {
      if (deleteId) {
        registrations = registrations.filter(r => r.id !== deleteId);
        renderTable();
      }
      closeModal('deleteModal');
      deleteId = null;
    }

    // Initialize
    renderTable();

    // Page Switcher (Mock)
    function switchPage(page) {
      // In a real app, this would route to different HTML files or components.
      // Here we just update the active state on the sidebar for visual feedback.
      alert("Navigasi ke halaman: " + page);
    }
  </script>
</body>
</html>

