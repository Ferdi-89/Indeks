<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\pendaftaran;
use App\Models\paket;
use App\Models\pengumuman;
use App\Models\promosi;
use App\Models\AdminProfile;
use App\Models\CompanySetting;
use App\Models\AreaLayanan;
use App\Models\User;
use App\Models\AdminNotification;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class AdminController extends Controller
{
    private function clearHomeCaches()
    {
        Cache::forget('home_pengumuman');
        Cache::forget('home_pakets');
        Cache::forget('home_area_layanan');
        Cache::forget('daftar_pakets');
        Cache::forget('daftar_area_layanan');
    }

    private function jsonOrRedirect(Request $request, $msg)
    {
        return $request->ajax()
            ? response()->json(['success' => true, 'message' => $msg])
            : redirect()->back()->with('success', $msg);
    }

    private function jsonOrError(Request $request, $errors)
    {
        return $request->ajax()
            ? response()->json(['success' => false, 'errors' => $errors], 422)
            : redirect()->back()->withErrors($errors);
    }

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

    public function pendaftaranStore(Request $request)
    {
        if ($request->has('nomor_tlpn')) {
            $phone = trim($request->input('nomor_tlpn'));
            $phone = preg_replace('/[^\+0-9]/', '', $phone);
            if (str_starts_with($phone, '8')) {
                $phone = '+62' . $phone;
            }
            if (str_starts_with($phone, '62') && !str_starts_with($phone, '+62')) {
                $phone = '+' . $phone;
            }
            $request->merge(['nomor_tlpn' => $phone]);
        }

        $validated = $request->validate([
            'nama' => 'required|string|max:50',
            'alamat' => 'required|string|max:100',
            'wilayah' => 'required|string|max:100',
            'nomor_tlpn' => ['required', 'string', 'max:20', 'regex:/^(\+62|08)[0-9]{8,15}$/'],
            'id_paket' => 'required|string|max:5'
        ], [
            'nomor_tlpn.regex' => 'Format nomor HP/WhatsApp harus diawali dengan 08 atau +62.',
        ]);

        do {
            $idPendaftaran = strtoupper(Str::random(5));
        } while (pendaftaran::where('id_pendaftaran', $idPendaftaran)->exists());

        pendaftaran::create([
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
    }

    public function pendaftaranUpdateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,validated,rejected,setup,active,aktif'
        ]);
        
        $pendaftaran = pendaftaran::findOrFail($id);
        $pendaftaran->update(['status' => $validated['status']]);
        
        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'status' => $validated['status']]);
        }
        return redirect()->back()->with('success', 'Status pendaftaran berhasil diperbarui.');
    }

    public function pendaftaranDestroy($id)
    {
        $pendaftaran = pendaftaran::findOrFail($id);
        if ($pendaftaran->path_gambar) {
            Storage::disk('s3')->delete($pendaftaran->path_gambar);
        }
        $pendaftaran->delete();
        return redirect()->back()->with('success', 'Pendaftaran dihapus.');
    }

    public function pendaftaranUpdate(Request $request, $id)
    {
        if ($request->has('nomor_tlpn')) {
            $phone = trim($request->input('nomor_tlpn'));
            $phone = preg_replace('/[^\+0-9]/', '', $phone);
            if (str_starts_with($phone, '8')) {
                $phone = '+62' . $phone;
            }
            if (str_starts_with($phone, '62') && !str_starts_with($phone, '+62')) {
                $phone = '+' . $phone;
            }
            $request->merge(['nomor_tlpn' => $phone]);
        }

        $data = $request->validate([
            'nama' => 'required|string|max:50',
            'alamat' => 'required|string|max:100',
            'wilayah' => 'required|string|max:100',
            'nomor_tlpn' => ['required', 'string', 'max:20', 'regex:/^(\+62|08)[0-9]{8,15}$/'],
            'id_paket' => 'required|string|max:5'
        ], [
            'nomor_tlpn.regex' => 'Format nomor HP/WhatsApp harus diawali dengan 08 atau +62.',
        ]);
        pendaftaran::findOrFail($id)->update($data);
        return redirect()->back()->with('success', 'Data pendaftaran diperbarui.');
    }

    public function pendaftaranExport(Request $request)
    {
        $search = $request->input('search');
        $exportOption = $request->input('export_option', 'all');
        $selectedColumns = $request->input('columns', []);

        $statusFilter = $request->input('filter_status');
        $paketFilter = $request->input('filter_paket');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $sortBy = $request->input('sort_by', 'created_at');
        $sortOrder = $request->input('sort_order', 'desc');

        $query = pendaftaran::with('paket');

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
    }

    public function paketStore(Request $request)
    {
        $validationRules = [
            'id_paket' => 'required|string|unique:pakets,id_paket',
            'title_paket' => 'required|string',
            'harga_paket' => 'required|numeric',
            'id_promosi' => 'nullable|string|exists:promosis,id_promosi',
            'nama_tema' => 'nullable|string',
            'warna_bg' => 'nullable|string',
            'warna_font' => 'nullable|string',
            'font_family' => 'nullable|string',
            'warna_border' => 'nullable|string',
            'warna_button' => 'nullable|string',
            'badge_text' => 'nullable|string',
            'point_informasi' => 'nullable|array',
        ];

        if ($request->boolean('create_announcement')) {
            $validationRules['announcement_id'] = 'required|string|max:5|unique:pengumumans,id_pengumuman';
            $validationRules['announcement_tema'] = 'required|string|max:50';
            $validationRules['announcement_text'] = 'required|string';
            $validationRules['announcement_valid_start'] = 'required|date';
            $validationRules['announcement_valid_end'] = 'required|date';
        }

        $data = $request->validate($validationRules);

        if ($request->boolean('create_announcement')) {
            pengumuman::create([
                'id_pengumuman' => $data['announcement_id'],
                'tema' => $data['announcement_tema'],
                'text_pengumuman' => $data['announcement_text'],
                'valid_start' => $data['announcement_valid_start'],
                'valid_end' => $data['announcement_valid_end'],
            ]);
        }

        paket::create([
            'id_paket' => $data['id_paket'],
            'title_paket' => $data['title_paket'],
            'harga_paket' => $data['harga_paket'],
            'id_promosi' => $data['id_promosi'] ?? null,
            'nama_tema' => $data['nama_tema'] ?? null,
            'warna_bg' => $data['warna_bg'] ?? null,
            'warna_font' => $data['warna_font'] ?? null,
            'font_family' => $data['font_family'] ?? null,
            'warna_border' => $data['warna_border'] ?? null,
            'warna_button' => $data['warna_button'] ?? null,
            'badge_text' => $data['badge_text'] ?? null,
            'point_keunggulan' => $data['point_informasi'] ?? null,
        ]);

        $this->clearHomeCaches();

        return redirect()->back()->with('success', 'Paket ditambahkan.');
    }

    public function paketUpdate(Request $request, $id)
    {
        $data = $request->validate([
            'title_paket' => 'required|string',
            'harga_paket' => 'required|numeric',
            'id_promosi' => 'nullable|string|exists:promosis,id_promosi',
            'nama_tema' => 'nullable|string',
            'warna_bg' => 'nullable|string',
            'warna_font' => 'nullable|string',
            'font_family' => 'nullable|string',
            'warna_border' => 'nullable|string',
            'warna_button' => 'nullable|string',
            'badge_text' => 'nullable|string',
            'point_informasi' => 'nullable|array',
        ]);

        paket::where('id_paket', $id)->firstOrFail()->update([
            'title_paket' => $data['title_paket'],
            'harga_paket' => $data['harga_paket'],
            'id_promosi' => $data['id_promosi'] ?? null,
            'nama_tema' => $data['nama_tema'] ?? null,
            'warna_bg' => $data['warna_bg'] ?? null,
            'warna_font' => $data['warna_font'] ?? null,
            'font_family' => $data['font_family'] ?? null,
            'warna_border' => $data['warna_border'] ?? null,
            'warna_button' => $data['warna_button'] ?? null,
            'badge_text' => $data['badge_text'] ?? null,
            'point_keunggulan' => $data['point_informasi'] ?? null,
        ]);

        $this->clearHomeCaches();

        return redirect()->back()->with('success', 'Paket diperbarui.');
    }

    public function paketDestroy($id)
    {
        try {
            paket::where('id_paket', $id)->delete();
            $this->clearHomeCaches();
            return redirect()->back()->with('success', 'Paket dihapus.');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == '23503') {
                return redirect()->back()->with('error', 'Gagal menghapus paket. Paket ini masih digunakan oleh data pendaftaran.');
            }
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function paketShowRedirect()
    {
        return redirect()->route('admin.index')->withFragment('paket');
    }

    public function paketToggleHide($id)
    {
        $paket = paket::findOrFail($id);
        $paket->update(['is_hidden' => !$paket->is_hidden]);
        $this->clearHomeCaches();
        return redirect()->back()->with('success', 'Status visibilitas paket diperbarui.');
    }

    public function pengumumanStore(Request $request)
    {
        $data = $request->validate([
            'id_pengumuman' => 'required|string|unique:pengumumans,id_pengumuman',
            'text_pengumuman' => 'required|string',
            'tema' => 'nullable|string|max:50',
            'valid_start' => 'nullable|date',
            'valid_end' => 'nullable|date'
        ]);
        pengumuman::create($data);
        $this->clearHomeCaches();
        return redirect()->back()->with('success', 'Pengumuman ditambahkan.');
    }

    public function pengumumanUpdate(Request $request, $id)
    {
        $data = $request->validate([
            'text_pengumuman' => 'required|string',
            'tema' => 'nullable|string|max:50',
            'valid_start' => 'nullable|date',
            'valid_end' => 'nullable|date'
        ]);
        pengumuman::where('id_pengumuman', $id)->firstOrFail()->update($data);
        $this->clearHomeCaches();
        return redirect()->back()->with('success', 'Pengumuman diperbarui.');
    }

    public function pengumumanDestroy($id)
    {
        pengumuman::where('id_pengumuman', $id)->delete();
        $this->clearHomeCaches();
        return redirect()->back()->with('success', 'Pengumuman dihapus.');
    }

    public function pengumumanShowRedirect()
    {
        return redirect()->route('admin.index')->withFragment('pengumuman');
    }

    public function promosiStore(Request $request)
    {
        $data = $request->validate([
            'id_promosi' => 'required|string|unique:promosis,id_promosi',
            'value_promosi' => 'required|numeric',
            'text_promosi' => 'required|string',
            'tema' => 'nullable|string',
            'valid_start' => 'nullable|date',
            'valid_end' => 'nullable|date'
        ]);
        promosi::create($data);
        $this->clearHomeCaches();
        return redirect()->back()->with('success', 'Promosi ditambahkan.');
    }

    public function promosiUpdate(Request $request, $id)
    {
        $data = $request->validate([
            'value_promosi' => 'required|numeric',
            'text_promosi' => 'required|string',
            'tema' => 'nullable|string',
            'valid_start' => 'nullable|date',
            'valid_end' => 'nullable|date'
        ]);
        promosi::where('id_promosi', $id)->firstOrFail()->update($data);
        $this->clearHomeCaches();
        return redirect()->back()->with('success', 'Promosi diperbarui.');
    }

    public function promosiDestroy($id)
    {
        promosi::where('id_promosi', $id)->delete();
        $this->clearHomeCaches();
        return redirect()->back()->with('success', 'Promosi dihapus.');
    }

    public function promosiShowRedirect()
    {
        return redirect()->route('admin.index')->withFragment('promosi');
    }

    public function serverMaintenance(Request $request)
    {
        Artisan::call('down', [
            '--secret' => 'rnet-admin',
            '--render' => 'errors.503'
        ]);
        return $this->jsonOrRedirect($request, 'Mode maintenance diaktifkan. Anda dapat bypass menggunakan URL /rnet-admin');
    }

    public function serverUp(Request $request)
    {
        Artisan::call('up');
        return $this->jsonOrRedirect($request, 'Server kembali online untuk publik.');
    }

    public function serverShutdown(Request $request)
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

    public function profilUpdate(Request $request)
    {
        $data = $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'email'        => 'required|email|max:100',
            'phone'        => 'nullable|string|max:20',
            'alamat'       => 'nullable|string|max:500',
        ]);
        $profil = AdminProfile::first();
        if ($profil) {
            $profil->update($data);
        } else {
            AdminProfile::create(array_merge($data, ['username' => 'admin']));
        }
        return $this->jsonOrRedirect($request, 'Profil admin berhasil diperbarui.');
    }

    public function profilPassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'new_password'     => 'required|string|min:8|confirmed',
        ]);
        $user = Auth::user();
        if (!Hash::check($request->current_password, $user->password)) {
            return $this->jsonOrError($request, ['current_password' => ['Kata sandi saat ini tidak sesuai.']]);
        }
        $user->update(['password' => Hash::make($request->new_password)]);
        return $this->jsonOrRedirect($request, 'Kata sandi berhasil diubah.');
    }

    public function profilPreferences(Request $request)
    {
        $profil = AdminProfile::first();
        if ($profil) {
            $profil->update([
                'email_notif' => $request->boolean('email_notif'),
                'sound_notif' => $request->boolean('sound_notif'),
            ]);
        }
        return $this->jsonOrRedirect($request, 'Preferensi tampilan disimpan.');
    }

    public function profilAvatar(Request $request)
    {
        $request->validate(['avatar' => 'required|file|mimes:jpg,jpeg,png,webp,svg,ico|max:2048']);
        $profil = AdminProfile::first();
        if (!$profil) {
            return $request->ajax()
                ? response()->json(['success' => false, 'message' => 'Profil tidak ditemukan.'], 404)
                : back()->withErrors(['avatar' => 'Profil tidak ditemukan.']);
        }
        
        if ($profil->avatar_path) {
            if (str_contains($profil->avatar_path, 'storage.supabase.co')) {
                try {
                    $s3Path = ltrim(parse_url($profil->avatar_path, PHP_URL_PATH), '/');
                    $bucket = env('S3_BUCKET', 'gambarRumah');
                    if (str_starts_with($s3Path, "storage/v1/s3/")) {
                        $s3Path = str_replace("storage/v1/s3/", "", $s3Path);
                    }
                    if (str_starts_with($s3Path, $bucket . "/")) {
                        $s3Path = substr($s3Path, strlen($bucket) + 1);
                    }
                    Storage::disk('s3')->delete($s3Path);
                } catch (\Exception $e) {}
            } else {
                try {
                    $localPath = str_replace(url('storage/'), '', $profil->avatar_path);
                    Storage::disk('public')->delete(ltrim($localPath, '/'));
                } catch (\Exception $e) {}
            }
        }

        $disk = 's3';
        if (!env('S3_ACCESS_KEY_ID') || !env('S3_SECRET_ACCESS_KEY') || !env('S3_BUCKET')) {
            $disk = 'public';
        }
        try {
            $path = $request->file('avatar')->store('avatars', $disk);
            $url  = Storage::disk($disk)->url($path);
        } catch (\Exception $e) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $url  = Storage::disk('public')->url($path);
        }

        $profil->update(['avatar_path' => $url]);
        return $request->ajax()
            ? response()->json(['success' => true, 'message' => 'Foto profil berhasil diperbarui.', 'avatar_url' => $url])
            : redirect()->back()->with('success', 'Foto profil berhasil diperbarui.');
    }

    public function pengaturanUpdate(Request $request)
    {
        $data = $request->validate([
            'nama_perusahaan'    => 'sometimes|required|string|max:100',
            'email_perusahaan'   => 'nullable|email|max:100',
            'telepon_perusahaan' => 'nullable|string|max:30',
            'alamat_perusahaan'  => 'nullable|string',
            'website'            => 'nullable|url|max:255',
            'npwp'               => 'nullable|string|max:30',
            'primary_color'      => ['nullable', 'string', 'max:10', 'regex:/^#[A-Fa-f0-9]{6}$/'],
            'secondary_color'    => ['nullable', 'string', 'max:10', 'regex:/^#[A-Fa-f0-9]{6}$/'],
            'accent_color'       => ['nullable', 'string', 'max:10', 'regex:/^#[A-Fa-f0-9]{6}$/'],
            'biaya_pasang'       => 'nullable|integer|min:0',
            'estimasi_pasang'    => 'nullable|string|max:50',
            'kelengkapan_pasang' => 'nullable|string',
            'langkah_pasang'     => 'nullable|string',
        ]);
        CompanySetting::getInstance()->update($data);
        $this->clearHomeCaches();
        return $this->jsonOrRedirect($request, 'Informasi perusahaan berhasil diperbarui.');
    }

    public function pengaturanSocial(Request $request)
    {
        $data = $request->validate([
            'facebook'  => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:100',
            'whatsapp'  => 'nullable|string|max:20',
        ]);
        CompanySetting::getInstance()->update($data);
        $this->clearHomeCaches();
        return $this->jsonOrRedirect($request, 'Media sosial berhasil diperbarui.');
    }

    public function pengaturanHours(Request $request)
    {
        $data = $request->validate([
            'jam_buka_weekday'  => 'nullable|date_format:H:i',
            'jam_tutup_weekday' => 'nullable|date_format:H:i',
            'jam_buka_sabtu'    => 'nullable|date_format:H:i',
            'jam_tutup_sabtu'   => 'nullable|date_format:H:i',
        ]);
        $data['buka_minggu'] = $request->boolean('buka_minggu');
        CompanySetting::getInstance()->update($data);
        $this->clearHomeCaches();
        return $this->jsonOrRedirect($request, 'Jam operasional berhasil diperbarui.');
    }

    public function pengaturanLogo(Request $request)
    {
        $request->validate(['logo' => 'required|file|mimes:jpg,jpeg,png,webp,svg,ico|max:2048']);
        $company = CompanySetting::getInstance();
        
        if ($company->logo_path) {
            if (str_contains($company->logo_path, 'storage.supabase.co')) {
                try {
                    $s3Path = ltrim(parse_url($company->logo_path, PHP_URL_PATH), '/');
                    $bucket = env('S3_BUCKET', 'gambarRumah');
                    if (str_starts_with($s3Path, "storage/v1/s3/")) {
                        $s3Path = str_replace("storage/v1/s3/", "", $s3Path);
                    }
                    if (str_starts_with($s3Path, $bucket . "/")) {
                        $s3Path = substr($s3Path, strlen($bucket) + 1);
                    }
                    Storage::disk('s3')->delete($s3Path);
                } catch (\Exception $e) {}
            } else {
                try {
                    $localPath = str_replace(url('storage/'), '', $company->logo_path);
                    Storage::disk('public')->delete(ltrim($localPath, '/'));
                } catch (\Exception $e) {}
            }
        }

        $disk = 's3';
        if (!env('S3_ACCESS_KEY_ID') || !env('S3_SECRET_ACCESS_KEY') || !env('S3_BUCKET')) {
            $disk = 'public';
        }
        try {
            $path = $request->file('logo')->store('logos', $disk);
            $url  = Storage::disk($disk)->url($path);
        } catch (\Exception $e) {
            $path = $request->file('logo')->store('logos', 'public');
            $url  = Storage::disk('public')->url($path);
        }

        $company->update(['logo_path' => $url]);
        $this->clearHomeCaches();
        return $request->ajax()
            ? response()->json(['success' => true, 'message' => 'Logo berhasil diperbarui.', 'logo_url' => $url])
            : redirect()->back()->with('success', 'Logo perusahaan berhasil diperbarui.');
    }

    public function pengaturanLogoDelete(Request $request)
    {
        $company = CompanySetting::getInstance();
        if ($company->logo_path) {
            if (str_contains($company->logo_path, 'storage.supabase.co')) {
                try {
                    $s3Path = ltrim(parse_url($company->logo_path, PHP_URL_PATH), '/');
                    $bucket = env('S3_BUCKET', 'gambarRumah');
                    if (str_starts_with($s3Path, "storage/v1/s3/")) {
                        $s3Path = str_replace("storage/v1/s3/", "", $s3Path);
                    }
                    if (str_starts_with($s3Path, $bucket . "/")) {
                        $s3Path = substr($s3Path, strlen($bucket) + 1);
                    }
                    Storage::disk('s3')->delete($s3Path);
                } catch (\Exception $e) {}
            } else {
                try {
                    $localPath = str_replace(url('storage/'), '', $company->logo_path);
                    Storage::disk('public')->delete(ltrim($localPath, '/'));
                } catch (\Exception $e) {}
            }
            $company->update(['logo_path' => null]);
        }
        $this->clearHomeCaches();
        return $this->jsonOrRedirect($request, 'Logo perusahaan berhasil dihapus.');
    }

    public function areaStore(Request $request)
    {
        $data = $request->validate([
            'nama_area' => 'required|string|max:100',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'radius' => 'required|integer|min:1',
        ]);
        $area = AreaLayanan::create(array_merge($data, ['is_active' => true]));
        $this->clearHomeCaches();
        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Area layanan ditambahkan.', 'area' => $area]);
        }
        return redirect()->back()->with('success', 'Area layanan ditambahkan.');
    }

    public function areaUpdate(Request $request, $id)
    {
        $data = $request->validate([
            'nama_area' => 'required|string|max:100',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'radius' => 'required|integer|min:1',
            'is_active' => 'boolean'
        ]);
        AreaLayanan::findOrFail($id)->update($data);
        $this->clearHomeCaches();
        return $this->jsonOrRedirect($request, 'Area layanan diperbarui.');
    }

    public function areaToggleHide($id)
    {
        $area = AreaLayanan::findOrFail($id);
        $area->update(['is_active' => !$area->is_active]);
        $this->clearHomeCaches();
        return redirect()->back()->with('success', 'Status visibilitas area diperbarui.');
    }

    public function areaDestroy(Request $request, $id)
    {
        AreaLayanan::findOrFail($id)->delete();
        $this->clearHomeCaches();
        return $this->jsonOrRedirect($request, 'Area layanan dihapus.');
    }

    public function areaShowRedirect()
    {
        return redirect()->route('admin.index')->withFragment('wilayah');
    }

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

    public function apiNotifications()
    {
        $notifications = AdminNotification::recent(20)->get()->map(fn($n) => [
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
        $unread = AdminNotification::unread()->count();
        return response()->json(['notifications' => $notifications, 'unread' => $unread]);
    }

    public function apiNotificationRead($id)
    {
        $notif = AdminNotification::findOrFail($id);
        $notif->markRead();
        $unread = AdminNotification::unread()->count();
        return response()->json(['success' => true, 'unread' => $unread]);
    }

    public function apiNotificationsReadAll()
    {
        AdminNotification::unread()->update(['read_at' => now()]);
        return response()->json(['success' => true, 'unread' => 0]);
    }

    public function apiNotificationsClear()
    {
        AdminNotification::whereNotNull('read_at')->delete();
        $unread = AdminNotification::unread()->count();
        return response()->json(['success' => true, 'unread' => $unread]);
    }

    public function userStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,teknisi,pengguna'
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role']
        ]);

        if ($validated['role'] === 'admin') {
            AdminProfile::create([
                'user_id' => $user->id,
                'nama_lengkap' => $user->name,
                'username' => 'admin_' . $user->id,
                'email' => $user->email,
                'role' => 'Administrator',
            ]);
        }

        return redirect()->back()->with('success', 'User berhasil ditambahkan.');
    }

    public function userUpdate(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:admin,teknisi,pengguna',
            'password' => 'nullable|string|min:6'
        ]);

        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role']
        ];

        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $user->update($updateData);

        if ($user->role === 'admin') {
            $profil = AdminProfile::where('user_id', $user->id)->first();
            if ($profil) {
                $profil->update([
                    'nama_lengkap' => $user->name,
                    'email' => $user->email,
                ]);
            } else {
                AdminProfile::create([
                    'user_id' => $user->id,
                    'nama_lengkap' => $user->name,
                    'username' => 'admin_' . $user->id,
                    'email' => $user->email,
                    'role' => 'Administrator',
                ]);
            }
        }

        return redirect()->back()->with('success', 'User berhasil diperbarui.');
    }

    public function userDestroy($id)
    {
        if (Auth::id() == $id) {
            return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'User berhasil dihapus.');
    }
}
