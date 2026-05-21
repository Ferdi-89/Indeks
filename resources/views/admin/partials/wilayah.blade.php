<!-- Wilayah / Area Layanan Partial -->
<div class="flex justify-between items-center mb-6">
    <div>
        <h3 class="text-2xl font-bold text-base-content">Wilayah Layanan</h3>
        <p class="text-sm text-base-content/70 mt-1">Kelola area layanan operasional perusahaan</p>
    </div>
    <button onclick="document.getElementById('modal_tambah_area').showModal()" class="btn btn-primary">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Tambah Area
    </button>
</div>

<div class="bg-base-100 rounded-xl shadow-sm border border-base-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="table table-zebra w-full">
            <thead>
                <tr class="bg-base-200 text-base-content">
                    <th>ID</th>
                    <th>Nama Wilayah / Area</th>
                    <th>Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($areaLayanan as $area)
                <tr>
                    <td class="font-mono text-sm">{{ $area->id }}</td>
                    <td class="font-medium">{{ $area->nama_area }}</td>
                    <td>
                        <span class="badge {{ $area->is_active ? 'badge-success' : 'badge-error' }} badge-sm">
                            {{ $area->is_active ? 'Aktif' : 'Tidak Aktif' }}
                        </span>
                    </td>
                    <td>
                        <div class="flex justify-center gap-2">
                            <!-- Toggle Hide Button -->
                            <form action="{{ route('admin.area.toggle_hide', $area->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-square btn-ghost {{ $area->is_active ? 'text-success' : 'text-base-content/50' }}" title="{{ $area->is_active ? 'Sembunyikan' : 'Tampilkan' }}">
                                    @if($area->is_active)
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
                                    @endif
                                </button>
                            </form>
                            <!-- Edit Button -->
                            <button onclick="document.getElementById('modal_edit_area_{{ $area->id }}').showModal()" class="btn btn-sm btn-square btn-ghost text-warning" title="Edit">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                            </button>
                            <!-- Delete Button -->
                            <form action="{{ route('admin.area.destroy', $area->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-square btn-ghost text-error" onclick="return confirm('Hapus area {{ $area->nama_area }}?')" title="Hapus">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-8 text-base-content/50">Belum ada wilayah layanan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Tambah Area Layanan -->
<dialog id="modal_tambah_area" class="modal">
    <div class="modal-box">
        <h3 class="font-bold text-lg mb-4">Tambah Wilayah Layanan</h3>
        <form action="{{ route('admin.area.store') }}" method="POST">
            @csrf
            <div class="form-control">
                <label class="label"><span class="label-text font-medium">Nama Area / Wilayah</span></label>
                <input type="text" name="nama_area" class="input input-bordered w-full" placeholder="cth: Kel. Cikaret, Kec. Bogor Selatan" required autofocus>
            </div>
            <div class="modal-action">
                <form method="dialog"><button class="btn btn-ghost">Batal</button></form>
                <button type="submit" class="btn btn-primary">Tambah Area</button>
            </div>
        </form>
    </div>
    <form method="dialog" class="modal-backdrop"><button>close</button></form>
</dialog>

@foreach($areaLayanan as $area)
<!-- Modal Edit Area Layanan -->
<dialog id="modal_edit_area_{{ $area->id }}" class="modal">
    <div class="modal-box">
        <h3 class="font-bold text-lg mb-4">Edit Wilayah Layanan</h3>
        <form action="{{ route('admin.area.update', $area->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-control">
                <label class="label"><span class="label-text font-medium">Nama Area / Wilayah</span></label>
                <input type="text" name="nama_area" class="input input-bordered w-full" value="{{ $area->nama_area }}" required>
            </div>
            <input type="hidden" name="is_active" value="{{ $area->is_active ? 1 : 0 }}">
            <div class="modal-action">
                <button type="button" onclick="document.getElementById('modal_edit_area_{{ $area->id }}').close()" class="btn btn-ghost">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
    <form method="dialog" class="modal-backdrop"><button>close</button></form>
</dialog>
@endforeach
