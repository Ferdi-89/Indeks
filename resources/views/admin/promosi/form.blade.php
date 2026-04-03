@extends('admin.layout')
@section('title', $promosi ? 'Edit Promosi' : 'Tambah Promosi')
@section('content')
<div style="margin-bottom:1.5rem;">
    <a href="{{ route('admin.promosi') }}" class="btn-outline-sm"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
</div>
<div class="form-card" style="max-width:700px;">
    <h3 style="font-size:1.1rem;font-weight:700;color:#fff;margin-bottom:1.75rem;">
        <i class="fa-solid fa-{{ $promosi ? 'pen' : 'plus-circle' }}" style="color:var(--accent);margin-right:.5rem;"></i>
        {{ $promosi ? 'Edit Promosi' : 'Tambah Promosi Baru' }}
    </h3>
    <form action="{{ $promosi ? route('admin.promosi.update', $promosi['id_promosi']) : route('admin.promosi.store') }}" method="POST">
        @csrf
        @if($promosi) @method('PUT') @endif

        <div class="form-group">
            <label class="form-label">Judul Promosi <span style="color:var(--danger);">*</span></label>
            <input type="text" name="judul_promosi" class="form-control" placeholder="Contoh: Promo Lebaran R-NET" value="{{ old('judul_promosi', $promosi['judul_promosi'] ?? '') }}" required>
        </div>

        <div class="form-group">
            <label class="form-label">Deskripsi Promosi <span style="color:var(--danger);">*</span></label>
            <textarea name="isi_promosi" class="form-control" placeholder="Jelaskan detail promosi...">{{ old('isi_promosi', $promosi['isi_promosi'] ?? '') }}</textarea>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Persentase Diskon (%) <span style="color:var(--danger);">*</span></label>
                <input type="number" name="value_promosi" class="form-control" placeholder="Contoh: 20" min="0" max="100" value="{{ old('value_promosi', $promosi['value_promosi'] ?? '') }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">Tema <span style="color:var(--danger);">*</span></label>
                <input type="text" name="tema" class="form-control" placeholder="Contoh: lebaran, reguler" value="{{ old('tema', $promosi['tema'] ?? '') }}" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Tanggal Mulai <span style="color:var(--danger);">*</span></label>
                <input type="date" name="start_valid" class="form-control" value="{{ old('start_valid', $promosi['start_valid'] ?? '') }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">Tanggal Berakhir <span style="color:var(--danger);">*</span></label>
                <input type="date" name="end_valid" class="form-control" value="{{ old('end_valid', $promosi['end_valid'] ?? '') }}" required>
            </div>
        </div>

        <div class="form-group">
            <label class="form-check">
                <input type="checkbox" name="visibility" {{ old('visibility', $promosi['visibility'] ?? false) ? 'checked' : '' }}>
                <label style="cursor:pointer;color:var(--text-muted);">Tampilkan di website (aktifkan promosi)</label>
            </label>
        </div>

        <div style="display:flex;gap:1rem;align-items:center;margin-top:.5rem;">
            <button type="submit" class="btn-primary-action" id="btn-simpan-promosi">
                <i class="fa-solid fa-check"></i> {{ $promosi ? 'Perbarui Promosi' : 'Simpan Promosi' }}
            </button>
            <a href="{{ route('admin.promosi') }}" class="btn-outline-sm">Batal</a>
        </div>
    </form>
</div>
@endsection
