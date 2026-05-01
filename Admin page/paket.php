<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>R-NET Admin - Paket Internet</title>
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
      <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg text-blue-200 hover:bg-blue-800 hover:text-white transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
        <span>Dasbor</span>
      </a>
      <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-lg text-blue-200 hover:bg-blue-800 hover:text-white transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" x2="19" y1="8" y2="14"/><line x1="22" x2="16" y1="11" y2="11"/></svg>
        <span>Pendaftaran</span>
      </a>
      <a href="#" class="sidebar-active flex items-center gap-3 px-4 py-3 rounded-lg transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 12V8H6a2 2 0 0 1-2-2c0-1.1.9-2 2-2h12v4"/><path d="M4 6v12a2 2 0 0 0 2 2h14v-4"/><path d="M18 12a2 2 0 0 0 0 4h4v-4Z"/></svg>
        <span class="font-medium">Paket Internet</span>
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
      <h2 class="text-2xl font-bold text-slate-800">Paket Internet</h2>
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
          <h3 class="text-2xl font-bold text-slate-800">Paket Internet</h3>
          <p class="text-sm text-slate-500 mt-1">Kelola paket internet yang tersedia</p>
        </div>
        <button onclick="openAddModal()" class="bg-blue-700 hover:bg-blue-800 text-white px-5 py-3 rounded-lg shadow-lg flex items-center gap-2 font-medium transition-colors">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
          Tambah Paket
        </button>
      </div>

      <!-- Packages Grid -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8" id="packagesContainer">
        <!-- Content will be populated by JS -->
      </div>
    </div>
  </main>

  <!-- Add/Edit Modal -->
  <div id="formModal" class="fixed inset-0 z-50 flex items-center justify-center modal-overlay hidden">
    <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg mx-4 modal-content hidden">
      <div class="p-6 border-b border-gray-100 flex justify-between items-center">
        <h3 class="text-lg font-bold text-slate-800" id="formModalTitle">Tambah Paket</h3>
        <button onclick="closeModal('formModal')" class="text-slate-400 hover:text-slate-600 transition">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
      </div>
      <div class="p-6 space-y-4">
        <div>
          <label class="block text-sm font-medium text-slate-700 mb-2">Nama Paket</label>
          <input type="text" class="w-full px-4 py-3 rounded-lg border border-gray-200 bg-gray-50 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100 outline-none transition" id="inputName">
        </div>
        <div class="grid grid-cols-2 gap-4">
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Kecepatan</label>
            <input type="text" class="w-full px-4 py-3 rounded-lg border border-gray-200 bg-gray-50 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100 outline-none transition" id="inputSpeed">
          </div>
          <div>
            <label class="block text-sm font-medium text-slate-700 mb-2">Harga</label>
            <input type="text" class="w-full px-4 py-3 rounded-lg border border-gray-200 bg-gray-50 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100 outline-none transition" id="inputPrice">
          </div>
        </div>
        <div>
          <label class="block text-sm font-medium text-slate-700 mb-2">Fitur (satu per baris)</label>
          <textarea class="w-full px-4 py-3 rounded-lg border border-gray-200 bg-gray-50 focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100 outline-none transition" rows="3" id="inputFeatures"></textarea>
        </div>
        <div class="flex items-center gap-3 pt-2">
          <input type="checkbox" id="inputPopular" class="w-5 h-5 text-blue-600 rounded focus:ring-blue-500 border-gray-300 cursor-pointer">
          <label for="inputPopular" class="text-sm font-medium text-slate-700 cursor-pointer">Tandai sebagai paling populer</label>
        </div>
      </div>
      <div class="p-6 border-t border-gray-100 flex justify-end gap-3">
        <button onclick="closeModal('formModal')" class="px-5 py-2.5 rounded-lg border border-gray-200 text-slate-600 hover:bg-gray-50 font-medium transition">Batal</button>
        <button onclick="savePackage()" class="px-5 py-2.5 rounded-lg bg-blue-700 hover:bg-blue-800 text-white font-medium shadow-md transition">Simpan</button>
      </div>
    </div>
  </div>

  <!-- Delete Confirmation Modal -->
  <div id="deleteModal" class="fixed inset-0 z-50 flex items-center justify-center modal-overlay hidden">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-sm mx-4 modal-content hidden p-6 text-center">
      <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4 text-red-600">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
      </div>
      <h3 class="text-lg font-bold text-slate-800 mb-2">Hapus Paket Ini?</h3>
      <p class="text-slate-500 text-sm mb-6">Yakin ingin menghapus paket ini?</p>
      <div class="flex gap-3">
        <button onclick="closeModal('deleteModal')" class="flex-1 px-4 py-2.5 rounded-lg border border-gray-200 text-slate-600 hover:bg-gray-50 font-medium transition">Cancel</button>
        <button onclick="confirmDelete()" class="flex-1 px-4 py-2.5 rounded-lg bg-red-600 hover:bg-red-700 text-white font-medium shadow-sm transition">OK</button>
      </div>
    </div>
  </div>

  <script>
    // Dummy Data for Packages
    let packages = [
      {
        id: 1,
        name: "Basic",
        speed: "20 Mbps",
        price: "Rp 150.000",
        features: ["20 Mbps", "Unlimited Kuota", "Gratis Instalasi"],
        isPopular: false
      },
      {
        id: 2,
        name: "Premium",
        speed: "50 Mbps",
        price: "Rp 275.000",
        features: ["50 Mbps", "Unlimited Kuota", "Gratis Instalasi", "Support 24/7"],
        isPopular: true
      },
      {
        id: 3,
        name: "Ultimate",
        speed: "100 Mbps",
        price: "Rp 450.000",
        features: ["100 Mbps", "Unlimited Kuota", "Gratis Instalasi", "Support 24/7", "WiFi 6 Router"],
        isPopular: false
      }
    ];

    let deleteId = null;
    let editId = null;

    // Render Packages
    function renderPackages() {
      const container = document.getElementById('packagesContainer');
      container.innerHTML = '';

      packages.forEach(pkg => {
        let cardClass = "bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col transition-all hover:shadow-md relative";
        let headerHtml = '';

        if (pkg.isPopular) {
          cardClass += " ring-2 ring-blue-600 shadow-md z-10 scale-[1.02]";
          headerHtml = `
            <div class="absolute top-0 left-0 right-0 bg-blue-700 text-white text-center py-1 rounded-t-xl text-sm font-bold tracking-wide">
              PALING POPULER
            </div>
            <div class="mt-8 mb-4"></div>
          `;
        } else {
          headerHtml = `<div class="mb-4"></div>`;
        }

        const iconColor = pkg.isPopular ? 'text-blue-600' : 'text-slate-400';

        const featuresList = pkg.features.map(f => `
          <li class="flex items-center gap-2 text-sm text-slate-600 mb-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-green-500"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            ${f}
          </li>
        `).join('');

        const cardHtml = `
          <div class="${cardClass}">
            ${headerHtml}
            <div class="mb-4">
              <div class="w-12 h-12 rounded-lg ${pkg.isPopular ? 'bg-blue-50' : 'bg-gray-100'} flex items-center justify-center mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="${iconColor}"><path d="M12 20h.01"/><path d="M2 8.82a15 15 0 0 1 20 0"/><path d="M5 12.859a10 10 0 0 1 14 0"/><path d="M8.5 16.429a5 5 0 0 1 7 0"/></svg>
              </div>
              <h3 class="text-xl font-bold text-slate-800">${pkg.name}</h3>
              <div class="flex items-center gap-1 mt-1 text-blue-600 font-bold text-lg">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-yellow-500"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                ${pkg.speed}
              </div>
            </div>

            <div class="mb-6">
              <span class="text-3xl font-bold text-slate-800">${pkg.price}</span>
              <span class="text-sm text-slate-500">/bulan</span>
            </div>

            <ul class="flex-1 mb-6">
              ${featuresList}
            </ul>

            <div class="flex gap-3 pt-4 border-t border-gray-100">
              <button onclick="openEditModal(${pkg.id})" class="flex-1 flex items-center justify-center gap-2 px-4 py-2 rounded-lg bg-green-50 text-green-700 hover:bg-green-100 font-medium transition text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                Edit
              </button>
              <button onclick="openDeleteConfirm(${pkg.id})" class="flex-1 flex items-center justify-center gap-2 px-4 py-2 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 font-medium transition text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                Hapus
              </button>
            </div>
          </div>
        `;
        container.insertAdjacentHTML('beforeend', cardHtml);
      });
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

    // Add Logic
    function openAddModal() {
      editId = null;
      document.getElementById('formModalTitle').innerText = 'Tambah Paket';
      document.getElementById('inputName').value = '';
      document.getElementById('inputSpeed').value = '';
      document.getElementById('inputPrice').value = '';
      document.getElementById('inputFeatures').value = '';
      document.getElementById('inputPopular').checked = false;
      openModal('formModal');
    }

    // Edit Logic
    function openEditModal(id) {
      const pkg = packages.find(p => p.id === id);
      if (!pkg) return;
      editId = id;
      document.getElementById('formModalTitle').innerText = 'Edit Paket';
      document.getElementById('inputName').value = pkg.name;
      document.getElementById('inputSpeed').value = pkg.speed;
      document.getElementById('inputPrice').value = pkg.price;
      document.getElementById('inputFeatures').value = pkg.features.join('\n');
      document.getElementById('inputPopular').checked = pkg.isPopular;
      openModal('formModal');
    }

    // Save Logic
    function savePackage() {
      const name = document.getElementById('inputName').value;
      const speed = document.getElementById('inputSpeed').value;
      const price = document.getElementById('inputPrice').value;
      const featuresText = document.getElementById('inputFeatures').value;
      const isPopular = document.getElementById('inputPopular').checked;

      // Parse features
      const features = featuresText.split('\n').filter(f => f.trim() !== '');

      if (editId) {
        const idx = packages.findIndex(p => p.id === editId);
        if (idx !== -1) {
          packages[idx] = { ...packages[idx], name, speed, price, features, isPopular };
        }
      } else {
        const newId = packages.length > 0 ? Math.max(...packages.map(p => p.id)) + 1 : 1;
        packages.push({
          id: newId,
          name, speed, price, features, isPopular
        });
      }
      renderPackages();
      closeModal('formModal');
    }

    // Delete Logic
    function openDeleteConfirm(id) {
      deleteId = id;
      openModal('deleteModal');
    }

    function confirmDelete() {
      if (deleteId) {
        packages = packages.filter(p => p.id !== deleteId);
        renderPackages();
      }
      closeModal('deleteModal');
      deleteId = null;
    }

    // Initialize
    renderPackages();
  </script>
</body>
</html>

