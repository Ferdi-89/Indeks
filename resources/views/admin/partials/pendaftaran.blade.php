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
                        <div class="text-xs text-base-content/70">{{ $item->wilayah }}</div>
                    </td>
                    <td class="max-w-[200px] truncate" title="{{ $item->alamat }}">{{ $item->alamat }}</td>
                    <td><span class="px-2 py-1 bg-info/10 text-info font-bold rounded-md border border-info/20 text-xs">{{ $item->id_paket }}</span></td>
                    <td>
                        <select
                            data-id="{{ $item->id_pendaftaran }}"
                            class="select select-bordered select-sm w-full max-w-xs status-select rounded-md font-semibold bg-base-50/50"
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
                            <button onclick="openDetailModal(
                                'modal_detail_{{ $item->id_pendaftaran }}',
                                {{ $item->latitude }},
                                {{ $item->longtitude }},
                                'map_{{ $item->id_pendaftaran }}',
                                'img_detail_{{ $item->id_pendaftaran }}',
                                ''
                            )" class="btn btn-sm btn-square btn-ghost text-info" title="Detail">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                            </button>
                            <!-- Edit Button -->
                            <button onclick="document.getElementById('modal_edit_{{ $item->id_pendaftaran }}').showModal()" class="btn btn-sm btn-square btn-ghost text-warning" title="Edit">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
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
    
    <!-- Pagination Links -->
    <div class="p-4 border-t border-base-200">
        {{ $pendaftaran->links('pagination::tailwind') }}
    </div>
</div>

