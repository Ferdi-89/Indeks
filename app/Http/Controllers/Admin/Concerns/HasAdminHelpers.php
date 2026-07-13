<?php

namespace App\Http\Controllers\Admin\Concerns;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

trait HasAdminHelpers
{
    /**
     * [CACHE] Membersihkan cache halaman utama ketika konfigurasi, paket, pengumuman, atau wilayah layanan berubah.
     */
    protected function clearHomeCaches()
    {
        Cache::forget('home_pengumuman');
        Cache::forget('home_pakets');
        Cache::forget('home_area_layanan');
        Cache::forget('daftar_pakets');
        Cache::forget('daftar_area_layanan');
    }

    /**
     * [RESPON] Mengembalikan respon JSON untuk permintaan AJAX atau redirect kembali dengan pesan sukses (flash message).
     */
    protected function jsonOrRedirect(Request $request, $msg)
    {
        return $request->ajax()
            ? response()->json(['success' => true, 'message' => $msg])
            : redirect()->back()->with('success', $msg);
    }

    /**
     * [RESPON] Mengembalikan respon error JSON untuk permintaan AJAX atau redirect kembali dengan kesalahan validasi.
     */
    protected function jsonOrError(Request $request, $errors)
    {
        return $request->ajax()
            ? response()->json(['success' => false, 'errors' => $errors], 422)
            : redirect()->back()->withErrors($errors);
    }
}
