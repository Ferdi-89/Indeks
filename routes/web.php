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

// ─── Test Route ─────────────────────────────────────────────────────────
Route::get('/hello', function () {
    return 'Hello World';
});

// ─── Landing Page ───────────────────────────────────────────────────────
Route::get('/', function () {
    $pengumuman = pengumuman::pluck('text_pengumuman')->toArray();
    $pakets = paket::where('is_hidden', false)->get();
    $areaLayanan = App\Models\AreaLayanan::where('is_active', true)->get();

    if (empty($pengumuman)) {
        $pengumuman = ['Selamat datang dan Pilihlah paket anda :> '];
    }
    return view('welcome', compact('pengumuman', 'pakets', 'areaLayanan'));
});

// ─── Halaman Pendaftaran (GET) ──────────────────────────────────────────
Route::get('/daftar', function () {
    $pakets = paket::where('is_hidden', false)->get();
    $areaLayanan = App\Models\AreaLayanan::where('is_active', true)->get();
    return view('pendaftaran', compact('pakets', 'areaLayanan'));
})->name('pendaftaran');

// ─── Proses Pendaftaran (POST) ──────────────────────────────────────────
Route::post('/daftar', function (Illuminate\Http\Request $request) {

    // 1. Validasi data (max length disesuaikan dengan schema database Supabase)
    $validated = $request->validate([
        'nama' => 'required|string|max:50',
        'alamat' => 'required|string|max:100',
        'latitude' => 'nullable|numeric',
        'longtitude' => 'nullable|numeric',
        'wilayah' => 'required|string|max:100',
        'nomor_tlpn' => 'required|string|max:20',
        'path_gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'id_paket' => 'required|string|max:5'
    ]);

    // 2. Generate ID unik (hindari collision)
    do {
        $idPendaftaran = strtoupper(Str::random(5));
    } while (App\Models\pendaftaran::where('id_pendaftaran', $idPendaftaran)->exists());

    try {
        // 3. Handle Upload File ke Supabase Storage (Kompresi sudah dilakukan di client-side)
        $filePath = null;
        if ($request->hasFile('path_gambar')) {
            $file = $request->file('path_gambar');
            $originalName = $file->getClientOriginalName();
            $extension = strtolower($file->getClientOriginalExtension());
            $fileName = time() . '_' . preg_replace('/[^A-Za-z0-9\-]/', '', pathinfo($originalName, PATHINFO_FILENAME)) . '.' . $extension;
            
            // Simpan langsung tanpa proses GD karena kompresi sudah dilakukan di form HTML
            $filePath = $file->storeAs('pendaftaran', $fileName, 's3');
        }

        // 4. Simpan ke Database
        App\Models\pendaftaran::create([
            'id_pendaftaran' => $idPendaftaran,
            'nama' => $validated['nama'],
            'alamat' => $validated['alamat'],
            'latitude' => $validated['latitude'] ?? 0,
            'longtitude' => $validated['longtitude'] ?? 0,
            'wilayah' => $validated['wilayah'],
            'nomor_tlpn' => $validated['nomor_tlpn'],
            'path_gambar' => $filePath,
            'id_paket' => $validated['id_paket'],
        ]);

        // Buat notifikasi admin otomatis
        try {
            App\Models\AdminNotification::createFromPendaftaran($idPendaftaran, $validated['nama']);
        } catch (\Exception $ignored) {}

        return redirect('/daftar')->with('sukses', true);

    } catch (\Exception $e) {
        return back()->withInput()->withErrors([
            'error' => 'Terjadi kesalahan saat memproses pendaftaran: ' . $e->getMessage()
        ]);
    }
})->name('pendaftaran.store');

