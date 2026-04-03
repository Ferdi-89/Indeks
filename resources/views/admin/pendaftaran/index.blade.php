@extends('admin.layout')
@section('title', 'Data Pendaftaran')
@section('content')
<div class="table-card">
    <div class="table-header">
        <h3><i class="fa-solid fa-users" style="color:var(--primary);margin-right:.5rem;"></i>Semua Pendaftaran</h3>
    </div>
    <table>
        <thead>
            <tr>
                <th>ID</th><th>Nama</th><th>No. Telepon</th><th>Alamat</th><th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pendaftaran as $p)
            @php $p = is_array($p) ? $p : []; @endphp
            <tr>
                <td><code style="font-size:.75rem;color:var(--text-muted);">{{ $p['id_pendaftaran'] ?? '-' }}</code></td>
                <td><strong>{{ $p['nama'] ?? '-' }}</strong></td>
                <td>{{ $p['no_telepon'] ?? '-' }}</td>
                <td>{{ \Str::limit($p['alamat'] ?? '-', 40) }}</td>
                <td>
                    <div class="action-btns">
                        <a href="{{ route('admin.pendaftaran.show', $p['id_pendaftaran'] ?? '0') }}" class="btn-sm primary" id="btn-detail-{{ $p['id_pendaftaran'] ?? '0' }}"><i class="fa-solid fa-eye"></i> Detail</a>
                        <form action="{{ route('admin.pendaftaran.destroy', $p['id_pendaftaran'] ?? '0') }}" method="POST" onsubmit="return confirm('Yakin hapus data ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn-sm danger"><i class="fa-solid fa-trash"></i></button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="6"><div class="empty-state"><i class="fa-solid fa-inbox"></i><p>Belum ada data pendaftaran</p></div></td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
