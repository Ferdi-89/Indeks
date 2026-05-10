<!-- Paket Partial -->
<div class="flex justify-between items-center mb-8">
    <div>
        <h3 class="text-2xl font-bold text-base-content">Paket Internet</h3>
        <p class="text-sm text-base-content/70 mt-1">Kelola paket internet yang tersedia dari database</p>
    </div>
    <button onclick="document.getElementById('modal_tambah_paket').showModal()" class="btn btn-primary">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Tambah Paket
    </button>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @forelse($paket as $item)
    <div class="card bg-base-100 shadow-sm border border-base-200 hover:shadow-md transition-shadow">
        <div class="card-body">
            <div class="w-12 h-12 rounded-lg bg-primary/10 flex items-center justify-center mb-2">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-primary"><path d="M12 20h.01"/><path d="M2 8.82a15 15 0 0 1 20 0"/><path d="M5 12.859a10 10 0 0 1 14 0"/><path d="M8.5 16.429a5 5 0 0 1 7 0"/></svg>
            </div>
            <h2 class="card-title text-2xl">{{ $item->title_paket }}</h2>
            <p class="text-sm text-base-content/50 mb-2">ID: {{ $item->id_paket }}</p>
            
            <div class="my-4">
                <span class="text-3xl font-bold text-base-content">Rp {{ number_format($item->harga_paket, 0, ',', '.') }}</span>
                <span class="text-sm text-base-content/50">/bulan</span>
            </div>

            <div class="card-actions justify-end mt-4 border-t border-base-200 pt-4">
                <button onclick="document.getElementById('modal_edit_{{ $item->id_paket }}').showModal()" class="btn btn-sm btn-outline btn-success flex-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    Edit
                </button>
                <button onclick="document.getElementById('modal_hapus_{{ $item->id_paket }}').showModal()" class="btn btn-sm btn-outline btn-error flex-1">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                    Hapus
                </button>
            </div>
        </div>
    </div>
    @empty
    <div class="col-span-full py-12 text-center text-base-content/50 bg-base-100 rounded-xl border border-base-200">
        Belum ada data paket internet di database.
    </div>
    @endforelse
</div>

<!-- Modal Tambah -->
<dialog id="modal_tambah_paket" class="modal">
  <div class="modal-box">
    <h3 class="font-bold text-lg mb-4">Tambah Paket Baru</h3>
    <form action="{{ route('admin.paket.store') }}" method="POST">
        @csrf
        <div class="form-control mb-4">
            <label class="label"><span class="label-text">ID Paket</span></label>
            <input type="text" name="id_paket" class="input input-bordered w-full" placeholder="Contoh: p004" required />
        </div>
        <div class="form-control mb-4">
            <label class="label"><span class="label-text">Nama Paket</span></label>
            <input type="text" name="title_paket" class="input input-bordered w-full" placeholder="Contoh: Super Cepat" required />
        </div>
        <div class="form-control mb-4">
            <label class="label"><span class="label-text">Harga Paket (Rp)</span></label>
            <input type="number" name="harga_paket" class="input input-bordered w-full" placeholder="150000" required />
        </div>
        
        <div class="modal-action">
            <button type="button" class="btn" onclick="document.getElementById('modal_tambah_paket').close()">Batal</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </form>
  </div>
  <form method="dialog" class="modal-backdrop">
    <button>close</button>
  </form>
</dialog>

@foreach($paket as $item)
<!-- Modal Edit -->
<dialog id="modal_edit_{{ $item->id_paket }}" class="modal">
  <div class="modal-box">
    <h3 class="font-bold text-lg mb-4">Edit Paket: {{ $item->title_paket }}</h3>
    <form action="{{ route('admin.paket.update', $item->id_paket) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-control mb-4">
            <label class="label"><span class="label-text">Nama Paket</span></label>
            <input type="text" name="title_paket" value="{{ $item->title_paket }}" class="input input-bordered w-full" required />
        </div>
        <div class="form-control mb-4">
            <label class="label"><span class="label-text">Harga Paket (Rp)</span></label>
            <input type="number" name="harga_paket" value="{{ $item->harga_paket }}" class="input input-bordered w-full" required />
        </div>
        
        <div class="modal-action">
            <button type="button" class="btn" onclick="document.getElementById('modal_edit_{{ $item->id_paket }}').close()">Batal</button>
            <button type="submit" class="btn btn-success text-white">Simpan Perubahan</button>
        </div>
    </form>
  </div>
  <form method="dialog" class="modal-backdrop">
    <button>close</button>
  </form>
</dialog>

<!-- Modal Hapus -->
<dialog id="modal_hapus_{{ $item->id_paket }}" class="modal">
  <div class="modal-box text-center">
    <div class="text-error mb-4 flex justify-center">
        <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
    </div>
    <h3 class="font-bold text-lg">Hapus Paket?</h3>
    <p class="py-4">Yakin ingin menghapus paket <strong>{{ $item->title_paket }}</strong>?</p>
    <div class="modal-action justify-center">
      <form method="dialog">
        <button class="btn mr-2">Batal</button>
      </form>
      <form action="{{ route('admin.paket.destroy', $item->id_paket) }}" method="POST">
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
