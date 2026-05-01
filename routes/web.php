<?php

use Illuminate\Support\Facades\Route;
use App\Models\pengumuman;
use App\Models\paket;
use App\models\pendaftaran;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Strategi Data — Direct Query (Tanpa Cache)
|--------------------------------------------------------------------------
|
| Data paket (3 baris) dan pengumuman di-query langsung dari Supabase
| setiap request. Untuk dataset sekecil ini, query langsung ~50-100ms
| sudah sangat cepat dan menjamin data SELALU sinkron dengan database.
|
| Cache tidak digunakan karena data sering diubah langsung di Supabase
| Dashboard, di luar kontrol Laravel — sehingga cache invalidation
| tidak bisa dipicu otomatis.
|
*/

// ─── Landing Page ───────────────────────────────────────────────────────
Route::get('/', function () {

    $pengumuman = pengumuman::pluck('text_pengumuman')->toArray();
    $pakets = paket::all();

    $ekonomi = $pakets->where('id_paket', 'p001')->first();
    $famili  = $pakets->where('id_paket', 'p002')->first();
    $premium = $pakets->where('id_paket', 'p003')->first();

    if (empty($pengumuman)) {
        $pengumuman = ['Selamat datang dan Pilihlah paket anda :> '];
    }
    return view('welcome', compact('pengumuman', 'famili', 'ekonomi', 'premium'));
});

// ─── Halaman Pendaftaran (GET) ──────────────────────────────────────────
Route::get('/daftar', function () {
    $pakets = paket::all();
    return view('pendaftaran', compact('pakets'));
})->name('pendaftaran');

// ─── Proses Pendaftaran (POST) ──────────────────────────────────────────
Route::post('/daftar', function (Illuminate\Http\Request $request) {

    // 1. Validasi data (max length disesuaikan dengan schema database Supabase)
    $validated = $request->validate([
        'nama' => 'required|string|max:50',
        'alamat' => 'required|string|max:100',
        'latitude' => 'nullable|numeric',
        'longtitude' => 'nullable|numeric',
        'email' => 'required|email|max:100',
        'nomor_tlpn' => 'required|string|max:20',
        'path_gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'id_paket' => 'required|string|max:5'
    ]);

    // 2. Generate ID unik (hindari collision)
    do {
        $idPendaftaran = strtoupper(Str::random(5));
    } while (App\Models\pendaftaran::where('id_pendaftaran', $idPendaftaran)->exists());

    try {
        // 3. Handle Upload File ke Supabase Storage
        $filePath = null;
        if ($request->hasFile('path_gambar')) {
            $file = $request->file('path_gambar');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('pendaftaran', $fileName, 's3');
        }

        // 4. Simpan ke Database
        App\Models\pendaftaran::create([
            'id_pendaftaran' => $idPendaftaran,
            'nama' => $validated['nama'],
            'alamat' => $validated['alamat'],
            'latitude' => $validated['latitude'] ?? 0,
            'longtitude' => $validated['longtitude'] ?? 0,
            'email' => $validated['email'],
            'nomor_tlpn' => $validated['nomor_tlpn'],
            'path_gambar' => $filePath,
            'id_paket' => $validated['id_paket'],
        ]);

        return redirect('/daftar')->with('sukses', true);

    } catch (\Exception $e) {
        return back()->withInput()->withErrors([
            'error' => 'Terjadi kesalahan saat memproses pendaftaran: ' . $e->getMessage()
        ]);
    }
})->name('pendaftaran.store');



