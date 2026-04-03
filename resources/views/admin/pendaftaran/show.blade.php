@extends('admin.layout')
@section('title', 'Detail Pendaftaran')
@section('content')
<div style="margin-bottom:1.5rem;">
    <a href="{{ route('admin.pendaftaran') }}" class="btn-outline-sm"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
</div>
<div class="form-card" style="max-width:600px;">
    <h3 style="font-size:1.1rem;font-weight:700;color:#fff;margin-bottom:1.5rem;">
        <i class="fa-solid fa-user-circle" style="color:var(--primary);margin-right:.5rem;"></i>{{ $data['nama'] ?? '-' }}
    </h3>
    @if($data)
    <table style="width:100%;border-collapse:collapse;">
        @foreach([
            ['ID Pendaftaran', $data['id_pendaftaran'] ?? '-'],
            ['Nama', $data['nama'] ?? '-'],
            ['No. Telepon', $data['no_telepon'] ?? '-'],
            ['Paket', $data['paket'] ?? '-'],
            ['Alamat', $data['alamat'] ?? '-'],
            ['Koordinat', $data['koordinat'] ?? '-'],
        ] as [$label, $val])
        <tr>
            <td style="padding:.75rem 0;color:var(--text-muted);font-size:.85rem;width:40%;border-bottom:1px solid var(--border);">{{ $label }}</td>
            <td style="padding:.75rem 0;color:#fff;font-size:.875rem;border-bottom:1px solid var(--border);font-weight:500;">{{ $val }}</td>
        </tr>
        @endforeach
    </table>
    @if(!empty($data['l_gambar']))
    <div style="margin-top:1.5rem;">
        <p style="color:var(--text-muted);font-size:.85rem;margin-bottom:.75rem;">Foto KTP:</p>
        <img src="{{ asset('storage/'.$data['l_gambar']) }}" style="max-width:100%;border-radius:10px;border:1px solid var(--border);" alt="Foto KTP">
    </div>
    @endif
    @else
    <p style="color:var(--text-muted);">Data tidak ditemukan.</p>
    @endif

    <div style="margin-top:2rem;">
        <form action="{{ route('admin.pendaftaran.destroy', $data['id_pendaftaran'] ?? '') }}" method="POST" onsubmit="return confirm('Yakin hapus data ini?')">
            @csrf @method('DELETE')
            <button type="submit" class="btn-sm danger" style="font-size:.875rem;padding:.6rem 1.2rem;"><i class="fa-solid fa-trash"></i> Hapus Data</button>
        </form>
    </div>
</div>
@endsection
