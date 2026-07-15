<!-- Server Partial -->
<div class="flex justify-between items-center mb-8">
    <div>
        <h3 class="text-2xl font-bold text-base-content">Kontrol Server</h3>
        <p class="text-sm text-base-content/70 mt-1">Kelola status dan operasional server aplikasi</p>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Maintenance Mode -->
    <div class="card bg-base-100 shadow-sm border border-base-200 hover:shadow-md transition">
        <div class="card-body">
            <div class="flex items-start gap-4">
                <div class="p-3 bg-warning/10 text-warning rounded-xl shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold">Maintenance Mode</h3>
                    <div class="mt-2 mb-3">
                        @if(app()->isDownForMaintenance())
                            <span class="badge badge-warning gap-1.5 py-2 px-3 text-xs font-bold">
                                <span class="w-1.5 h-1.5 rounded-full bg-warning animate-pulse"></span>
                                Status: AKTIF (Pemeliharaan)
                            </span>
                        @else
                            <span class="badge badge-success gap-1.5 py-2 px-3 text-xs font-bold text-white">
                                <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                                Status: TIDAK AKTIF (Online)
                            </span>
                        @endif
                    </div>
                    <p class="text-sm text-base-content/70 mb-4">Tutup akses publik ke website sementara waktu (menampilkan halaman error 503). Halaman admin, login, dan modul manajemen tetap dapat diakses sepenuhnya oleh admin.</p>
                    
                    <div class="flex flex-wrap gap-2">
                        @if(app()->isDownForMaintenance())
                            <form action="{{ route('admin.server.up') }}" method="POST" data-no-ajax>
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm text-white font-bold" onclick="return confirm('Matikan mode maintenance? Akses publik akan dibuka kembali.')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="inline-block mr-1"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 9.9-1"/></svg>
                                    Matikan Maintenance Mode (Buka Akses Publik)
                                </button>
                            </form>
                        @else
                            <form action="{{ route('admin.server.maintenance') }}" method="POST" data-no-ajax>
                                @csrf
                                <button type="submit" class="btn btn-warning btn-sm font-bold" onclick="return confirm('Aktifkan mode maintenance? Akses publik akan ditutup.')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" class="inline-block mr-1"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                                    Aktifkan Maintenance Mode
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Shutdown Server -->
    <div class="card bg-base-100 shadow-sm border border-error/30 hover:border-error transition">
        <div class="card-body">
            <div class="flex items-start gap-4">
                <div class="p-3 bg-error/10 text-error rounded-xl shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18.36 6.64a9 9 0 1 1-12.73 0"/><line x1="12" y1="2" x2="12" y2="12"/></svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-error">Shutdown Server</h3>
                    <p class="text-sm text-base-content/70 mt-1 mb-4">Matikan proses server (PHP Artisan Serve) secara paksa. Website akan mati total dan membutuhkan akses terminal untuk dihidupkan kembali.</p>
                    
                    <form action="{{ route('admin.server.shutdown') }}" method="POST" data-no-ajax>
                        @csrf
                        <button type="submit" class="btn btn-error btn-sm text-white" onclick="return confirm('PERINGATAN: Mematikan server akan membuat website offline sepenuhnya. Lanjutkan?')">Shutdown Sekarang</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
