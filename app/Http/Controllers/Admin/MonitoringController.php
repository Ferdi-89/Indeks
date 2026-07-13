<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class MonitoringController extends Controller
{
    /**
     * [FITUR] Menyusun dan menampilkan statistik kinerja sistem, database, dan pemantauan API pihak ketiga.
     */
    public function apiMonitoring()
    {
        $startTime = defined('LARAVEL_START') ? LARAVEL_START : microtime(true);
        DB::enableQueryLog();
        $monitoring = [];

        $monitoring['php_version']      = phpversion();
        $monitoring['laravel_version']  = app()->version();
        $monitoring['php_memory']       = round(memory_get_usage(true) / 1024 / 1024, 2) . ' MB';
        $monitoring['php_memory_peak']  = round(memory_get_peak_usage(true) / 1024 / 1024, 2) . ' MB';
        $monitoring['server_os']        = php_uname('s') . ' ' . php_uname('r');
        $monitoring['server_software']  = $_SERVER['SERVER_SOFTWARE'] ?? 'CLI';

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

        try {
            $dbStats = Cache::remember('admin_db_stats_v3', 300, function () {
                $sizeRow = DB::selectOne(
                    "SELECT pg_database_size(current_database()) AS size"
                );
                $bytes = $sizeRow->size ?? 0;
                $mb    = round($bytes / 1024 / 1024, 2);

                $connRow = DB::selectOne(
                    "SELECT count(*) AS cnt FROM pg_stat_activity WHERE datname = current_database()"
                );

                return [
                    'db_size'            => $mb . ' MB',
                    'db_size_pct'        => round(($mb / 500) * 100, 1),
                    'db_size_bytes'      => $bytes,
                    'db_connections'     => $connRow->cnt ?? 0,
                    'db_max_connections' => 60,
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

        try {
            $storageStats = Cache::remember('admin_storage_stats_v2', 600, function () {
                $disk      = Storage::disk('s3');
                $allFiles  = $disk->allFiles();
                $totalBytes = 0;
                foreach ($allFiles as $file) {
                    try { $totalBytes += $disk->size($file); } catch (\Exception $e) {}
                }
                $totalMB  = round($totalBytes / 1024 / 1024, 3);
                return [
                    'storage_file_count'  => count($allFiles),
                    'storage_bytes'       => $totalBytes,
                    'storage_mb'          => $totalMB,
                    'storage_pct'         => round(($totalMB / 1024) * 100, 2),
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

        $queryLog = DB::getQueryLog();
        $monitoring['query_count'] = count($queryLog);
        $monitoring['query_time']  = round(collect($queryLog)->sum('time'), 2);
        $monitoring['load_time']   = round((microtime(true) - $startTime) * 1000) . ' ms';

        return view('admin.partials.monitoring', compact('monitoring'));
    }
}