Route::prefix('admin')->name('admin.')->group(function () {
    // --- Pendaftaran ---
    Route::patch('/pendaftaran/{id}/status', function (Illuminate\Http\Request $request, $id) {
        $validated = $request->validate([
            'status' => 'required|in:pending,validated,rejected,setup,active,aktif'
        ]);
        
        $pendaftaran = App\Models\pendaftaran::findOrFail($id);
        $pendaftaran->update(['status' => $validated['status']]);
        
        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'status' => $validated['status']]);
        }
        return redirect()->back()->with('success', 'Status pendaftaran berhasil diperbarui.');
    })->name('pendaftaran.update_status');

    Route::delete('/pendaftaran/{id}', function($id) {
        $pendaftaran = App\Models\pendaftaran::findOrFail($id);
        if ($pendaftaran->path_gambar) {
            Illuminate\Support\Facades\Storage::disk('s3')->delete($pendaftaran->path_gambar);
        }
        $pendaftaran->delete();
        return redirect()->back()->with('success', 'Pendaftaran dihapus.');
    })->name('pendaftaran.destroy');

    // --- Paket ---
    Route::post('/paket', function(Illuminate\Http\Request $request) {
        $data = $request->validate([
            'id_paket' => 'required|string|unique:pakets,id_paket',
            'title_paket' => 'required|string',
            'harga_paket' => 'required|numeric',
        ]);
        App\Models\paket::create($data);
        return redirect()->back()->with('success', 'Paket ditambahkan.');
    })->name('paket.store');

    Route::put('/paket/{id}', function(Illuminate\Http\Request $request, $id) {
        $data = $request->validate([
            'title_paket' => 'required|string',
            'harga_paket' => 'required|numeric',
        ]);
        App\Models\paket::where('id_paket', $id)->firstOrFail()->update($data);
        return redirect()->back()->with('success', 'Paket diperbarui.');
    })->name('paket.update');

    Route::delete('/paket/{id}', function($id) {
        App\Models\paket::where('id_paket', $id)->delete();
        return redirect()->back()->with('success', 'Paket dihapus.');
    })->name('paket.destroy');

    // --- Pengumuman ---
    Route::post('/pengumuman', function(Illuminate\Http\Request $request) {
        $data = $request->validate([
            'id_pengumuman' => 'required|string|unique:pengumumans,id_pengumuman',
            'text_pengumuman' => 'required|string',
            'tema' => 'nullable|string',
            'valid_start' => 'nullable|date',
            'valid_end' => 'nullable|date'
        ]);
        App\Models\pengumuman::create($data);
        return redirect()->back()->with('success', 'Pengumuman ditambahkan.');
    })->name('pengumuman.store');

    Route::put('/pengumuman/{id}', function(Illuminate\Http\Request $request, $id) {
        $data = $request->validate([
            'text_pengumuman' => 'required|string',
            'tema' => 'nullable|string',
            'valid_start' => 'nullable|date',
            'valid_end' => 'nullable|date'
        ]);
        App\Models\pengumuman::where('id_pengumuman', $id)->firstOrFail()->update($data);
        return redirect()->back()->with('success', 'Pengumuman diperbarui.');
    })->name('pengumuman.update');

    Route::delete('/pengumuman/{id}', function($id) {
        App\Models\pengumuman::where('id_pengumuman', $id)->delete();
        return redirect()->back()->with('success', 'Pengumuman dihapus.');
    })->name('pengumuman.destroy');

    // --- Promosi ---
    Route::post('/promosi', function(Illuminate\Http\Request $request) {
        $data = $request->validate([
            'id_promosi' => 'required|string|unique:promosis,id_promosi',
            'value_promosi' => 'required|numeric',
            'text_promosi' => 'required|string',
            'tema' => 'nullable|string',
            'valid_start' => 'nullable|date',
            'valid_end' => 'nullable|date'
        ]);
        App\Models\promosi::create($data);
        return redirect()->back()->with('success', 'Promosi ditambahkan.');
    })->name('promosi.store');

    Route::put('/promosi/{id}', function(Illuminate\Http\Request $request, $id) {
        $data = $request->validate([
            'value_promosi' => 'required|numeric',
            'text_promosi' => 'required|string',
            'tema' => 'nullable|string',
            'valid_start' => 'nullable|date',
            'valid_end' => 'nullable|date'
        ]);
        App\Models\promosi::where('id_promosi', $id)->firstOrFail()->update($data);
        return redirect()->back()->with('success', 'Promosi diperbarui.');
    })->name('promosi.update');

    Route::delete('/promosi/{id}', function($id) {
        App\Models\promosi::where('id_promosi', $id)->delete();
        return redirect()->back()->with('success', 'Promosi dihapus.');
    })->name('promosi.destroy');

    // --- Profil Admin ---
    Route::put('/profil', function(Illuminate\Http\Request $request) {
        $data = $request->except(['_token', '_method']);
        $profil = App\Models\AdminProfile::first();
        if ($profil) {
            $profil->update($data);
        } else {
            App\Models\AdminProfile::create($data);
        }
        return redirect()->back()->with('success', 'Profil admin diperbarui.');
    })->name('profil.update');

    // --- Pengaturan Perusahaan ---
    Route::put('/pengaturan', function(Illuminate\Http\Request $request) {
        $data = $request->except(['_token', '_method']);
        $company = App\Models\CompanySetting::getInstance();
        $company->update($data);
        return redirect()->back()->with('success', 'Pengaturan perusahaan diperbarui.');
    })->name('pengaturan.update');

    // --- Area Layanan ---
    Route::post('/area', function(Illuminate\Http\Request $request) {
        $data = $request->validate([
            'nama_area' => 'required|string'
        ]);
        App\Models\AreaLayanan::create($data);
        return redirect()->back()->with('success', 'Area layanan ditambahkan.');
    })->name('area.store');

    Route::put('/area/{id}', function(Illuminate\Http\Request $request, $id) {
        $data = $request->validate([
            'nama_area' => 'required|string',
            'is_active' => 'boolean'
        ]);
        App\Models\AreaLayanan::findOrFail($id)->update($data);
        return redirect()->back()->with('success', 'Area layanan diperbarui.');
    })->name('area.update');

    Route::delete('/area/{id}', function($id) {
        App\Models\AreaLayanan::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Area layanan dihapus.');
    })->name('area.destroy');

    Route::get('/', function () {
        // Ambil semua data sekaligus untuk SPA
        $pendaftaran = App\Models\pendaftaran::latest('created_at')->take(100)->get(); // Ambil 100 terbaru
        $totalPendaftaran = App\Models\pendaftaran::count();
        
        $paket = App\Models\paket::all();
        $totalPaket = App\Models\paket::count();
        
        $pengumuman = App\Models\pengumuman::all();
        $totalPengumuman = App\Models\pengumuman::count();
        
        // Data for Chart (Last 7 Days)
        $chartData = App\Models\pendaftaran::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->groupBy('date')
            ->orderBy('date')
            ->get();
            
        $dates = [];
        $counts = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $displayDate = now()->subDays($i)->format('d M');
            $dates[] = $displayDate;
            $counts[] = $chartData->firstWhere('date', $date)->count ?? 0;
        }
        
        $chartLabels = json_encode($dates);
        $chartValues = json_encode($counts);
        
        // Data untuk tab Promosi
        $promosi = App\Models\promosi::all();
        
        // Data untuk tab Profil Admin
        $adminProfile = App\Models\AdminProfile::first();
        
        // Data untuk tab Pengaturan Perusahaan
        $company = App\Models\CompanySetting::getInstance();
        $areaLayanan = App\Models\AreaLayanan::where('is_active', true)->get();
        
        // ═══════════════════════════════════════════
        // Data untuk tab Monitoring
        // ═══════════════════════════════════════════
        $startTime = defined('LARAVEL_START') ? LARAVEL_START : microtime(true);
        
        // Enable query log to count queries
        Illuminate\Support\Facades\DB::enableQueryLog();
        
        $monitoring = [];
        
        // PHP Info
        $monitoring['php_version'] = phpversion();
        $monitoring['laravel_version'] = app()->version();
        $monitoring['php_memory'] = round(memory_get_usage(true) / 1024 / 1024, 2) . ' MB';
        $monitoring['php_memory_peak'] = round(memory_get_peak_usage(true) / 1024 / 1024, 2) . ' MB';
        $monitoring['server_os'] = php_uname('s') . ' ' . php_uname('r');
        $monitoring['server_software'] = $_SERVER['SERVER_SOFTWARE'] ?? 'CLI';
        
        // Database Stats (PostgreSQL)
        try {
            $dbSizeRaw = Illuminate\Support\Facades\DB::select("SELECT pg_database_size(current_database()) as size")[0]->size ?? 0;
            $dbSizeMB = round($dbSizeRaw / 1024 / 1024, 2);
            $monitoring['db_size'] = $dbSizeMB . ' MB';
            $monitoring['db_size_pct'] = round(($dbSizeMB / 500) * 100, 1); // 500MB free tier
            
            $monitoring['db_connections'] = Illuminate\Support\Facades\DB::select("SELECT count(*) as cnt FROM pg_stat_activity")[0]->cnt ?? 0;
            $monitoring['db_max_connections'] = Illuminate\Support\Facades\DB::select("SHOW max_connections")[0]->max_connections ?? 100;
            
            // Table stats
            $monitoring['table_stats'] = Illuminate\Support\Facades\DB::select("
                SELECT 
                    relname as table_name,
                    n_live_tup as row_count,
                    pg_size_pretty(pg_table_size(quote_ident(relname))) as table_size,
                    pg_size_pretty(pg_indexes_size(quote_ident(relname))) as index_size,
                    pg_size_pretty(pg_total_relation_size(quote_ident(relname))) as total_size
                FROM pg_stat_user_tables
                ORDER BY pg_total_relation_size(quote_ident(relname)) DESC
            ");
        } catch (\Exception $e) {
            $monitoring['db_size'] = 'Error';
            $monitoring['db_size_pct'] = 0;
            $monitoring['db_connections'] = 0;
            $monitoring['db_max_connections'] = 100;
            $monitoring['table_stats'] = [];
        }
        
        // Storage (S3 Bucket) Stats
        try {
            $files = Illuminate\Support\Facades\Storage::disk('s3')->files('pendaftaran');
            $monitoring['storage_file_count'] = count($files);
            $monitoring['storage_connected'] = true;
        } catch (\Exception $e) {
            $monitoring['storage_file_count'] = 0;
            $monitoring['storage_connected'] = false;
        }
        
        // Query stats
        $queryLog = Illuminate\Support\Facades\DB::getQueryLog();
        $monitoring['query_count'] = count($queryLog);
        $monitoring['query_time'] = round(collect($queryLog)->sum('time'), 2);
        
        // Load time
        $monitoring['load_time'] = round((microtime(true) - $startTime) * 1000) . ' ms';
        
        return view('admin.index', compact(
            'pendaftaran', 'totalPendaftaran', 
            'paket', 'totalPaket', 
            'pengumuman', 'totalPengumuman',
            'chartLabels', 'chartValues',
            'promosi',
            'adminProfile',
            'company', 'areaLayanan',
            'monitoring'
        ));
    })->name('index');
});
