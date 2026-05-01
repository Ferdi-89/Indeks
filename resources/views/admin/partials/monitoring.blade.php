<!-- Monitoring Partial -->
<div class="flex justify-between items-center mb-6">
    <div>
        <h3 class="text-2xl font-bold text-base-content">Monitoring Sistem</h3>
        <p class="text-sm text-base-content/70 mt-1">Pantau penggunaan resource Laravel & Supabase secara real-time</p>
    </div>
    <a href="{{ route('admin.index') }}#monitoring" class="btn btn-outline btn-sm gap-2" onclick="location.reload()">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/></svg>
        Refresh Data
    </a>
</div>

<!-- Server & Laravel Info Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
    <!-- PHP Memory -->
    <div class="card bg-base-100 shadow-sm border border-base-200">
        <div class="card-body p-5">
            <div class="flex items-center justify-between mb-3">
                <span class="text-sm font-medium text-base-content/60">PHP Memory</span>
                <div class="w-9 h-9 rounded-lg bg-violet-500/10 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-violet-500"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M3 9h18"/><path d="M9 21V9"/></svg>
                </div>
            </div>
            <p class="text-2xl font-bold">{{ $monitoring['php_memory'] ?? '-' }}</p>
            <p class="text-xs text-base-content/50 mt-1">Peak: {{ $monitoring['php_memory_peak'] ?? '-' }}</p>
        </div>
    </div>

    <!-- PHP Version -->
    <div class="card bg-base-100 shadow-sm border border-base-200">
        <div class="card-body p-5">
            <div class="flex items-center justify-between mb-3">
                <span class="text-sm font-medium text-base-content/60">PHP Version</span>
                <div class="w-9 h-9 rounded-lg bg-blue-500/10 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-blue-500"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
                </div>
            </div>
            <p class="text-2xl font-bold">{{ $monitoring['php_version'] ?? '-' }}</p>
            <p class="text-xs text-base-content/50 mt-1">Laravel {{ $monitoring['laravel_version'] ?? '-' }}</p>
        </div>
    </div>

    <!-- Server Uptime -->
    <div class="card bg-base-100 shadow-sm border border-base-200">
        <div class="card-body p-5">
            <div class="flex items-center justify-between mb-3">
                <span class="text-sm font-medium text-base-content/60">Server OS</span>
                <div class="w-9 h-9 rounded-lg bg-emerald-500/10 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-emerald-500"><rect width="20" height="14" x="2" y="3" rx="2"/><line x1="8" x2="16" y1="21" y2="21"/><line x1="12" x2="12" y1="17" y2="21"/></svg>
                </div>
            </div>
            <p class="text-lg font-bold truncate" title="{{ $monitoring['server_os'] ?? '-' }}">{{ Str::limit($monitoring['server_os'] ?? '-', 20) }}</p>
            <p class="text-xs text-base-content/50 mt-1">{{ $monitoring['server_software'] ?? '-' }}</p>
        </div>
    </div>

    <!-- Response Time -->
    <div class="card bg-base-100 shadow-sm border border-base-200">
        <div class="card-body p-5">
            <div class="flex items-center justify-between mb-3">
                <span class="text-sm font-medium text-base-content/60">Load Time</span>
                <div class="w-9 h-9 rounded-lg bg-amber-500/10 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-amber-500"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
            </div>
            <p class="text-2xl font-bold">{{ $monitoring['load_time'] ?? '-' }}</p>
            <p class="text-xs text-base-content/50 mt-1">Waktu render halaman ini</p>
        </div>
    </div>
</div>

<!-- Database Section -->
<h4 class="font-bold text-lg mb-4 text-base-content flex items-center gap-2">
    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-primary"><ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M3 5V19A9 3 0 0 0 21 19V5"/><path d="M3 12A9 3 0 0 0 21 12"/></svg>
    Database (Supabase PostgreSQL)
