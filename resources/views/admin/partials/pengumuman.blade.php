<!-- Pengumuman Partial -->
<div class="mb-8">
    <h3 class="text-2xl font-bold text-base-content">Pengumuman</h3>
    <p class="text-sm text-base-content/70 mt-1">Kelola pengumuman untuk pelanggan dari database</p>
</div>

<!-- Create Form -->
<div class="card bg-base-100 shadow-sm border border-base-200 mb-8">
    <div class="card-body">
        <h4 class="card-title text-lg mb-4">Buat Pengumuman Baru</h4>
        <form action="{{ route('admin.pengumuman.store') }}" method="POST" class="space-y-4">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="form-control">
                    <label class="label"><span class="label-text">ID Pengumuman</span></label>
                    <input type="text" name="id_pengumuman" class="input input-bordered" placeholder="Contoh: PENG-01" required />
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text">Tema</span></label>
                    <input type="text" name="tema" class="input input-bordered" placeholder="Contoh: Maintenance / Promo" required />
                </div>
            </div>

            <div class="form-control">
                <label class="label"><span class="label-text">Isi Pengumuman</span></label>
                <textarea name="text_pengumuman" class="textarea textarea-bordered h-24" placeholder="Masukkan isi pengumuman..." required></textarea>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="form-control">
                    <label class="label"><span class="label-text">Tanggal Mulai</span></label>
                    <input type="date" name="valid_start" class="input input-bordered" required />
                </div>
                <div class="form-control">
                    <label class="label"><span class="label-text">Tanggal Berakhir</span></label>
                    <input type="date" name="valid_end" class="input input-bordered" required />
                </div>
            </div>
            
            <div class="mt-4 flex gap-2">
                <button type="submit" class="btn btn-primary">Publikasikan</button>
            </div>
        </form>
    </div>
</div>

<!-- Announcements List -->
<h4 class="font-bold text-lg mb-4 text-base-content">Daftar Pengumuman</h4>
<div class="space-y-4">
    @forelse($pengumuman as $item)
    <div class="card bg-base-100 shadow-sm border border-base-200 hover:shadow-md transition">
        <div class="card-body p-6 flex flex-col md:flex-row items-start justify-between gap-4">
            <div class="flex items-start gap-4">
                <div class="w-12 h-12 rounded-lg bg-info/10 flex items-center justify-center flex-shrink-0 text-info">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"/><path d="M15.54 8.46a5 5 0 0 1 0 7.07"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14"/></svg>
                </div>
                <div>
                    <h5 class="font-bold text-lg mb-1">{{ $item->tema ?? 'Informasi' }} <span class="badge badge-sm badge-ghost ml-2">{{ $item->id_pengumuman }}</span></h5>
                    <p class="text-base-content/80 font-medium mb-3">{{ $item->text_pengumuman }}</p>
                    <div class="flex items-center gap-2 text-sm text-base-content/60">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        <span>{{ $item->valid_start ? date('d M Y', strtotime($item->valid_start)) : '-' }} s/d {{ $item->valid_end ? date('d M Y', strtotime($item->valid_end)) : '-' }}</span>
                    </div>
                </div>
            </div>
            <div class="flex gap-2 flex-shrink-0">
                <button onclick="document.getElementById('modal_edit_{{ $item->id_pengumuman }}').showModal()" class="btn btn-square btn-ghost text-success" title="Edit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                </button>
                <button onclick="document.getElementById('modal_hapus_{{ $item->id_pengumuman }}').showModal()" class="btn btn-square btn-ghost text-error" title="Hapus">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                </button>
            </div>
        </div>
    </div>
    @empty
    <div class="py-8 text-center text-base-content/50 bg-base-100 rounded-xl border border-base-200">
        Belum ada pengumuman.
    </div>
    @endforelse
</div>

@foreach($pengumuman as $item)
<!-- Modal Edit -->
<dialog id="modal_edit_{{ $item->id_pengumuman }}" class="modal">
  <div class="modal-box w-11/12 max-w-3xl">
    <h3 class="font-bold text-lg mb-4">Edit Pengumuman: {{ $item->id_pengumuman }}</h3>
    <form action="{{ route('admin.pengumuman.update', $item->id_pengumuman) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')
        
        <div class="form-control">
            <label class="label"><span class="label-text">Tema</span></label>
            <input type="text" name="tema" value="{{ $item->tema }}" class="input input-bordered" required />
        </div>

        <div class="form-control">
            <label class="label"><span class="label-text">Isi Pengumuman</span></label>
            <textarea name="text_pengumuman" class="textarea textarea-bordered h-24" required>{{ $item->text_pengumuman }}</textarea>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="form-control">
                <label class="label"><span class="label-text">Tanggal Mulai</span></label>
                <input type="date" name="valid_start" value="{{ $item->valid_start }}" class="input input-bordered" required />
            </div>
            <div class="form-control">
                <label class="label"><span class="label-text">Tanggal Berakhir</span></label>
                <input type="date" name="valid_end" value="{{ $item->valid_end }}" class="input input-bordered" required />
            </div>
        </div>
        
        <div class="modal-action">
            <button type="button" class="btn" onclick="document.getElementById('modal_edit_{{ $item->id_pengumuman }}').close()">Batal</button>
            <button type="submit" class="btn btn-success text-white">Simpan Perubahan</button>
        </div>
    </form>
  </div>
  <form method="dialog" class="modal-backdrop">
    <button>close</button>
  </form>
</dialog>

<!-- Modal Hapus -->
<dialog id="modal_hapus_{{ $item->id_pengumuman }}" class="modal">
  <div class="modal-box text-center">
    <div class="text-error mb-4 flex justify-center">
        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
    </div>
    <h3 class="font-bold text-lg">Hapus Pengumuman?</h3>
    <p class="py-4">Yakin ingin menghapus pengumuman <strong>{{ $item->id_pengumuman }}</strong>?</p>
    <div class="modal-action justify-center">
      <form method="dialog">
        <button class="btn mr-2">Batal</button>
      </form>
      <form action="{{ route('admin.pengumuman.destroy', $item->id_pengumuman) }}" method="POST">
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
