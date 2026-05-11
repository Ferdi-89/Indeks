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
                    <p class="text-sm text-base-content/70 mt-1 mb-4">Tutup akses publik ke website sementara waktu (menampilkan halaman error 503). Admin masih bisa masuk menggunakan URL rahasia <strong>/rnet-admin</strong>.</p>
                    
                    <div class="flex flex-wrap gap-2">
                        <form action="{{ route('admin.server.maintenance') }}" method="POST" data-no-ajax>
                            @csrf
                            <button type="submit" class="btn btn-warning btn-sm" onclick="return confirm('Aktifkan mode maintenance? Akses publik akan ditutup.')">Aktifkan Maintenance</button>
                        </form>
                        <form action="{{ route('admin.server.up') }}" method="POST" data-no-ajax>
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm text-white" onclick="return confirm('Matikan mode maintenance? Akses publik akan dibuka kembali.')">Nonaktifkan (Online)</button>
                        </form>
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