</h4>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
    <!-- DB Size -->
    <div class="card bg-base-100 shadow-sm border border-base-200">
        <div class="card-body p-5">
            <span class="text-sm font-medium text-base-content/60 mb-2 block">Ukuran Database</span>
            <div class="flex items-end gap-2">
                <span class="text-3xl font-bold text-primary">{{ $monitoring['db_size'] ?? '-' }}</span>
            </div>
            <div class="mt-3">
                <progress class="progress progress-primary w-full" value="{{ $monitoring['db_size_pct'] ?? 0 }}" max="100"></progress>
                <span class="text-xs text-base-content/50">dari 500 MB (Supabase Free Tier)</span>
            </div>
        </div>
    </div>

    <!-- Active Connections -->
    <div class="card bg-base-100 shadow-sm border border-base-200">
        <div class="card-body p-5">
            <span class="text-sm font-medium text-base-content/60 mb-2 block">Koneksi Aktif</span>
            <div class="flex items-end gap-2">
                <span class="text-3xl font-bold text-info">{{ $monitoring['db_connections'] ?? 0 }}</span>
                <span class="text-sm text-base-content/50 mb-1">/ {{ $monitoring['db_max_connections'] ?? '-' }}</span>
            </div>
            <div class="mt-3">
                <progress class="progress progress-info w-full" value="{{ $monitoring['db_connections'] ?? 0 }}" max="{{ $monitoring['db_max_connections'] ?? 100 }}"></progress>
                <span class="text-xs text-base-content/50">PostgreSQL connections</span>
            </div>
        </div>
    </div>

    <!-- Total Queries -->
    <div class="card bg-base-100 shadow-sm border border-base-200">
        <div class="card-body p-5">
            <span class="text-sm font-medium text-base-content/60 mb-2 block">Query pada Request Ini</span>
            <div class="flex items-end gap-2">
                <span class="text-3xl font-bold text-warning">{{ $monitoring['query_count'] ?? 0 }}</span>
                <span class="text-sm text-base-content/50 mb-1">queries</span>
            </div>
            <p class="text-xs text-base-content/50 mt-3">Total waktu: {{ $monitoring['query_time'] ?? '0' }} ms</p>
        </div>
    </div>
</div>