// ─── Cek Status Pendaftaran (GET) ──────────────────────────────────────
Route::get('/cek-status/{id}', function ($id) {
    // Cari pendaftaran berdasarkan ID (case-insensitive & clean)
    $cleanId = strtoupper(trim($id));
    $pendaftaran = App\Models\pendaftaran::with('paket')->where('id_pendaftaran', $cleanId)->first();

    if (!$pendaftaran) {
        return response()->json([
            'success' => false,
            'message' => 'ID Pendaftaran tidak ditemukan.'
        ], 404);
    }

    return response()->json([
        'success' => true,
        'data' => [
            'id_pendaftaran' => $pendaftaran->id_pendaftaran,
            'nama' => $pendaftaran->nama,
            'wilayah' => $pendaftaran->wilayah,
            'paket' => $pendaftaran->paket ? $pendaftaran->paket->title_paket : $pendaftaran->id_paket,
            'status' => $pendaftaran->status,
            'tanggal_daftar' => $pendaftaran->created_at->format('d M Y')
        ]
    ]);
})->name('cek-status');

// ─── Otentikasi Admin ───────────────────────────────────────────────────
Route::get('/login', function () {
    return view('auth.login');
})->name('login')->middleware('guest');

Route::post('/login', function (Illuminate\Http\Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Illuminate\Support\Facades\Auth::attempt($credentials, $request->boolean('remember'))) {
        $request->session()->regenerate();
        return redirect()->intended('/admin');
    }

    return back()->withErrors([
        'email' => 'Email atau password salah.',
    ])->onlyInput('email');
});

