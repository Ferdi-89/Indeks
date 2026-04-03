@extends('admin.layout')
@section('title', 'Manajemen Pesan')
@section('content')
<div class="table-card">
    <div class="table-header">
        <h3><i class="fa-solid fa-bullhorn" style="color:var(--warning);margin-right:.5rem;"></i>Daftar Pesan</h3>
        <a href="{{ route('admin.pesan.create') }}" class="btn-sm success" id="btn-tambah-pesan"><i class="fa-solid fa-plus"></i> Tambah Pesan</a>
    </div>
    <table>
        <thead>
            <tr><th>Isi Pesan</th><th>Tema</th><th>Tampilan</th><th>Status</th><th>Aksi</th></tr>
        </thead>
        <tbody>
            @forelse($messages as $m)
            <tr>
                <td><strong>{{ \Str::limit($m['pesan'], 60) }}</strong></td>
                <td><span style="font-size:.8rem;color:var(--text-muted);">{{ $m['tema'] }}</span></td>
                <td><code style="font-size:.75rem;background:rgba(255,255,255,.06);padding:.2rem .5rem;border-radius:4px;color:var(--accent);">{{ $m['type_view'] }}</code></td>
                <td>
                    @if($m['visibility'])
                        <span class="badge badge-success"><i class="fa-solid fa-circle"></i> Aktif</span>
                    @else
                        <span class="badge badge-danger"><i class="fa-regular fa-circle"></i> Disembunyikan</span>
                    @endif
                </td>
                <td>
                    <div class="action-btns">
                        <a href="{{ route('admin.pesan.edit', $m['id_pesan']) }}" class="btn-sm primary" id="btn-edit-{{ $m['id_pesan'] }}"><i class="fa-solid fa-pen"></i></a>
                        <form action="{{ route('admin.pesan.destroy', $m['id_pesan']) }}" method="POST" onsubmit="return confirm('Hapus pesan ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-sm danger"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="5"><div class="empty-state"><i class="fa-solid fa-bullhorn"></i><p>Belum ada pesan. <a href="{{ route('admin.pesan.create') }}" style="color:var(--primary);">Tambah sekarang</a></p></div></td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
