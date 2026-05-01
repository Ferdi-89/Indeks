@extends('admin.layouts.main')

@section('title', 'Data Pendaftaran')

@section('content')
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
                    <td>{{ $item->created_at->format('d M Y') }}</td>
                    <td>
                        <div class="flex justify-center gap-2">
                            <!-- Detail Button -->
                            <button onclick="document.getElementById('modal_detail_{{ $item->id_pendaftaran }}').showModal()" class="btn btn-sm btn-square btn-ghost text-info" title="Detail">
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
    <div class="p-4 border-t border-base-200">
        {{ $pendaftaran->links() }}
    </div>
</div>
@endsection

@section('modals')
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
            <!-- Asumsi path_gambar adalah URL S3 dari Supabase -->
            <img src="{{ Str::startsWith($item->path_gambar, 'http') ? $item->path_gambar : env('SUPABASE_STORAGE_URL') . '/' . $item->path_gambar }}" alt="Foto Rumah" class="w-full h-full object-cover">
        </div>
        @endif
        
        <div><span class="text-base-content/70 text-sm block">Nama</span><span class="font-medium">{{ $item->nama }}</span></div>
        <div><span class="text-base-content/70 text-sm block">Email</span><span class="font-medium">{{ $item->email }}</span></div>
        <div><span class="text-base-content/70 text-sm block">Telepon</span><span class="font-medium">{{ $item->nomor_tlpn }}</span></div>
        <div><span class="text-base-content/70 text-sm block">ID Paket</span><span class="badge badge-info">{{ $item->id_paket }}</span></div>
        <div><span class="text-base-content/70 text-sm block">Tanggal Daftar</span><span class="font-medium">{{ $item->created_at->format('d M Y H:i') }}</span></div>
        
        <div class="md:col-span-2"><span class="text-base-content/70 text-sm block">Alamat</span><span class="font-medium">{{ $item->alamat }}</span></div>
        
        <div class="md:col-span-2 bg-info/10 p-4 rounded-xl mt-2">
            <span class="text-info font-bold text-sm block">Titik Koordinat</span>
            <span class="font-mono text-sm">{{ $item->latitude }}, {{ $item->longtitude }}</span>
            <a href="https://maps.google.com/?q={{ $item->latitude }},{{ $item->longtitude }}" target="_blank" class="text-primary text-sm hover:underline block mt-1">Buka di Google Maps →</a>
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
      <form action="#" method="POST">
        @csrf
        @method('DELETE')
        <button type="button" class="btn btn-error" onclick="alert('Route DELETE belum diatur')">Hapus</button>
      </form>
    </div>
  </div>
  <form method="dialog" class="modal-backdrop">
    <button>close</button>
  </form>
</dialog>
@endforeach
@endsection
