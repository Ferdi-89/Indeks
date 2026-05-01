@extends('admin.layouts.main')

@section('title', 'Promosi')

@section('content')
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
@endsection

@section('modals')
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
@endsection

@section('scripts')
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
@endsection