Route::post('/logout', function (Illuminate\Http\Request $request) {
    Illuminate\Support\Facades\Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    // --- Pendaftaran ---
    Route::post('/pendaftaran', function(Illuminate\Http\Request $request) {
        $validated = $request->validate([
            'nama' => 'required|string|max:50',
            'alamat' => 'required|string|max:100',
            'wilayah' => 'required|string|max:100',
            'nomor_tlpn' => 'required|string|max:20',
            'id_paket' => 'required|string|max:5'
        ]);

        do {
            $idPendaftaran = strtoupper(Illuminate\Support\Str::random(5));
        } while (App\Models\pendaftaran::where('id_pendaftaran', $idPendaftaran)->exists());

        App\Models\pendaftaran::create([
            'id_pendaftaran' => $idPendaftaran,
            'nama' => $validated['nama'],
            'alamat' => $validated['alamat'],
            'wilayah' => $validated['wilayah'],
            'nomor_tlpn' => $validated['nomor_tlpn'],
            'id_paket' => $validated['id_paket'],
            'status' => 'pending',
            'latitude' => 0,
            'longtitude' => 0,
            'path_gambar' => null
        ]);

        return redirect()->back()->with('success', 'Pendaftaran baru berhasil ditambahkan.');
    })->name('pendaftaran.store');

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

    Route::put('/pendaftaran/{id}', function(Illuminate\Http\Request $request, $id) {
        $data = $request->validate([
            'nama' => 'required|string|max:50',
            'alamat' => 'required|string|max:100',
            'wilayah' => 'required|string|max:100',
            'nomor_tlpn' => 'required|string|max:20',
            'id_paket' => 'required|string|max:5'
        ]);
        App\Models\pendaftaran::findOrFail($id)->update($data);
        return redirect()->back()->with('success', 'Data pendaftaran diperbarui.');
    })->name('pendaftaran.update');

    Route::post('/pendaftaran/export', function(Illuminate\Http\Request $request) {
        $search = $request->input('search');
        $exportOption = $request->input('export_option', 'all');
        $selectedColumns = $request->input('columns', []);

        $statusFilter = $request->input('filter_status');
        $paketFilter = $request->input('filter_paket');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $sortBy = $request->input('sort_by', 'created_at');
        $sortOrder = $request->input('sort_order', 'desc');

        $query = App\Models\pendaftaran::with('paket');

        if ($exportOption === 'filtered') {
            if (!empty($search)) {
                $query->where(function($q) use ($search) {
                    $q->where('id_pendaftaran', 'LIKE', "%{$search}%")
                      ->orWhere('nama', 'LIKE', "%{$search}%")
                      ->orWhere('nomor_tlpn', 'LIKE', "%{$search}%")
                      ->orWhere('wilayah', 'LIKE', "%{$search}%")
                      ->orWhere('alamat', 'LIKE', "%{$search}%")
                      ->orWhereHas('paket', function($pq) use ($search) {
                          $pq->where('title_paket', 'LIKE', "%{$search}%");
                      });
                });
            }

            if (!empty($statusFilter)) {
                $query->where('status', $statusFilter);
            }

            if (!empty($paketFilter)) {
                $query->where('id_paket', $paketFilter);
            }

            if (!empty($startDate)) {
                $query->whereDate('created_at', '>=', $startDate);
            }

            if (!empty($endDate)) {
                $query->whereDate('created_at', '<=', $endDate);
            }
        }

        $allowedSort = ['created_at', 'status', 'id_paket', 'nama'];
        $sortBy = in_array($sortBy, $allowedSort) ? $sortBy : 'created_at';
        $sortOrder = in_array(strtolower($sortOrder), ['asc', 'desc']) ? strtolower($sortOrder) : 'desc';

        $query->orderBy($sortBy, $sortOrder);

        $records = $query->get();

        $columnMap = [
            'id_pendaftaran' => 'ID Pendaftaran',
            'nama'           => 'Nama Lengkap',
            'nomor_tlpn'     => 'No. Telepon / WA',
            'wilayah'        => 'Wilayah',
            'alamat'         => 'Alamat Pemasangan',
            'latitude'       => 'Latitude',
            'longtitude'     => 'Longitude',
            'paket'          => 'Paket Layanan',
            'harga'          => 'Harga Paket',
            'status'         => 'Status',
            'created_at'     => 'Tanggal Daftar',
        ];

        $filename = "data_pendaftaran_" . date('Ymd_His') . ".csv";

        $headers = [
            "Content-Type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=\"$filename\"",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use ($records, $selectedColumns, $columnMap) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF)); // UTF-8 BOM

            $headerRow = [];
            foreach ($selectedColumns as $colKey) {
                if (isset($columnMap[$colKey])) {
                    $headerRow[] = $columnMap[$colKey];
                }
            }
            fputcsv($file, $headerRow);

            foreach ($records as $row) {
                $dataRow = [];
                foreach ($selectedColumns as $colKey) {
                    switch ($colKey) {
                        case 'id_pendaftaran':
                            $dataRow[] = $row->id_pendaftaran;
                            break;
                        case 'nama':
                            $dataRow[] = $row->nama;
                            break;
                        case 'nomor_tlpn':
                            $dataRow[] = $row->nomor_tlpn;
                            break;
                        case 'wilayah':
                            $dataRow[] = $row->wilayah;
                            break;
                        case 'alamat':
                            $dataRow[] = $row->alamat;
                            break;
                        case 'latitude':
                            $dataRow[] = $row->latitude;
                            break;
                        case 'longtitude':
                            $dataRow[] = $row->longtitude;
                            break;
                        case 'paket':
                            $dataRow[] = $row->paket ? $row->paket->title_paket : $row->id_paket;
                            break;
                        case 'harga':
                            $dataRow[] = $row->paket ? $row->paket->harga_paket : 0;
                            break;
                        case 'status':
                            $dataRow[] = ucfirst($row->status);
                            break;
                        case 'created_at':
                            $dataRow[] = $row->created_at->format('Y-m-d H:i:s');
                            break;
                    }
                }
                fputcsv($file, $dataRow);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    })->name('pendaftaran.export');

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
        try {
            App\Models\paket::where('id_paket', $id)->delete();
            return redirect()->back()->with('success', 'Paket dihapus.');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == '23503') {
                return redirect()->back()->with('error', 'Gagal menghapus paket. Paket ini masih digunakan oleh data pendaftaran.');
            }
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    })->name('paket.destroy');

    Route::patch('/paket/{id}/toggle-hide', function($id) {
        $paket = App\Models\paket::findOrFail($id);
        $paket->update(['is_hidden' => !$paket->is_hidden]);
        return redirect()->back()->with('success', 'Status visibilitas paket diperbarui.');
    })->name('paket.toggle_hide');

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

    // ──────────────────────────────────────────────────────────────────
    // Helper: kembalikan JSON jika XHR, redirect jika request biasa
    // ──────────────────────────────────────────────────────────────────
    $jsonOrRedirect = fn($request, $msg) => $request->ajax()
        ? response()->json(['success' => true, 'message' => $msg])
        : redirect()->back()->with('success', $msg);

    $jsonOrError = fn($request, $errors) => $request->ajax()
        ? response()->json(['success' => false, 'errors' => $errors], 422)
        : redirect()->back()->withErrors($errors);

    // --- Kontrol Server ---
    Route::post('/server/maintenance', function(Illuminate\Http\Request $request) use ($jsonOrRedirect) {
        Illuminate\Support\Facades\Artisan::call('down', [
            '--secret' => 'rnet-admin',
            '--render' => 'errors.503'
        ]);
        return $jsonOrRedirect($request, 'Mode maintenance diaktifkan. Anda dapat bypass menggunakan URL /rnet-admin');
    })->name('server.maintenance');

    Route::post('/server/up', function(Illuminate\Http\Request $request) use ($jsonOrRedirect) {
        Illuminate\Support\Facades\Artisan::call('up');
        return $jsonOrRedirect($request, 'Server kembali online untuk publik.');
    })->name('server.up');

    Route::post('/server/shutdown', function(Illuminate\Http\Request $request) use ($jsonOrRedirect) {
        // Matikan serve secara asinkron tergantung OS
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            pclose(popen('start /B taskkill /F /IM php.exe', 'r'));
        } else {
            exec('pkill -f "php artisan serve" > /dev/null 2>&1 &');
        }
        return $jsonOrRedirect($request, 'Perintah shutdown telah dikirim. Server akan mati dalam beberapa detik.');
    })->name('server.shutdown');
    // --- Profil Admin: Update Info ---
    Route::put('/profil', function(Illuminate\Http\Request $request) use ($jsonOrRedirect) {
        $data = $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'email'        => 'required|email|max:100',
            'phone'        => 'nullable|string|max:20',
            'alamat'       => 'nullable|string|max:500',
        ]);
        $profil = App\Models\AdminProfile::first();
        if ($profil) {
            $profil->update($data);
        } else {
            App\Models\AdminProfile::create(array_merge($data, ['username' => 'admin']));
        }
        return $jsonOrRedirect($request, 'Profil admin berhasil diperbarui.');
    })->name('profil.update');

    // --- Profil Admin: Ubah Password ---
    Route::put('/profil/password', function(Illuminate\Http\Request $request) use ($jsonOrRedirect, $jsonOrError) {
        $request->validate([
            'current_password' => 'required|string',
            'new_password'     => 'required|string|min:8|confirmed',
        ]);
        $user = Illuminate\Support\Facades\Auth::user();
        if (!Illuminate\Support\Facades\Hash::check($request->current_password, $user->password)) {
            return $jsonOrError($request, ['current_password' => ['Kata sandi saat ini tidak sesuai.']]);
        }
        $user->update(['password' => Illuminate\Support\Facades\Hash::make($request->new_password)]);
        return $jsonOrRedirect($request, 'Kata sandi berhasil diubah.');
    })->name('profil.password');

    // --- Profil Admin: Preferensi Tampilan ---
    Route::put('/profil/preferences', function(Illuminate\Http\Request $request) use ($jsonOrRedirect) {
        $profil = App\Models\AdminProfile::first();
        if ($profil) {
            $profil->update([
                'dark_mode'   => $request->has('dark_mode'),
                'email_notif' => $request->has('email_notif'),
                'sound_notif' => $request->has('sound_notif'),
            ]);
        }
        return $jsonOrRedirect($request, 'Preferensi tampilan disimpan.');
    })->name('profil.preferences');

    // --- Profil Admin: Upload Avatar ---
    Route::post('/profil/avatar', function(Illuminate\Http\Request $request) use ($jsonOrRedirect) {
        $request->validate(['avatar' => 'required|image|mimes:jpg,jpeg,png|max:2048']);
        $profil = App\Models\AdminProfile::first();
        if (!$profil) {
            return $request->ajax()
                ? response()->json(['success' => false, 'message' => 'Profil tidak ditemukan.'], 404)
                : back()->withErrors(['avatar' => 'Profil tidak ditemukan.']);
        }
        if ($profil->avatar_path) {
            Illuminate\Support\Facades\Storage::disk('s3')->delete($profil->avatar_path);
        }
        $path = $request->file('avatar')->store('avatars', 's3');
        $url  = Illuminate\Support\Facades\Storage::disk('s3')->url($path);
        $profil->update(['avatar_path' => $url]);
        return $request->ajax()
            ? response()->json(['success' => true, 'message' => 'Foto profil berhasil diperbarui.', 'avatar_url' => $url])
            : redirect()->back()->with('success', 'Foto profil berhasil diperbarui.');
    })->name('profil.avatar');

    // --- Pengaturan Perusahaan: Info Utama ---
    Route::put('/pengaturan', function(Illuminate\Http\Request $request) use ($jsonOrRedirect) {
        $data = $request->validate([
            'nama_perusahaan'    => 'required|string|max:100',
            'email_perusahaan'   => 'nullable|email|max:100',
            'telepon_perusahaan' => 'nullable|string|max:30',
            'alamat_perusahaan'  => 'nullable|string',
            'website'            => 'nullable|url|max:255',
            'npwp'               => 'nullable|string|max:30',
        ]);
        App\Models\CompanySetting::getInstance()->update($data);
        return $jsonOrRedirect($request, 'Informasi perusahaan berhasil diperbarui.');
    })->name('pengaturan.update');

    // --- Pengaturan: Media Sosial ---
    Route::put('/pengaturan/social', function(Illuminate\Http\Request $request) use ($jsonOrRedirect) {
        $data = $request->validate([
            'facebook'  => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:100',
            'whatsapp'  => 'nullable|string|max:20',
        ]);
        App\Models\CompanySetting::getInstance()->update($data);
        return $jsonOrRedirect($request, 'Media sosial berhasil diperbarui.');
    })->name('pengaturan.social');

    // --- Pengaturan: Jam Operasional ---
    Route::put('/pengaturan/hours', function(Illuminate\Http\Request $request) use ($jsonOrRedirect) {
        $data = $request->validate([
            'jam_buka_weekday'  => 'nullable|date_format:H:i',
            'jam_tutup_weekday' => 'nullable|date_format:H:i',
            'jam_buka_sabtu'    => 'nullable|date_format:H:i',
            'jam_tutup_sabtu'   => 'nullable|date_format:H:i',
        ]);
        $data['buka_minggu'] = $request->has('buka_minggu');
        App\Models\CompanySetting::getInstance()->update($data);
        return $jsonOrRedirect($request, 'Jam operasional berhasil diperbarui.');
    })->name('pengaturan.hours');

    // --- Pengaturan: Upload Logo ---
    Route::post('/pengaturan/logo', function(Illuminate\Http\Request $request) use ($jsonOrRedirect) {
        $request->validate(['logo' => 'required|image|mimes:jpg,jpeg,png|max:2048']);
        $company = App\Models\CompanySetting::getInstance();
        if ($company->logo_path) {
            Illuminate\Support\Facades\Storage::disk('s3')->delete(
                ltrim(parse_url($company->logo_path, PHP_URL_PATH), '/')
            );
        }
        $path = $request->file('logo')->store('logos', 's3');
        $url  = Illuminate\Support\Facades\Storage::disk('s3')->url($path);
        $company->update(['logo_path' => $url]);
        return $request->ajax()
            ? response()->json(['success' => true, 'message' => 'Logo berhasil diperbarui.', 'logo_url' => $url])
            : redirect()->back()->with('success', 'Logo perusahaan berhasil diperbarui.');
    })->name('pengaturan.logo');

    // --- Pengaturan: Hapus Logo ---
    Route::delete('/pengaturan/logo', function(Illuminate\Http\Request $request) use ($jsonOrRedirect) {
        $company = App\Models\CompanySetting::getInstance();
        if ($company->logo_path) {
            Illuminate\Support\Facades\Storage::disk('s3')->delete(
                ltrim(parse_url($company->logo_path, PHP_URL_PATH), '/')
            );
            $company->update(['logo_path' => null]);
        }
        return $jsonOrRedirect($request, 'Logo perusahaan berhasil dihapus.');
    })->name('pengaturan.logo.delete');

    // --- Area Layanan ---
    Route::post('/area', function(Illuminate\Http\Request $request) use ($jsonOrRedirect) {
        $data = $request->validate(['nama_area' => 'required|string|max:100']);
        $area = App\Models\AreaLayanan::create(array_merge($data, ['is_active' => true]));
        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Area layanan ditambahkan.', 'area' => $area]);
        }
        return redirect()->back()->with('success', 'Area layanan ditambahkan.');
    })->name('area.store');

    Route::put('/area/{id}', function(Illuminate\Http\Request $request, $id) use ($jsonOrRedirect) {
        $data = $request->validate(['nama_area' => 'required|string', 'is_active' => 'boolean']);
        App\Models\AreaLayanan::findOrFail($id)->update($data);
        return $jsonOrRedirect($request, 'Area layanan diperbarui.');
    })->name('area.update');

    Route::patch('/area/{id}/toggle-hide', function($id) {
        $area = App\Models\AreaLayanan::findOrFail($id);
        $area->update(['is_active' => !$area->is_active]);
        return redirect()->back()->with('success', 'Status visibilitas area diperbarui.');
    })->name('area.toggle_hide');

    Route::delete('/area/{id}', function(Illuminate\Http\Request $request, $id) use ($jsonOrRedirect) {
        App\Models\AreaLayanan::findOrFail($id)->delete();
        return $jsonOrRedirect($request, 'Area layanan dihapus.');
    })->name('area.destroy');

    Route::get('/', function (Illuminate\Http\Request $request) {
        // Pendaftaran: paginasi 10 data, totalPendaftaran diambil dari paginator (bukan query count terpisah)
        $search = $request->query('search');
        $statusFilter = $request->query('filter_status');
        $paketFilter = $request->query('filter_paket');
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');
        $sortBy = $request->query('sort_by', 'created_at');
        $sortOrder = $request->query('sort_order', 'desc');

        $pendaftaranQuery = App\Models\pendaftaran::with('paket');

        if (!empty($search)) {
            $pendaftaranQuery->where(function($q) use ($search) {
                $q->where('id_pendaftaran', 'LIKE', "%{$search}%")
                  ->orWhere('nama', 'LIKE', "%{$search}%")
                  ->orWhere('nomor_tlpn', 'LIKE', "%{$search}%")
                  ->orWhere('wilayah', 'LIKE', "%{$search}%")
                  ->orWhere('alamat', 'LIKE', "%{$search}%")
                  ->orWhereHas('paket', function($pq) use ($search) {
                      $pq->where('title_paket', 'LIKE', "%{$search}%");
                  });
            });
        }

        if (!empty($statusFilter)) {
            $pendaftaranQuery->where('status', $statusFilter);
        }

        if (!empty($paketFilter)) {
            $pendaftaranQuery->where('id_paket', $paketFilter);
        }

        if (!empty($startDate)) {
            $pendaftaranQuery->whereDate('created_at', '>=', $startDate);
        }
        if (!empty($endDate)) {
            $pendaftaranQuery->whereDate('created_at', '<=', $endDate);
        }

        $allowedSort = ['created_at', 'status', 'id_paket', 'nama'];
        $sortBy = in_array($sortBy, $allowedSort) ? $sortBy : 'created_at';
        $sortOrder = in_array(strtolower($sortOrder), ['asc', 'desc']) ? strtolower($sortOrder) : 'desc';

        $pendaftaranQuery->orderBy($sortBy, $sortOrder);

        $pendaftaran = $pendaftaranQuery->paginate(10)->withQueryString()->fragment('pendaftaran');
        $totalPendaftaran = $pendaftaran->total(); // Gunakan hasil dari paginator, bukan ::count() terpisah
        
        // Paket: limit 100, count dari collection (bukan query terpisah)
        $paket = App\Models\paket::orderBy('id_paket')->limit(100)->get();
        $totalPaket = $paket->count();
        
        // Pengumuman: limit 50 terbaru, count dari collection
        $pengumuman = App\Models\pengumuman::latest('valid_start')->limit(50)->get();
        $totalPengumuman = $pengumuman->count();
        
        // Data for Chart (Last 7 Days) — 1 query tunggal
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
        
        // Promosi: limit 50
        $promosi = App\Models\promosi::latest()->limit(50)->get();
        
        // Profil Admin
        $adminProfile = App\Models\AdminProfile::first();
        
        // Pengaturan Perusahaan + Area Layanan
        $company = App\Models\CompanySetting::getInstance();
        $areaLayanan = App\Models\AreaLayanan::where('is_active', true)->get();
        
        return view('admin.index', compact(
            'pendaftaran', 'totalPendaftaran', 
            'paket', 'totalPaket', 
            'pengumuman', 'totalPengumuman',
            'chartLabels', 'chartValues',
            'promosi',
            'adminProfile',
            'company', 'areaLayanan'
        ));
    })->name('index');

    // --- API Monitoring (Async) ---
    Route::get('/api/monitoring', function () {
        $startTime = defined('LARAVEL_START') ? LARAVEL_START : microtime(true);
        Illuminate\Support\Facades\DB::enableQueryLog();
        $monitoring = [];

        // ── Info PHP & Server (selalu tersedia) ──────────────────────
        $monitoring['php_version']      = phpversion();
        $monitoring['laravel_version']  = app()->version();
        $monitoring['php_memory']       = round(memory_get_usage(true) / 1024 / 1024, 2) . ' MB';
        $monitoring['php_memory_peak']  = round(memory_get_peak_usage(true) / 1024 / 1024, 2) . ' MB';
        $monitoring['server_os']        = php_uname('s') . ' ' . php_uname('r');
        $monitoring['server_software']  = $_SERVER['SERVER_SOFTWARE'] ?? 'CLI';

        // ── Supabase Management API → ambil status project saja ──────
        $supabaseToken = env('EXPERIMENTAL_SUPABASE_API');
        $projectRef    = explode('.', env('DB_USERNAME', ''))[1] ?? null;
        $supabaseStatus = 'unknown';

        if ($supabaseToken && $projectRef) {
            try {
                $ch = curl_init("https://api.supabase.com/v1/projects/{$projectRef}");
                curl_setopt_array($ch, [
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_TIMEOUT        => 6,
                    CURLOPT_HTTPHEADER     => [
                        "Authorization: Bearer {$supabaseToken}",
                        "Content-Type: application/json",
                    ],
                ]);
                $pBody = curl_exec($ch);
                $pStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch);
                if ($pStatus === 200 && $pBody) {
                    $pData = json_decode($pBody, true);
                    $supabaseStatus = $pData['status'] ?? 'unknown';
                }
            } catch (\Exception $e) { /* silent */ }
        }
        $monitoring['supabase_status'] = $supabaseStatus;

        // ── DB Size & Connections via PostgreSQL langsung ─────────────
        try {
            $dbStats = Illuminate\Support\Facades\Cache::remember('admin_db_stats_v3', 300, function () {
                $sizeRow = Illuminate\Support\Facades\DB::selectOne(
                    "SELECT pg_database_size(current_database()) AS size"
                );
                $bytes = $sizeRow->size ?? 0;
                $mb    = round($bytes / 1024 / 1024, 2);

                $connRow = Illuminate\Support\Facades\DB::selectOne(
                    "SELECT count(*) AS cnt FROM pg_stat_activity WHERE datname = current_database()"
                );

                return [
                    'db_size'            => $mb . ' MB',
                    'db_size_pct'        => round(($mb / 500) * 100, 1),   // free tier 500 MB
                    'db_size_bytes'      => $bytes,
                    'db_connections'     => $connRow->cnt ?? 0,
                    'db_max_connections' => 60,   // Supabase free tier pooler limit
                ];
            });
            $monitoring = array_merge($monitoring, $dbStats);
        } catch (\Exception $e) {
            $monitoring['db_size']        = 'Error';
            $monitoring['db_size_pct']    = 0;
            $monitoring['db_size_bytes']  = 0;
            $monitoring['db_connections'] = 0;
            $monitoring['db_max_connections'] = 60;
        }

        // ── Storage Size: hitung semua file di S3 bucket ─────────────
        try {
            $storageStats = Illuminate\Support\Facades\Cache::remember('admin_storage_stats_v2', 600, function () {
                $disk      = Illuminate\Support\Facades\Storage::disk('s3');
                $allFiles  = $disk->allFiles();   // rekursif semua folder
                $totalBytes = 0;
                foreach ($allFiles as $file) {
                    try { $totalBytes += $disk->size($file); } catch (\Exception $e) {}
                }
                $totalMB  = round($totalBytes / 1024 / 1024, 3);
                return [
                    'storage_file_count'  => count($allFiles),
                    'storage_bytes'       => $totalBytes,
                    'storage_mb'          => $totalMB,
                    'storage_pct'         => round(($totalMB / 1024) * 100, 2), // free tier 1 GB
                    'storage_connected'   => true,
                ];
            });
            $monitoring = array_merge($monitoring, $storageStats);
        } catch (\Exception $e) {
            $monitoring['storage_file_count'] = 0;
            $monitoring['storage_bytes']      = 0;
            $monitoring['storage_mb']         = 0;
            $monitoring['storage_pct']        = 0;
            $monitoring['storage_connected']  = false;
        }

        // ── Query log & load time ──────────────────────────────────
        $queryLog = Illuminate\Support\Facades\DB::getQueryLog();
        $monitoring['query_count'] = count($queryLog);
        $monitoring['query_time']  = round(collect($queryLog)->sum('time'), 2);
        $monitoring['load_time']   = round((microtime(true) - $startTime) * 1000) . ' ms';

        return view('admin.partials.monitoring', compact('monitoring'));
    })->name('api.monitoring');

    // ─── API Notifikasi ─────────────────────────────────────────────────

    // GET: ambil daftar 20 notifikasi terbaru + jumlah unread
    Route::get('/api/notifications', function () {
        $notifications = App\Models\AdminNotification::recent(20)->get()->map(fn($n) => [
            'id'       => $n->id,
            'type'     => $n->type,
            'title'    => $n->title,
            'body'     => $n->body,
            'icon'     => $n->icon,
            'link_tab' => $n->link_tab,
            'ref_id'   => $n->ref_id,
            'is_read'  => !is_null($n->read_at),
            'time_ago' => $n->created_at->diffForHumans(),
        ]);
        $unread = App\Models\AdminNotification::unread()->count();
        return response()->json(['notifications' => $notifications, 'unread' => $unread]);
    })->name('api.notifications');

    // PATCH: tandai satu notifikasi sebagai sudah dibaca
    Route::patch('/api/notifications/{id}/read', function ($id) {
        $notif = App\Models\AdminNotification::findOrFail($id);
        $notif->markRead();
        $unread = App\Models\AdminNotification::unread()->count();
        return response()->json(['success' => true, 'unread' => $unread]);
    })->name('api.notifications.read');

    // PATCH: tandai semua sebagai sudah dibaca
    Route::patch('/api/notifications/read-all', function () {
        App\Models\AdminNotification::unread()->update(['read_at' => now()]);
        return response()->json(['success' => true, 'unread' => 0]);
    })->name('api.notifications.read_all');

    // DELETE: hapus semua notifikasi yang sudah dibaca
    Route::delete('/api/notifications/clear', function () {
        App\Models\AdminNotification::whereNotNull('read_at')->delete();
        $unread = App\Models\AdminNotification::unread()->count();
        return response()->json(['success' => true, 'unread' => $unread]);
    })->name('api.notifications.clear');
});

