@extends('admin.layout')
@section('title', $pesan ? 'Edit Pesan' : 'Tambah Pesan')
@section('content')
<div style="margin-bottom:1.5rem;">
    <a href="{{ route('admin.pesan') }}" class="btn-outline-sm"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
</div>
<div class="form-card" style="max-width:700px;">
    <h3 style="font-size:1.1rem;font-weight:700;color:#fff;margin-bottom:1.75rem;">
        <i class="fa-solid fa-{{ $pesan ? 'pen' : 'plus-circle' }}" style="color:var(--warning);margin-right:.5rem;"></i>
        {{ $pesan ? 'Edit Pesan' : 'Tambah Pesan Baru' }}
    </h3>
    <form action="{{ $pesan ? route('admin.pesan.update', $pesan['id_pesan']) : route('admin.pesan.store') }}" method="POST">
        @csrf
        @if($pesan) @method('PUT') @endif

        <div class="form-group">
            <label class="form-label">Isi Pesan <span style="color:var(--danger);">*</span></label>
            <textarea name="pesan" class="form-control" placeholder="Tulis isi pesan atau pengumuman..." required>{{ old('pesan', $pesan['pesan'] ?? '') }}</textarea>
            <p style="font-size:.78rem;color:#475569;margin-top:.35rem;">Pesan ini akan tampil di halaman utama website jika diaktifkan.</p>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Tema <span style="color:var(--danger);">*</span></label>
                <input type="text" name="tema" class="form-control"
                    placeholder="Contoh: info, promo, gangguan"
                    value="{{ old('tema', $pesan['tema'] ?? '') }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">Tipe Tampilan <span style="color:var(--danger);">*</span></label>
                <select name="type_view" class="form-control" required>
                    @php $selected = old('type_view', $pesan['type_view'] ?? 'info'); @endphp
                    <option value="info"      {{ $selected === 'info'      ? 'selected' : '' }}>Info (Biru)</option>
                    <option value="warning"   {{ $selected === 'warning'   ? 'selected' : '' }}>Peringatan (Kuning)</option>
                    <option value="success"   {{ $selected === 'success'   ? 'selected' : '' }}>Sukses (Hijau)</option>
                    <option value="danger"    {{ $selected === 'danger'    ? 'selected' : '' }}>Kritis (Merah)</option>
                    <option value="promo"     {{ $selected === 'promo'     ? 'selected' : '' }}>Promosi (Ungu)</option>
                    <option value="pengumuman"{{ $selected === 'pengumuman'? 'selected' : '' }}>Pengumuman</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="form-check">
                <input type="checkbox" name="visibility"
                    {{ old('visibility', $pesan['visibility'] ?? false) ? 'checked' : '' }}>
                <label style="cursor:pointer;color:var(--text-muted);">Tampilkan di website (aktifkan pesan)</label>
            </label>
        </div>

        <div style="display:flex;gap:1rem;align-items:center;margin-top:.5rem;">
            <button type="submit" class="btn-primary-action" id="btn-simpan-pesan">
                <i class="fa-solid fa-check"></i> {{ $pesan ? 'Perbarui Pesan' : 'Simpan Pesan' }}
            </button>
            <a href="{{ route('admin.pesan') }}" class="btn-outline-sm">Batal</a>
        </div>
    </form>
</div>
@endsection