<!-- Table Stats -->
<div class="card bg-base-100 shadow-sm border border-base-200 mb-8">
    <div class="card-body p-0">
        <div class="p-6 pb-2 border-b border-base-200">
            <h4 class="card-title text-lg">Statistik per Tabel</h4>
        </div>
        <div class="overflow-x-auto">
            <table class="table table-zebra w-full">
                <thead>
                    <tr>
                        <th>Nama Tabel</th>
                        <th>Jumlah Baris</th>
                        <th>Ukuran Tabel</th>
                        <th>Ukuran Index</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($monitoring['table_stats'] ?? [] as $tbl)
                    <tr>
                        <td class="font-mono text-sm font-medium">{{ $tbl->table_name }}</td>
                        <td><span class="badge badge-ghost badge-sm">{{ number_format($tbl->row_count) }}</span></td>
                        <td>{{ $tbl->table_size }}</td>
                        <td>{{ $tbl->index_size }}</td>
                        <td class="font-medium">{{ $tbl->total_size }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-6 text-base-content/50">Tidak dapat mengambil data tabel.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Storage Section -->
<h4 class="font-bold text-lg mb-4 text-base-content flex items-center gap-2">
    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-secondary"><path d="M4 20h16a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.93a2 2 0 0 1-1.66-.9l-.82-1.2A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13c0 1.1.9 2 2 2Z"/></svg>
    Supabase Storage (S3 Bucket)
</h4>
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
    <!-- Bucket Info -->
    <div class="card bg-base-100 shadow-sm border border-base-200">
        <div class="card-body p-5">
            <span class="text-sm font-medium text-base-content/60 mb-2 block">Bucket</span>
            <p class="text-xl font-bold text-secondary">{{ env('S3_BUCKET', '-') }}</p>
            <p class="text-xs text-base-content/50 mt-2">Endpoint: {{ Str::limit(env('S3_ENDPOINT', '-'), 40) }}</p>
        </div>
    </div>

    <!-- File Count -->
    <div class="card bg-base-100 shadow-sm border border-base-200">
        <div class="card-body p-5">
            <span class="text-sm font-medium text-base-content/60 mb-2 block">Jumlah File (Pendaftaran)</span>
            <div class="flex items-end gap-2">
                <span class="text-3xl font-bold text-secondary">{{ $monitoring['storage_file_count'] ?? '-' }}</span>
                <span class="text-sm text-base-content/50 mb-1">files</span>
            </div>
            <p class="text-xs text-base-content/50 mt-3">Di folder <code class="bg-base-200 px-1 rounded">pendaftaran/</code></p>
        </div>
    </div>

    <!-- Storage Status -->
    <div class="card bg-base-100 shadow-sm border border-base-200">
        <div class="card-body p-5">
            <span class="text-sm font-medium text-base-content/60 mb-2 block">Status Koneksi S3</span>
            @if($monitoring['storage_connected'] ?? false)
            <div class="flex items-center gap-2">
                <div class="w-3 h-3 rounded-full bg-success animate-pulse"></div>
                <span class="text-lg font-bold text-success">Terhubung</span>
            </div>
            @else
            <div class="flex items-center gap-2">
                <div class="w-3 h-3 rounded-full bg-error"></div>
                <span class="text-lg font-bold text-error">Tidak Terhubung</span>
            </div>
            @endif
            <p class="text-xs text-base-content/50 mt-3">Region: {{ env('S3_REGION', '-') }}</p>
        </div>
    </div>
</div>

<!-- Laravel Config Section -->
<h4 class="font-bold text-lg mb-4 text-base-content flex items-center gap-2">
    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="text-error"><path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/><circle cx="12" cy="12" r="3"/></svg>
    Konfigurasi Laravel
</h4>
<div class="card bg-base-100 shadow-sm border border-base-200 mb-8">
    <div class="card-body p-0">
        <div class="overflow-x-auto">
            <table class="table w-full">
                <tbody>
                    <tr><td class="font-medium w-1/3">Environment</td><td><span class="badge {{ config('app.env') == 'production' ? 'badge-success' : 'badge-warning' }}">{{ config('app.env') }}</span></td></tr>
                    <tr><td class="font-medium">Debug Mode</td><td><span class="badge {{ config('app.debug') ? 'badge-error' : 'badge-success' }}">{{ config('app.debug') ? 'ON' : 'OFF' }}</span></td></tr>
                    <tr><td class="font-medium">App URL</td><td class="font-mono text-sm">{{ config('app.url') }}</td></tr>
                    <tr><td class="font-medium">Database Driver</td><td><span class="badge badge-info">{{ config('database.default') }}</span></td></tr>
                    <tr><td class="font-medium">DB Host</td><td class="font-mono text-sm">{{ Str::limit(config('database.connections.' . config('database.default') . '.host'), 50) }}</td></tr>
                    <tr><td class="font-medium">Cache Driver</td><td><span class="badge badge-ghost">{{ config('cache.default') }}</span></td></tr>
                    <tr><td class="font-medium">Session Driver</td><td><span class="badge badge-ghost">{{ config('session.driver') }}</span></td></tr>
                    <tr><td class="font-medium">Queue Driver</td><td><span class="badge badge-ghost">{{ config('queue.default') }}</span></td></tr>
                    <tr><td class="font-medium">Filesystem Default</td><td><span class="badge badge-ghost">{{ config('filesystems.default') }}</span></td></tr>
                    <tr><td class="font-medium">Timezone</td><td>{{ config('app.timezone') }}</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
