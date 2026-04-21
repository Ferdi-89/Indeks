<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;
use App\Models\pengumuman;
use App\Models\paket;
use Illuminate\Support\Str;

// Routing landing page
// Cache dan Minimalisir Query Database
Route::get('/', function () {

    $data = Cache::remember('landing_page_data',60*60*24, function () {
        return[
            'pengumuman' => pengumuman::pluck('text_pengumuman')->toArray(),
            'pakets' => paket::all()->toArray()
        ];
    });

    $pengumuman = $data['pengumuman'];
    $pakets = collect($data['pakets']);

    $ekonomi = $pakets->where('id_paket','p001')->first();
    $famili = $pakets->where('id_paket','p002')->first();
    $premium = $pakets->where('id_paket','p003')->first();

    if(empty($pengumuman)){
        $pengumuman = ['Selamat datang dan Pilihlah paket anda :> '];
    }
    return view('welcome',compact('pengumuman','famili','ekonomi','premium'));
});

Route::get('/daftar', function () {
    return view('pendaftaran');
})->name('pendaftaran');

// Routing Page Pendaftaran
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
        'id_pendaftaran' => 'USR-' . strtoupper(Str::random(8)), // Contoh generate ID
        'nama' => $validated['nama'],
        'alamat' => $validated['alamat'],
        'latitude' => $validated['latitude'] ?? 0,
        'longtitude' => $validated['longtitude'] ?? 0,
        'email' => $validated['email'],
        'nomor_tlpn' => $validated['nomor_tlpn'],
        'path_gambar' => $filePath,

    ]);

    return redirect('/')->with('success', 'Pendaftaran berhasil dikirim!');
})->name('pendaftaran.store');
