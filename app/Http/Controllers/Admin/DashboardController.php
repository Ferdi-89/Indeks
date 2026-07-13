<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\pendaftaran;
use App\Models\paket;
use App\Models\pengumuman;
use App\Models\promosi;
use App\Models\AdminProfile;
use App\Models\CompanySetting;
use App\Models\AreaLayanan;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * [FITUR] Menampilkan halaman utama dashboard administratif admin beserta data grafik pendaftaran.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $statusFilter = $request->query('filter_status');
        $paketFilter = $request->query('filter_paket');
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');
        $sortBy = $request->query('sort_by', 'created_at');
        $sortOrder = $request->query('sort_order', 'desc');

        $pendaftaranQuery = pendaftaran::with('paket');

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
        $totalPendaftaran = $pendaftaran->total();
        
        $paket = paket::orderBy('id_paket')->limit(100)->get();
        $totalPaket = $paket->count();
        
        $pengumuman = pengumuman::latest('valid_start')->limit(50)->get();
        $totalPengumuman = $pengumuman->count();
        
        $chartData = pendaftaran::selectRaw('DATE(created_at) as date, COUNT(*) as count')
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
        
        $promosi = promosi::latest()->limit(50)->get();
        $adminProfile = AdminProfile::first();
        $company = CompanySetting::getInstance();
        $areaLayanan = AreaLayanan::all();
        $users = User::orderBy('id', 'desc')->get();

        return view('admin.index', compact(
            'pendaftaran', 'totalPendaftaran', 
            'paket', 'totalPaket', 
            'pengumuman', 'totalPengumuman',
            'chartLabels', 'chartValues',
            'promosi',
            'adminProfile',
            'company', 'areaLayanan', 'users'
        ));
    }
}