<!-- Modal Tambah -->
<dialog id="modal_tambah_pendaftaran" class="modal">
  <div class="modal-box">
    <form method="dialog">
      <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
    </form>
    <h3 class="font-bold text-lg mb-4">Tambah Pendaftaran Baru</h3>
    <form action="{{ route('admin.pendaftaran.store') }}" method="POST" class="space-y-4">
        @csrf
        <div class="form-control w-full">
            <label class="label"><span class="label-text font-medium">Nama Lengkap</span></label>
            <input type="text" name="nama" class="input input-bordered w-full" placeholder="Masukkan nama lengkap" required />
        </div>
        <div class="form-control w-full">
            <label class="label"><span class="label-text font-medium">Wilayah</span></label>
            <select name="wilayah" class="select select-bordered w-full" required>
                <option value="" disabled selected>-- Pilih Wilayah --</option>
                @foreach($areaLayanan as $area)
                    <option value="{{ $area->nama_area }}">{{ $area->nama_area }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-control w-full">
            <label class="label"><span class="label-text font-medium">No. Telepon / WhatsApp</span></label>
            <input type="text" name="nomor_tlpn" class="input input-bordered w-full" placeholder="Contoh: 08123456789" required />
        </div>
        <div class="form-control w-full">
            <label class="label"><span class="label-text font-medium">Pilih Paket Layanan</span></label>
            <select name="id_paket" class="select select-bordered w-full" required>
                <option value="" disabled selected>-- Pilih Paket --</option>
                @foreach($paket as $p)
                    <option value="{{ $p->id_paket }}">{{ $p->id_paket }} - {{ $p->title_paket }} (Rp {{ number_format($p->harga_paket, 0, ',', '.') }})</option>
                @endforeach
            </select>
        </div>
        <div class="form-control w-full">
            <label class="label"><span class="label-text font-medium">Alamat Pemasangan</span></label>
            <textarea name="alamat" class="textarea textarea-bordered h-24" placeholder="Masukkan alamat lengkap..." required></textarea>
        </div>
        <div class="modal-action">
            <button type="button" onclick="document.getElementById('modal_tambah_pendaftaran').close()" class="btn btn-ghost">Batal</button>
            <button type="submit" class="btn btn-primary">Simpan Pendaftaran</button>
        </div>
    </form>
  </div>
  <form method="dialog" class="modal-backdrop">
    <button>close</button>
  </form>
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
        <div><span class="text-base-content/70 text-sm block">Wilayah</span><span class="font-medium">{{ $item->wilayah }}</span></div>
        <div><span class="text-base-content/70 text-sm block">Telepon</span><span class="font-medium">{{ $item->nomor_tlpn }}</span></div>
        <div><span class="text-base-content/70 text-sm block mb-1">ID Paket</span><span class="px-2 py-1 bg-info/10 text-info font-bold rounded-md border border-info/20 text-xs">{{ $item->id_paket }}</span></div>
        <div><span class="text-base-content/70 text-sm block mb-1">Status</span><span id="detail_status_{{ $item->id_pendaftaran }}" class="px-2 py-1 font-bold rounded-md border text-xs {{ $item->status == 'pending' ? 'bg-warning/10 text-warning border-warning/20' : ($item->status == 'validated' ? 'bg-info/10 text-info border-info/20' : ($item->status == 'rejected' ? 'bg-error/10 text-error border-error/20' : ($item->status == 'setup' ? 'bg-accent/10 text-accent border-accent/20' : ($item->status == 'active' || $item->status == 'aktif' ? 'bg-success/10 text-success border-success/20' : 'bg-base-200 text-base-content/70 border-base-300')))) }}">{{ ucfirst($item->status) }}</span></div>
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

<!-- Modal Edit -->
<dialog id="modal_edit_{{ $item->id_pendaftaran }}" class="modal">
  <div class="modal-box">
    <form method="dialog">
      <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
    </form>
    <h3 class="font-bold text-lg mb-4">Edit Pendaftaran: {{ $item->id_pendaftaran }}</h3>
    
    <form action="{{ route('admin.pendaftaran.update', $item->id_pendaftaran) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')
        
        <div class="form-control w-full">
            <label class="label"><span class="label-text">Nama Lengkap</span></label>
            <input type="text" name="nama" value="{{ $item->nama }}" class="input input-bordered w-full" required />
        </div>
        
        <div class="form-control w-full">
            <label class="label"><span class="label-text">Wilayah</span></label>
            <select name="wilayah" class="select select-bordered w-full" required>
                <option value="" disabled>-- Pilih Wilayah --</option>
                @foreach($areaLayanan as $area)
                    <option value="{{ $area->nama_area }}" {{ $item->wilayah == $area->nama_area ? 'selected' : '' }}>{{ $area->nama_area }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="form-control w-full">
            <label class="label"><span class="label-text">Telepon</span></label>
            <input type="text" name="nomor_tlpn" value="{{ $item->nomor_tlpn }}" class="input input-bordered w-full" required />
        </div>
        
        <div class="form-control w-full">
            <label class="label"><span class="label-text">Paket</span></label>
            <select name="id_paket" class="select select-bordered w-full" required>
                @foreach($paket as $p)
                    <option value="{{ $p->id_paket }}" {{ $item->id_paket == $p->id_paket ? 'selected' : '' }}>{{ $p->id_paket }} - {{ $p->title_paket }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="form-control w-full">
            <label class="label"><span class="label-text">Alamat</span></label>
            <textarea name="alamat" class="textarea textarea-bordered h-24" required>{{ $item->alamat }}</textarea>
        </div>
        
        <div class="modal-action">
            <button type="button" onclick="document.getElementById('modal_edit_{{ $item->id_pendaftaran }}').close()" class="btn">Batal</button>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </div>
    </form>
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
                pending: 'bg-warning/10 text-warning border-warning/20',
                validated: 'bg-info/10 text-info border-info/20',
                rejected: 'bg-error/10 text-error border-error/20',
                setup: 'bg-accent/10 text-accent border-accent/20',
                active: 'bg-success/10 text-success border-success/20'
            };
            const badge = document.getElementById('detail_status_' + id);
            if (badge) {
                badge.className = 'px-2 py-1 font-bold rounded-md border text-xs ' + (BADGE_MAP[newStatus] || 'bg-base-200 text-base-content/70 border-base-300');
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
