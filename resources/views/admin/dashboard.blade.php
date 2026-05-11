@extends('admin.layouts.main')

@section('title', 'Dasbor')

@section('content')
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
                <a href="{{ route('admin.pendaftaran') }}" class="text-primary text-sm font-medium hover:underline flex items-center gap-1">
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
                            <th>Paket</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pendaftaran as $item)
                        <tr>
                            <td class="font-mono text-sm">{{ $item->id_pendaftaran }}</td>
                            <td class="font-medium">{{ $item->nama }}</td>
                            <td><span class="badge badge-info badge-sm">{{ $item->id_paket }}</span></td>
                            <td class="text-sm">{{ $item->created_at->format('d M Y') }}</td>
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
            <h3 class="card-title text-lg mb-4">Statistik (Dummy)</h3>
            <div class="h-64 w-full">
                <canvas id="regChart"></canvas>
            </div>
        </div>
    </div>

</div>

<!-- Quick Actions -->
<h3 class="font-bold text-lg mb-4 text-base-content">Aksi Cepat</h3>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <a href="{{ route('admin.paket') }}" class="card bg-base-100 shadow-sm border border-base-200 hover:shadow-md transition group cursor-pointer">
        <div class="card-body">
            <div class="flex items-center justify-between mb-2">
                <h4 class="text-sm text-base-content/60 font-medium">Kelola</h4>
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-base-content/40 group-hover:text-primary transition"><path d="M20 12V8H6a2 2 0 0 1-2-2c0-1.1.9-2 2-2h12v4"/><path d="M4 6v12a2 2 0 0 0 2 2h14v-4"/><path d="M18 12a2 2 0 0 0 0 4h4v-4Z"/></svg>
            </div>
            <h3 class="text-xl font-bold mb-1">Paket Internet</h3>
            <span class="text-primary text-sm font-medium flex items-center gap-1 group-hover:underline">Buka halaman <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg></span>
        </div>
    </a>
    <a href="{{ route('admin.pengumuman') }}" class="card bg-base-100 shadow-sm border border-base-200 hover:shadow-md transition group cursor-pointer">
        <div class="card-body">
            <div class="flex items-center justify-between mb-2">
                <h4 class="text-sm text-base-content/60 font-medium">Kelola</h4>
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-base-content/40 group-hover:text-primary transition"><polygon points="11 5 6 9 2 9 2 15 6 15 11 19 11 5"/><path d="M15.54 8.46a5 5 0 0 1 0 7.07"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14"/></svg>
            </div>
            <h3 class="text-xl font-bold mb-1">Pengumuman</h3>
            <span class="text-primary text-sm font-medium flex items-center gap-1 group-hover:underline">Buka halaman <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg></span>
        </div>
    </a>
    <a href="{{ route('admin.promosi') }}" class="card bg-base-100 shadow-sm border border-base-200 hover:shadow-md transition group cursor-pointer">
        <div class="card-body">
            <div class="flex items-center justify-between mb-2">
                <h4 class="text-sm text-base-content/60 font-medium">Kelola</h4>
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-base-content/40 group-hover:text-primary transition"><path d="M15 14c.2-1 .7-1.7 1.5-2.5 1-.9 1.5-2.2 1.5-3.5A6 6 0 0 0 6 8c0 1 .2 2.2 1.5 3.5.7.7 1.3 1.5 1.5 2.5"/><path d="M9 18h6"/><path d="M10 22h4"/></svg>
            </div>
            <h3 class="text-xl font-bold mb-1">Promosi</h3>
            <span class="text-primary text-sm font-medium flex items-center gap-1 group-hover:underline">Buka halaman <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg></span>
        </div>
    </a>
    <a href="#server" data-tab="server" class="admin-nav-link card bg-base-100 shadow-sm border border-base-200 hover:shadow-md transition group cursor-pointer">
        <div class="card-body">
            <div class="flex items-center justify-between mb-2">
                <h4 class="text-sm text-base-content/60 font-medium">Sistem</h4>
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-base-content/40 group-hover:text-error transition"><rect x="2" y="2" width="20" height="8" rx="2" ry="2"/><rect x="2" y="14" width="20" height="8" rx="2" ry="2"/><line x1="6" y1="6" x2="6.01" y2="6"/><line x1="6" y1="18" x2="6.01" y2="18"/></svg>
            </div>
            <h3 class="text-xl font-bold mb-1">Kontrol Server</h3>
            <span class="text-error text-sm font-medium flex items-center gap-1 group-hover:underline">Buka halaman <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg></span>
        </div>
    </a>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener("turbo:load", function() {
    const canvas = document.getElementById('regChart');
    if (!canvas) return; // Keluar jika bukan di halaman dashboard
    
    // Hancurkan chart lama jika ada (mencegah memory leak)
    if (window.regChartInstance) {
        window.regChartInstance.destroy();
    }

    const ctx = canvas.getContext('2d');

    // Gradient fill for the chart
    const gradient = ctx.createLinearGradient(0, 0, 0, 300);
    gradient.addColorStop(0, 'rgba(37, 99, 235, 0.2)');
    gradient.addColorStop(1, 'rgba(37, 99, 235, 0.0)');

    window.regChartInstance = new Chart(ctx, {
      type: 'line',
      data: {
        labels: ['23 Apr', '24 Apr', '25 Apr', '26 Apr', '27 Apr', '28 Apr', '29 Apr'],
        datasets: [{
          label: 'Pendaftaran',
          data: [4, 7, 5, 9, 12, 8, 14],
          borderColor: '#2563eb',
          backgroundColor: gradient,
          borderWidth: 3,
          pointBackgroundColor: '#2563eb',
          pointBorderColor: '#ffffff',
          pointBorderWidth: 2,
          pointRadius: 5,
          pointHoverRadius: 7,
          fill: true,
          tension: 0.4
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: { display: false }
        },
        scales: {
          y: {
            beginAtZero: true,
            grid: {
              color: '#f1f5f9',
              drawBorder: false
            }
          },
          x: {
            grid: {
              display: false
            }
          }
        },
        interaction: {
          intersect: false,
          mode: 'index'
        }
      }
    });
});
</script>
@endsection
