<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>R-NET Admin - Promosi</title>
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
    .promo-gradient {
      background: linear-gradient(135deg, #f59e0b 0%, #ea580c 100%);
    }
    .promo-gradient-alt {
      background: linear-gradient(135deg, #fbbf24 0%, #f97316 100%);
    }
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
      <a href="#" class="sidebar-active flex items-center gap-3 px-4 py-3 rounded-lg transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 14c.2-1 .7-1.7 1.5-2.5 1-.9 1.5-2.2 1.5-3.5A6 6 0 0 0 6 8c0 1 .2 2.2 1.5 3.5.7.7 1.3 1.5 1.5 2.5"/><path d="M9 18h6"/><path d="M10 22h4"/></svg>
        <span class="font-medium">Promosi</span>
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
      <h2 class="text-2xl font-bold text-slate-800">Promosi</h2>
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

    <!-- Scrollable Content -->
    <div class="flex-1 overflow-y-auto p-8 bg-gray-50">
      <div class="flex justify-between items-center mb-8">
        <div>
          <h3 class="text-2xl font-bold text-slate-800">Promosi</h3>
          <p class="text-sm text-slate-500 mt-1">Kelola promosi dan penawaran spesial</p>
        </div>
        <button onclick="scrollToForm()" class="bg-blue-700 hover:bg-blue-800 text-white px-5 py-3 rounded-lg shadow-lg flex items-center gap-2 font-medium transition-colors">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
          Tambah Promosi
        </button>
      </div>

      <!-- Create/Edit Form -->
      <div id="promoFormSection" class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 mb-8">
        <h4 class="text-lg font-bold text-slate-800 mb-4" id="formTitle">Buat Promosi Baru</h4>
        <div class="space-y-4">
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-slate-700 mb-2">Judul Promo</label>
              <input type="text" id="promoTitle" class="w-full px-4 py-3 rounded-lg border border-gray-200 bg-gray-50 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100 outline-none transition" placeholder="Contoh: Promo Hari Raya">
            </div>
            <div>
              <label class="block text-sm font-medium text-slate-700 mb-2">Diskon (%)</label>
              <input type="number" id="promoDiscount" class="w-full px-4 py-3 rounded-lg border border-gray-200 bg-gray-50 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100 outline-none transition" placeholder="30">
            </div>
          </div>
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Deskripsi</label>
            <textarea id="promoDesc" class="w-full px-4 py-3 rounded-lg border border-gray-200 bg-gray-50 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100 outline-none transition" rows="3" placeholder="Deskripsi promosi"></textarea>
          </div>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="block text-sm font-medium text-slate-700 mb-2">Tanggal Mulai</label>
              <input type="date" id="promoStart" class="w-full px-4 py-3 rounded-lg border border-gray-200 bg-gray-50 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100 outline-none transition">
            </div>
            <div>
              <label class="block text-sm font-medium text-slate-700 mb-2">Tanggal Berakhir</label>
              <input type="date" id="promoEnd" class="w-full px-4 py-3 rounded-lg border border-gray-200 bg-gray-50 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100 outline-none transition">
            </div>
          </div>
          <div class="flex gap-3 pt-2">
            <button onclick="savePromotion()" id="saveBtn" class="px-6 py-3 rounded-lg bg-blue-700 hover:bg-blue-800 text-white font-medium shadow-md transition">Buat Promosi</button>
            <button onclick="cancelEdit()" id="cancelBtn" class="hidden px-6 py-3 rounded-lg border border-gray-200 text-slate-600 hover:bg-gray-50 font-medium transition">Batal</button>
          </div>
        </div>
      </div>

      <!-- Promotions Grid -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="promosContainer">
        <!-- Items will be populated by JS -->
      </div>
    </div>
  </main>

  <!-- Delete Confirmation Modal -->
  <div id="deleteModal" class="fixed inset-0 z-50 flex items-center justify-center modal-overlay hidden">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-sm mx-4 modal-content hidden p-6 text-center">
      <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4 text-red-600">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
      </div>
      <h3 class="text-lg font-bold text-slate-800 mb-2">Hapus Promosi Ini?</h3>
      <p class="text-slate-500 text-sm mb-6">Yakin ingin menghapus promosi ini?</p>
      <div class="flex gap-3">
        <button onclick="closeModal('deleteModal')" class="flex-1 px-4 py-2.5 rounded-lg border border-gray-200 text-slate-600 hover:bg-gray-50 font-medium transition">Cancel</button>
        <button onclick="confirmDelete()" class="flex-1 px-4 py-2.5 rounded-lg bg-red-600 hover:bg-red-700 text-white font-medium shadow-sm transition">OK</button>
      </div>
    </div>
  </div>

  <script>
    // Dummy Data
    let promotions = [
      {
        id: 1,
        title: "Promo Ramadan",
        discount: 30,
        description: "Diskon spesial untuk pelanggan baru yang mendaftar di bulan suci Ramadan",
        startDate: "2026-03-01",
        endDate: "2026-04-30",
        isActive: true
      },
      {
        id: 2,
        title: "Promo Kemerdekaan",
        discount: 17,
        description: "Rayakan kemerdekaan dengan internet super cepat dan harga merdeka!",
        startDate: "2026-08-01",
        endDate: "2026-08-31",
        isActive: false
      },
      {
        id: 3,
        title: "Promo Tahun Baru",
        discount: 25,
        description: "Mulai tahun baru dengan koneksi internet terbaik!",
        startDate: "2027-01-01",
        endDate: "2027-01-31",
        isActive: false
      }
    ];

    let deleteId = null;
    let editId = null;

    // Format Date for Display
    function formatDateShort(dateStr) {
      if (!dateStr) return '';
      const options = { day: 'numeric', month: 'short' };
      return new Date(dateStr).toLocaleDateString('id-ID', options);
    }

    function formatDateFull(dateStr) {
      if (!dateStr) return '';
      const options = { year: 'numeric', month: 'long', day: 'numeric' };
      return new Date(dateStr).toLocaleDateString('id-ID', options);
    }

    // Check if promo is currently active
    function checkActiveStatus(promo) {
      const now = new Date();
      const start = new Date(promo.startDate);
      const end = new Date(promo.endDate);
      end.setHours(23, 59, 59, 999);
      return now >= start && now <= end;
    }

    // Render Promotions
    function renderPromotions() {
      const container = document.getElementById('promosContainer');
      container.innerHTML = '';

      promotions.forEach(promo => {
        const isCurrentlyActive = checkActiveStatus(promo);
        const gradientClass = promo.id % 2 === 0 ? 'promo-gradient' : 'promo-gradient-alt';

        const cardHtml = `
          <div class="${gradientClass} rounded-2xl p-6 text-white shadow-lg relative overflow-hidden group hover:shadow-xl transition-all">
            <!-- Decorative circles -->
            <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16"></div>
            <div class="absolute bottom-0 left-0 w-24 h-24 bg-white/10 rounded-full -ml-12 -mb-12"></div>

            <div class="relative z-10">
              <div class="flex justify-between items-start mb-4">
                <div class="flex items-center gap-3">
                  <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center backdrop-blur-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 14c.2-1 .7-1.7 1.5-2.5 1-.9 1.5-2.2 1.5-3.5A6 6 0 0 0 6 8c0 1 .2 2.2 1.5 3.5.7.7 1.3 1.5 1.5 2.5"/><path d="M9 18h6"/><path d="M10 22h4"/></svg>
                  </div>
                  <div>
                    <h3 class="text-xl font-bold">${promo.title}</h3>
                  </div>
                </div>
                <span class="px-3 py-1 rounded-full text-xs font-bold ${isCurrentlyActive ? 'bg-green-500 text-white' : 'bg-white/20 text-white/80'}">
                  ${isCurrentlyActive ? 'Aktif' : 'Tidak Aktif'}
                </span>
              </div>

              <div class="mb-4">
                <span class="text-4xl font-extrabold">${promo.discount}%</span>
                <span class="text-lg font-medium opacity-80">OFF</span>
              </div>

              <p class="text-sm opacity-90 mb-6 min-h-[60px]">${promo.description}</p>

              <div class="flex items-center gap-2 text-sm opacity-80 mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                <span>${formatDateShort(promo.startDate)} - ${formatDateShort(promo.endDate)} ${new Date(promo.startDate).getFullYear()}</span>
              </div>

              <div class="flex gap-3 pt-4 border-t border-white/20">
                <button onclick="openEditModal(${promo.id})" class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-white/20 hover:bg-white/30 backdrop-blur-sm text-white font-medium transition text-sm">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                  Edit
                </button>
                <button onclick="openDeleteConfirm(${promo.id})" class="flex-1 flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-red-500/80 hover:bg-red-500 backdrop-blur-sm text-white font-medium transition text-sm">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                  Hapus
                </button>
              </div>
            </div>
          </div>
        `;
        container.insertAdjacentHTML('beforeend', cardHtml);
      });
    }

    // Scroll to Form
    function scrollToForm() {
      cancelEdit();
      document.getElementById('promoFormSection').scrollIntoView({ behavior: 'smooth', block: 'start' });
      document.getElementById('promoTitle').focus();
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

    // Save Logic (Create or Update)
    function savePromotion() {
      const title = document.getElementById('promoTitle').value.trim();
      const discount = parseInt(document.getElementById('promoDiscount').value);
      const description = document.getElementById('promoDesc').value.trim();
      const startDate = document.getElementById('promoStart').value;
      const endDate = document.getElementById('promoEnd').value;

      if (!title || !discount || !description || !startDate || !endDate) {
        alert("Harap isi semua field!");
        return;
      }

      if (editId) {
        // Update existing
        const idx = promotions.findIndex(p => p.id === editId);
        if (idx !== -1) {
          promotions[idx] = { ...promotions[idx], title, discount, description, startDate, endDate };
        }
        cancelEdit();
      } else {
        // Create new
        const newId = promotions.length > 0 ? Math.max(...promotions.map(p => p.id)) + 1 : 1;
        promotions.unshift({
          id: newId,
          title,
          discount,
          description,
          startDate,
          endDate,
          isActive: checkActiveStatus({ startDate, endDate })
        });
        // Clear form
        document.getElementById('promoTitle').value = '';
        document.getElementById('promoDiscount').value = '';
        document.getElementById('promoDesc').value = '';
        document.getElementById('promoStart').value = '';
        document.getElementById('promoEnd').value = '';
      }

      renderPromotions();
    }

    // Edit Logic
    function openEditModal(id) {
      const promo = promotions.find(p => p.id === id);
      if (!promo) return;

      editId = id;
      document.getElementById('formTitle').innerText = 'Edit Promosi';
      document.getElementById('promoTitle').value = promo.title;
      document.getElementById('promoDiscount').value = promo.discount;
      document.getElementById('promoDesc').value = promo.description;
      document.getElementById('promoStart').value = promo.startDate;
      document.getElementById('promoEnd').value = promo.endDate;

      document.getElementById('saveBtn').innerText = 'Simpan Perubahan';
      document.getElementById('cancelBtn').classList.remove('hidden');

      document.getElementById('promoFormSection').scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    // Cancel Edit
    function cancelEdit() {
      editId = null;
      document.getElementById('formTitle').innerText = 'Buat Promosi Baru';
      document.getElementById('promoTitle').value = '';
      document.getElementById('promoDiscount').value = '';
      document.getElementById('promoDesc').value = '';
      document.getElementById('promoStart').value = '';
      document.getElementById('promoEnd').value = '';

      document.getElementById('saveBtn').innerText = 'Buat Promosi';
      document.getElementById('cancelBtn').classList.add('hidden');
    }

    // Delete Logic
    function openDeleteConfirm(id) {
      deleteId = id;
      openModal('deleteModal');
    }

    function confirmDelete() {
      if (deleteId) {
        promotions = promotions.filter(p => p.id !== deleteId);
        renderPromotions();

        // If we deleted the item being edited, cancel edit mode
        if (editId === deleteId) {
          cancelEdit();
        }
      }
      closeModal('deleteModal');
      deleteId = null;
    }

    // Initialize
    renderPromotions();
  </script>
</body>
</html>

