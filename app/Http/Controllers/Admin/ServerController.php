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
        return $this->jsonOrRedirect($request, 'Mode maintenance diaktifkan. Anda dapat bypass menggunakan URL /rnet-admin');
    }

    /**
     * [FITUR] Membawa aplikasi keluar dari mode pemeliharaan (kembali online).
     */
    public function up(Request $request)
    {
        Artisan::call('up');
        return $this->jsonOrRedirect($request, 'Server kembali online untuk publik.');
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
