<!-- Dashboard Partial -->
<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="card bg-base-100 shadow-sm border border-base-200">
        <div class="card-body p-6 flex-row items-center justify-between">
            <div>
                <p class="text-sm text-base-content/70 font-medium">Total Pendaftaran</p>
                <p class="text-3xl font-bold mt-1">{{ $totalPendaftaran }}</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-primary/10 flex items-center justify-center text-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
        </div>
    </div>
    
    <div class="card bg-base-100 shadow-sm border border-base-200">
        <div class="card-body p-6 flex-row items-center justify-between">
            <div>
                <p class="text-sm text-base-content/70 font-medium">Paket Aktif</p>
                <p class="text-3xl font-bold mt-1">{{ $totalPaket }}</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-success/10 flex items-center justify-center text-success">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 12V8H6a2 2 0 0 1-2-2c0-1.1.9-2 2-2h12v4"/><path d="M4 6v12a2 2 0 0 0 2 2h14v-4"/><path d="M18 12a2 2 0 0 0 0 4h4v-4Z"/></svg>
            </div>
        </div>
    </div>
    
    <div class="card bg-base-100 shadow-sm border border-base-200">
        <div class="card-body p-6 flex-row items-center justify-between">
            <div>
                <p class="text-sm text-base-content/70 font-medium">Pengumuman</p>
                <p class="text-3xl font-bold mt-1">{{ $totalPengumuman }}</p>
            </div>
            <div class="w-12 h-12 rounded-xl bg-info/10 flex items-center justify-center text-info">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"/><path d="M15.54 8.46a5 5 0 0 1 0 7.07"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14"/></svg>
            </div>
        </div>
    </div>
</div>

<!-- Table & Chart Row -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    
    <!-- Table -->
    <div class="card bg-base-100 shadow-sm border border-base-200">
        <div class="card-body p-0">
            <div class="p-6 pb-2 flex justify-between items-center border-b border-base-200">
                <h3 class="card-title text-lg">Pendaftaran Terbaru</h3>
                <a href="#pendaftaran" class="text-primary text-sm font-medium hover:underline flex items-center gap-1">
                    Lihat Semua
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                </a>
            </div>
            <div class="overflow-x-auto">
                 <table class="table table-zebra w-full">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Paket Layanan</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pendaftaran->take(5) as $item)
                        <tr>
                            <td class="font-mono text-sm font-semibold text-primary">{{ $item->id_pendaftaran }}</td>
                            <td class="font-medium">{{ $item->nama }}</td>
                            <td>
                                <span class="px-2 py-1 bg-primary/10 text-primary font-semibold rounded-md border border-primary/20 text-xs whitespace-nowrap">
                                    {{ $item->paket ? $item->paket->title_paket : $item->id_paket }}
                                </span>
                            </td>
                            <td>
                                @php
                                    $statusClasses = [
                                        'pending' => 'bg-warning/10 text-warning border-warning/20',
                                        'validated' => 'bg-info/10 text-info border-info/20',
                                        'rejected' => 'bg-error/10 text-error border-error/20',
                                        'setup' => 'bg-accent/10 text-accent border-accent/20',
                                        'active' => 'bg-success/10 text-success border-success/20',
                                        'aktif' => 'bg-success/10 text-success border-success/20',
                                    ];
                                    $statusClass = $statusClasses[$item->status] ?? 'bg-base-200 text-base-content/70 border-base-300';
                                @endphp
                                <span class="px-2 py-1 font-semibold rounded-md border text-xs whitespace-nowrap {{ $statusClass }}">
                                    {{ ucfirst($item->status === 'aktif' ? 'active' : $item->status) }}
                                </span>
                            </td>
                            <td class="text-sm font-medium text-base-content/70">{{ $item->created_at->format('d M Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-6 text-base-content/50">Belum ada data pendaftaran</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Chart -->
    <div class="card bg-base-100 shadow-sm border border-base-200">
        <div class="card-body p-6">
            <h3 class="card-title text-lg mb-4">Statistik Pengguna Mendaftar (7 Hari Terakhir)</h3>
            <div class="h-64 w-full">
                <canvas id="regChart"></canvas>
            </div>
        </div>
    </div>

</div>

<!-- Quick Actions -->
<h3 class="font-bold text-lg mb-4 text-base-content">Aksi Cepat</h3>
<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <a href="#paket" class="card bg-base-100 shadow-sm border border-base-200 hover:shadow-md transition group cursor-pointer">
        <div class="card-body">
            <div class="flex items-center justify-between mb-2">
                <h4 class="text-sm text-base-content/60 font-medium">Kelola</h4>
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-base-content/40 group-hover:text-primary transition"><path d="M20 12V8H6a2 2 0 0 1-2-2c0-1.1.9-2 2-2h12v4"/><path d="M4 6v12a2 2 0 0 0 2 2h14v-4"/><path d="M18 12a2 2 0 0 0 0 4h4v-4Z"/></svg>
            </div>
            <h3 class="text-xl font-bold mb-1">Paket Internet</h3>
            <span class="text-primary text-sm font-medium flex items-center gap-1 group-hover:underline">Buka halaman <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg></span>
        </div>
    </a>
    <a href="#pengumuman" class="card bg-base-100 shadow-sm border border-base-200 hover:shadow-md transition group cursor-pointer">
        <div class="card-body">
            <div class="flex items-center justify-between mb-2">
                <h4 class="text-sm text-base-content/60 font-medium">Kelola</h4>
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-base-content/40 group-hover:text-primary transition"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"/><path d="M15.54 8.46a5 5 0 0 1 0 7.07"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14"/></svg>
            </div>
            <h3 class="text-xl font-bold mb-1">Pengumuman</h3>
            <span class="text-primary text-sm font-medium flex items-center gap-1 group-hover:underline">Buka halaman <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg></span>
        </div>
    </a>
    <a href="#promosi" class="card bg-base-100 shadow-sm border border-base-200 hover:shadow-md transition group cursor-pointer">
        <div class="card-body">
            <div class="flex items-center justify-between mb-2">
                <h4 class="text-sm text-base-content/60 font-medium">Kelola</h4>
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-base-content/40 group-hover:text-primary transition"><path d="M15 14c.2-1 .7-1.7 1.5-2.5 1-.9 1.5-2.2 1.5-3.5A6 6 0 0 0 6 8c0 1 .2 2.2 1.5 3.5.7.7 1.3 1.5 1.5 2.5"/><path d="M9 18h6"/><path d="M10 22h4"/></svg>
            </div>
            <h3 class="text-xl font-bold mb-1">Promosi</h3>
            <span class="text-primary text-sm font-medium flex items-center gap-1 group-hover:underline">Buka halaman <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg></span>
        </div>
    </a>
</div>

