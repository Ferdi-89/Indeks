<?php

use Illuminate\Support\Facades\Route;
use App\Models\pengumuman;
use App\Models\paket;
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

    // 1. Validasi data
    $validated = $request->validate([
        'nama' => 'required|string|max:255',
        'alamat' => 'required|string|max:255',
        'latitude' => 'nullable',
        'longtitude' => 'nullable',
        'email' => 'required|email',
        'nomor_tlpn' => 'required',
        'path_gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        'id_paket' => 'required|string|max:5'
    ]);

    // 2. Handle Upload File
    $filePath = null;
    if ($request->hasFile('path_gambar')) {
        $file = $request->file('path_gambar');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('pendaftaran', $fileName, 's3');
    }

    // 3. Simpan ke Database
    App\Models\pendaftaran::create([
        'id_pendaftaran' => strtoupper(Str::random(5)),
        'nama' => $validated['nama'],
        'alamat' => $validated['alamat'],
        'latitude' => $validated['latitude'] ?? 0,
        'longtitude' => $validated['longtitude'] ?? 0,
        'email' => $validated['email'],
        'nomor_tlpn' => $validated['nomor_tlpn'],
        'path_gambar' => $filePath,
        'id_paket' => $validated['id_paket'],
    ]);

    return redirect('/')->with('success', 'Pendaftaran berhasil dikirim!');
})->name('pendaftaran.store');
