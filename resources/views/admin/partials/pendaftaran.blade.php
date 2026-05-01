<!-- Pendaftaran Partial -->
<div class="flex justify-between items-center mb-6">
    <div>
        <h3 class="text-2xl font-bold text-base-content">Data Pendaftaran</h3>
        <p class="text-sm text-base-content/70 mt-1">Kelola semua pendaftaran pelanggan baru</p>
    </div>
    <button onclick="document.getElementById('modal_tambah_pendaftaran').showModal()" class="btn btn-primary">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Tambah Pendaftaran
    </button>
</div>

<div class="bg-base-100 rounded-xl shadow-sm border border-base-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="table table-zebra w-full">
            <thead>
                <tr class="bg-base-200 text-base-content">
                    <th>ID</th>
                    <th>Nama Lengkap</th>
                    <th>Kontak</th>
                    <th>Alamat</th>
                    <th>ID Paket</th>
                    <th>Status</th>
                    <th>Tanggal Daftar</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pendaftaran as $item)
                <tr>
                    <td class="font-mono text-sm">{{ $item->id_pendaftaran }}</td>
                    <td class="font-medium">{{ $item->nama }}</td>
                    <td>
                        <div class="text-sm">{{ $item->nomor_tlpn }}</div>
                        <div class="text-xs text-base-content/70">{{ $item->email }}</div>
                    </td>
                    <td class="max-w-[200px] truncate" title="{{ $item->alamat }}">{{ $item->alamat }}</td>
                    <td><span class="badge badge-info badge-sm">{{ $item->id_paket }}</span></td>
                    <td>
                        <select
                            data-id="{{ $item->id_pendaftaran }}"
                            class="select select-bordered select-sm w-full max-w-xs status-select"
                            onchange="updateStatus(this)"
                        >
                            <option value="pending" {{ $item->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="validated" {{ $item->status == 'validated' ? 'selected' : '' }}>Validated</option>
                            <option value="rejected" {{ $item->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            <option value="setup" {{ $item->status == 'setup' ? 'selected' : '' }}>Setup</option>
                            <option value="active" {{ $item->status == 'active' || $item->status == 'aktif' ? 'selected' : '' }}>Active</option>
                        </select>
                    </td>
                    <td>{{ $item->created_at->format('d M Y') }}</td>
                    <td>
                        <div class="flex justify-center gap-2">
                            <!-- Detail Button -->
                            <button onclick="
                                const img = document.getElementById('img_detail_{{ $item->id_pendaftaran }}');
                                if (img && !img.src) img.src = img.getAttribute('data-src');
                                
                                document.getElementById('modal_detail_{{ $item->id_pendaftaran }}').showModal();
                                
                                if (typeof L !== 'undefined' && !window['map_init_{{ $item->id_pendaftaran }}']) {
                                    setTimeout(() => {
                                        var map = L.map('map_{{ $item->id_pendaftaran }}').setView([{{ $item->latitude }}, {{ $item->longtitude }}], 15);
                                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                            maxZoom: 19,
                                            attribution: '© OpenStreetMap'
                                        }).addTo(map);
                                        L.marker([{{ $item->latitude }}, {{ $item->longtitude }}]).addTo(map)
                                            .bindPopup('Lokasi Pendaftar').openPopup();
                                        window['map_init_{{ $item->id_pendaftaran }}'] = true;
                                    }, 200);
                                }
                            " class="btn btn-sm btn-square btn-ghost text-info" title="Detail">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            </button>
                            <!-- Delete Button -->
                            <button onclick="document.getElementById('modal_hapus_{{ $item->id_pendaftaran }}').showModal()" class="btn btn-sm btn-square btn-ghost text-error" title="Hapus">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-8 text-base-content/50">Belum ada data pendaftaran.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah (Placeholder for future functionality) -->
<dialog id="modal_tambah_pendaftaran" class="modal">
  <div class="modal-box">
    <h3 class="font-bold text-lg">Tambah Pendaftaran</h3>
    <p class="py-4">Fitur penambahan admin belum diimplementasikan backend-nya.</p>
    <div class="modal-action">
      <form method="dialog">
        <button class="btn">Tutup</button>
      </form>
    </div>
  </div>
</dialog>

@foreach($pendaftaran as $item)
<!-- Modal Detail -->
<dialog id="modal_detail_{{ $item->id_pendaftaran }}" class="modal">
  <div class="modal-box max-w-2xl">
    <form method="dialog">
      <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
    </form>
    <h3 class="font-bold text-lg mb-4">Detail Pendaftaran: {{ $item->id_pendaftaran }}</h3>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @if($item->path_gambar)
        <div class="md:col-span-2 rounded-xl overflow-hidden bg-base-200 h-48 flex items-center justify-center">
            @php
                $supabaseUrl = env('S3_ENDPOINT') ? str_replace('/s3', '/object/public/' . env('S3_BUCKET') . '/', env('S3_ENDPOINT')) . $item->path_gambar : Storage::disk('s3')->url($item->path_gambar);
                $imgSrc = Str::startsWith($item->path_gambar, 'http') ? $item->path_gambar : $supabaseUrl;
            @endphp
            <img id="img_detail_{{ $item->id_pendaftaran }}" data-src="{{ $imgSrc }}" alt="Foto Rumah" class="w-full h-full object-cover">
        </div>
        @endif
        
        <div><span class="text-base-content/70 text-sm block">Nama</span><span class="font-medium">{{ $item->nama }}</span></div>
        <div><span class="text-base-content/70 text-sm block">Email</span><span class="font-medium">{{ $item->email }}</span></div>
        <div><span class="text-base-content/70 text-sm block">Telepon</span><span class="font-medium">{{ $item->nomor_tlpn }}</span></div>
        <div><span class="text-base-content/70 text-sm block">ID Paket</span><span class="badge badge-info">{{ $item->id_paket }}</span></div>
        <div><span class="text-base-content/70 text-sm block">Status</span><span id="detail_status_{{ $item->id_pendaftaran }}" class="badge {{ $item->status == 'pending' ? 'badge-warning' : ($item->status == 'validated' ? 'badge-info' : ($item->status == 'rejected' ? 'badge-error' : ($item->status == 'setup' ? 'badge-accent' : ($item->status == 'active' || $item->status == 'aktif' ? 'badge-success' : 'badge-ghost')))) }}">{{ ucfirst($item->status) }}</span></div>
        <div><span class="text-base-content/70 text-sm block">Tanggal Daftar</span><span class="font-medium">{{ $item->created_at->format('d M Y H:i') }}</span></div>
        
        <div class="md:col-span-2"><span class="text-base-content/70 text-sm block">Alamat</span><span class="font-medium">{{ $item->alamat }}</span></div>
        
        <div class="md:col-span-2 bg-info/10 p-4 rounded-xl mt-2">
            <span class="text-info font-bold text-sm block">Titik Koordinat</span>
            <span class="font-mono text-sm mb-2 block">{{ $item->latitude }}, {{ $item->longtitude }}</span>
            <div id="map_{{ $item->id_pendaftaran }}" class="w-full h-48 rounded-lg z-0 relative"></div>
            <a href="https://maps.google.com/?q={{ $item->latitude }},{{ $item->longtitude }}" target="_blank" class="btn btn-sm btn-primary w-full mt-3">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1"><polygon points="3 6 9 3 15 6 21 3 21 18 15 21 9 18 3 21"></polygon><line x1="9" y1="3" x2="9" y2="18"></line><line x1="15" y1="6" x2="15" y2="21"></line></svg>
                Buka di Google Maps
            </a>
        </div>
    </div>
  </div>
  <form method="dialog" class="modal-backdrop">
    <button>close</button>
  </form>
</dialog>

<!-- Modal Hapus -->
<dialog id="modal_hapus_{{ $item->id_pendaftaran }}" class="modal">
  <div class="modal-box text-center">
    <div class="text-error mb-4 flex justify-center">
        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
    </div>
    <h3 class="font-bold text-lg">Hapus Pendaftaran?</h3>
    <p class="py-4">Yakin ingin menghapus pendaftaran <strong>{{ $item->nama }}</strong>? Tindakan ini tidak dapat dibatalkan.</p>
    <div class="modal-action justify-center">
      <form method="dialog">
        <button class="btn mr-2">Batal</button>
      </form>
      <!-- Form Hapus Real Backend (Metode DELETE) -->
      <form action="{{ route('admin.pendaftaran.destroy', $item->id_pendaftaran) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-error">Hapus</button>
      </form>
    </div>
  </div>
  <form method="dialog" class="modal-backdrop">
    <button>close</button>
  </form>
</dialog>
@endforeach

<!-- Toast Notification Container -->
<div id="toast-container" class="toast toast-top toast-end z-50" style="display:none;">
    <div id="toast-msg" class="alert alert-success shadow-lg">
        <span></span>
    </div>
</div>

<script>
    const STATUS_COLORS = {
        pending:   'text-warning',
        validated: 'text-info',
        rejected:  'text-error',
        setup:     'text-accent',
        active:    'text-success'
    };

    function showToast(message, type = 'success') {
        const container = document.getElementById('toast-container');
        const msg = document.getElementById('toast-msg');
        msg.className = 'alert shadow-lg alert-' + type;
        msg.querySelector('span').textContent = message;
        container.style.display = '';
        setTimeout(() => { container.style.display = 'none'; }, 2500);
    }

    async function updateStatus(el) {
        const id = el.dataset.id;
        const newStatus = el.value;
        const prevValue = el.getAttribute('data-prev') || el.querySelector('option[selected]')?.value;

        // Disable select while processing
        el.disabled = true;
        el.classList.add('opacity-50');

        try {
            const res = await fetch(`/admin/pendaftaran/${id}/status`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ status: newStatus })
            });

            if (!res.ok) throw new Error('Request gagal');

            // Update color classes on select
            Object.values(STATUS_COLORS).forEach(c => el.classList.remove(c));
            el.classList.add(STATUS_COLORS[newStatus] || '');
            el.setAttribute('data-prev', newStatus);

            // Sync badge in detail modal
            const BADGE_MAP = {
                pending: 'badge-warning',
                validated: 'badge-info',
                rejected: 'badge-error',
                setup: 'badge-accent',
                active: 'badge-success'
            };
            const badge = document.getElementById('detail_status_' + id);
            if (badge) {
                badge.className = 'badge ' + (BADGE_MAP[newStatus] || 'badge-ghost');
                badge.textContent = newStatus.charAt(0).toUpperCase() + newStatus.slice(1);
            }

            showToast(`Status berhasil diubah ke "${newStatus.charAt(0).toUpperCase() + newStatus.slice(1)}"`, 'success');
        } catch (err) {
            // Rollback to previous value
            if (prevValue) el.value = prevValue;
            showToast('Gagal mengubah status. Coba lagi.', 'error');
        } finally {
            el.disabled = false;
            el.classList.remove('opacity-50');
        }
    }

    // Set initial colors on load
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.status-select').forEach(el => {
            const val = el.value;
            Object.values(STATUS_COLORS).forEach(c => el.classList.remove(c));
            el.classList.add(STATUS_COLORS[val] || '');
            el.setAttribute('data-prev', val);
        });
    });
</script>
