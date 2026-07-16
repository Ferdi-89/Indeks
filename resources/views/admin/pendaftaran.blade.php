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

        {{-- Tombol WhatsApp --}}
        @php
            $phone = preg_replace('/\D/', '', $item->nomor_tlpn);
            if (str_starts_with($phone, '0')) {
                $phone = '62' . substr($phone, 1);
            }
            $pesan = "Halo, {$item->nama}! 👋\n\nKami dari tim R-NET menghubungi Anda terkait pendaftaran internet Anda.\n\n📋 *Detail Pendaftaran:*\n• ID Pendaftaran : *{$item->id_pendaftaran}*\n• Nama            : {$item->nama}\n• Paket             : {$item->id_paket}\n\nMohon ditunggu, kami akan segera memproses pendaftaran Anda. Terima kasih! 🙏";
            $waUrl = 'https://wa.me/' . $phone . '?text=' . urlencode($pesan);
        @endphp
        <div class="md:col-span-2 mt-4">
            <a href="{{ $waUrl }}" target="_blank"
               class="btn btn-success w-full gap-2 text-white">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                </svg>
                Chat WhatsApp — {{ $item->id_pendaftaran }}
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
