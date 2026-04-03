@extends('admin.layout')
@section('title', 'Dashboard')
@section('content')
<div class="stats-grid">
    <div class="stat-card blue">
        <div class="icon"><i class="fa-solid fa-users"></i></div>
        <div class="label">Total Pendaftaran</div>
        <div class="value">{{ $stats['total_pendaftaran'] }}</div>
    </div>
    <div class="stat-card purple">
        <div class="icon"><i class="fa-solid fa-tag"></i></div>
        <div class="label">Total Promosi</div>
        <div class="value">{{ $stats['total_promosi'] }}</div>
    </div>
    <div class="stat-card green">
        <div class="icon"><i class="fa-solid fa-fire"></i></div>
        <div class="label">Promosi Aktif</div>
        <div class="value">{{ $stats['aktif_promosi'] }}</div>
    </div>
    <div class="stat-card orange">
        <div class="icon"><i class="fa-solid fa-bullhorn"></i></div>
        <div class="label">Total Pesan</div>
        <div class="value">{{ $stats['total_pesan'] }}</div>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;flex-wrap:wrap;">
    <div class="table-card">
        <div class="table-header">
            <h3><i class="fa-solid fa-users" style="color:var(--primary);margin-right:.5rem;"></i>Pendaftaran Terbaru</h3>
            <a href="{{ route('admin.pendaftaran') }}" class="btn-sm primary">Lihat Semua</a>
        </div>
        <table>
            <thead><tr><th>Nama</th><th>No. Telepon</th><th>Aksi</th></tr></thead>
            <tbody>
                @forelse(array_slice($pendaftaran, 0, 5) as $p)
                <tr>
                    <td><strong>{{ $p['nama'] }}</strong></td>
                    <td>{{ $p['no_telepon'] }}</td>
                    <td><a href="{{ route('admin.pendaftaran.show', $p['id_pendaftaran']) }}" class="btn-sm primary"><i class="fa-solid fa-eye"></i></a></td>
                </tr>
                @empty
                <tr><td colspan="3" class="empty-state"><i class="fa-solid fa-inbox"></i>Belum ada pendaftaran</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="table-card">
        <div class="table-header">
            <h3><i class="fa-solid fa-tag" style="color:var(--accent);margin-right:.5rem;"></i>Promosi Aktif</h3>
            <a href="{{ route('admin.promosi.create') }}" class="btn-sm success"><i class="fa-solid fa-plus"></i> Tambah</a>
        </div>
        <table>
            <thead><tr><th>Judul</th><th>Diskon</th><th>Status</th></tr></thead>
            <tbody>
                @forelse(array_slice($promotions, 0, 5) as $pr)
                <tr>
                    <td><strong>{{ $pr['judul_promosi'] }}</strong></td>
                    <td><span style="color:var(--warning);font-weight:700;">{{ $pr['value_promosi'] }}%</span></td>
                    <td>
                        @if($pr['visibility'])
                            <span class="badge badge-success"><i class="fa-solid fa-circle"></i> Aktif</span>
                        @else
                            <span class="badge badge-danger"><i class="fa-regular fa-circle"></i> Non-aktif</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="3" class="empty-state"><i class="fa-solid fa-tag"></i>Belum ada promosi</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
