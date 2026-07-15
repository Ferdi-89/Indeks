<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Concerns\HasAdminHelpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class ServerController extends Controller
{
    use HasAdminHelpers;

    /**
     * [FITUR] Mengubah aplikasi ke mode pemeliharaan (maintenance mode).
     */
    public function maintenance(Request $request)
    {
        Artisan::call('down', [
            '--secret' => 'rnet-admin',
            '--render' => 'errors.503'
        ]);

        // Clear public customer-facing page caches (excluding admin cache)
        \Illuminate\Support\Facades\Cache::forget('home_pengumuman');
        \Illuminate\Support\Facades\Cache::forget('home_pakets');
        \Illuminate\Support\Facades\Cache::forget('home_area_layanan');
        \Illuminate\Support\Facades\Cache::forget('daftar_pakets');
        \Illuminate\Support\Facades\Cache::forget('daftar_area_layanan');

        // Clear compiled view cache to force immediate template regeneration
        Artisan::call('view:clear');

        return $this->jsonOrRedirect($request, 'Mode maintenance diaktifkan. Cache halaman utama dan form pendaftaran dibersihkan.');
    }

    /**
     * [FITUR] Membawa aplikasi keluar dari mode pemeliharaan (kembali online).
     */
    public function up(Request $request)
    {
        Artisan::call('up');

        // Clear public customer-facing page caches (excluding admin cache)
        \Illuminate\Support\Facades\Cache::forget('home_pengumuman');
        \Illuminate\Support\Facades\Cache::forget('home_pakets');
        \Illuminate\Support\Facades\Cache::forget('home_area_layanan');
        \Illuminate\Support\Facades\Cache::forget('daftar_pakets');
        \Illuminate\Support\Facades\Cache::forget('daftar_area_layanan');

        // Clear compiled view cache
        Artisan::call('view:clear');

        return $this->jsonOrRedirect($request, 'Server kembali online untuk publik. Cache halaman utama dan form pendaftaran dibersihkan.');
    }

    /**
     * [FITUR] Menghentikan paksa proses server PHP development lokal.
     */
    public function shutdown(Request $request)
    {
        if (app()->environment('testing')) {
            return $this->jsonOrRedirect($request, 'Perintah shutdown disimulasikan (testing).');
        }
        if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
            pclose(popen('start /B taskkill /F /IM php.exe', 'r'));
        } else {
            exec('pkill -f "php artisan serve" > /dev/null 2>&1 &');
        }
        return $this->jsonOrRedirect($request, 'Perintah shutdown telah dikirim. Server akan mati dalam beberapa detik.');
    }
}
