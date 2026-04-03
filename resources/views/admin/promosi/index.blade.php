@extends('admin.layout')
@section('title', 'Manajemen Promosi')
@section('content')
<div class="table-card">
    <div class="table-header">
        <h3><i class="fa-solid fa-tag" style="color:var(--accent);margin-right:.5rem;"></i>Daftar Promosi</h3>
        <a href="{{ route('admin.promosi.create') }}" class="btn-sm success" id="btn-tambah-promosi"><i class="fa-solid fa-plus"></i> Tambah Promosi</a>
    </div>
    <table>
        <thead>
            <tr><th>Judul</th><th>Diskon</th><th>Tema</th><th>Berlaku</th><th>Status</th><th>Aksi</th></tr>
        </thead>
        <tbody>
            @forelse($promotions as $p)
            <tr>
                <td><strong>{{ $p['judul_promosi'] }}</strong><p style="font-size:.78rem;color:var(--text-muted);margin-top:.2rem;">{{ \Str::limit($p['isi_promosi'], 50) }}</p></td>
                <td><span style="font-size:1.1rem;font-weight:800;color:var(--warning);">{{ $p['value_promosi'] }}%</span></td>
                <td><span style="font-size:.8rem;color:var(--text-muted);">{{ $p['tema'] }}</span></td>
                <td style="font-size:.8rem;">{{ $p['start_valid'] }}<br><span style="color:var(--text-muted);">s/d {{ $p['end_valid'] }}</span></td>
                <td>
                    @if($p['visibility'])
                        <span class="badge badge-success"><i class="fa-solid fa-circle"></i> Aktif</span>
                    @else
                        <span class="badge badge-danger"><i class="fa-regular fa-circle"></i> Non-aktif</span>
                    @endif
                </td>
                <td>
                    <div class="action-btns">
                        <a href="{{ route('admin.promosi.edit', $p['id_promosi']) }}" class="btn-sm primary" id="btn-edit-{{ $p['id_promosi'] }}"><i class="fa-solid fa-pen"></i></a>
                        <form action="{{ route('admin.promosi.destroy', $p['id_promosi']) }}" method="POST" onsubmit="return confirm('Hapus promosi ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-sm danger"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="6"><div class="empty-state"><i class="fa-solid fa-tag"></i><p>Belum ada promosi. <a href="{{ route('admin.promosi.create') }}" style="color:var(--primary);">Tambah sekarang</a></p></div></td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
