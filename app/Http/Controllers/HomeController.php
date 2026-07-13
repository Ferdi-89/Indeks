<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\pengumuman;
use App\Models\paket;
use App\Models\AreaLayanan;
use App\Models\CompanySetting;
use App\Models\pendaftaran;
use App\Models\AdminNotification;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        $pengumuman = Cache::remember('home_pengumuman', 3600, function() {
            $arr = pengumuman::pluck('text_pengumuman')->toArray();
            return empty($arr) ? ['Selamat datang dan Pilihlah paket anda :> '] : $arr;
        });

        $pakets = Cache::remember('home_pakets', 3600, function() {
            return paket::with('promosi')->where('is_hidden', false)->orderBy('id_paket', 'asc')->get();
        });

        $areaLayanan = Cache::remember('home_area_layanan', 3600, function() {
            return AreaLayanan::where('is_active', true)->get();
        });

        $company = CompanySetting::getInstance();

        return view('welcome', compact('pengumuman', 'pakets', 'areaLayanan', 'company'));
    }

    public function daftarForm()
    {
        $pakets = Cache::remember('daftar_pakets', 3600, function() {
            return paket::where('is_hidden', false)->orderBy('id_paket', 'asc')->get();
        });

        $areaLayanan = Cache::remember('daftar_area_layanan', 3600, function() {
            return AreaLayanan::where('is_active', true)->get();
        });

        $company = CompanySetting::getInstance();
        return view('pendaftaran', compact('pakets', 'areaLayanan', 'company'));
    }

    public function daftarStore(Request $request)
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
            'latitude' => 'nullable|numeric',
            'longtitude' => 'nullable|numeric',
            'wilayah' => 'required|string|max:100',
            'nomor_tlpn' => ['required', 'string', 'max:20', 'regex:/^(\+62|08)[0-9]{8,15}$/'],
            'path_gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'id_paket' => 'required|string|max:5'
        ], [
            'nomor_tlpn.regex' => 'Format nomor HP/WhatsApp harus diawali dengan 08 atau +62.',
        ]);

        do {
            $idPendaftaran = strtoupper(Str::random(5));
        } while (pendaftaran::where('id_pendaftaran', $idPendaftaran)->exists());

        try {
            $filePath = null;
            if ($request->hasFile('path_gambar')) {
                $file = $request->file('path_gambar');
                $originalName = $file->getClientOriginalName();
                $extension = strtolower($file->getClientOriginalExtension());
                $fileName = time() . '_' . preg_replace('/[^A-Za-z0-9\-]/', '', pathinfo($originalName, PATHINFO_FILENAME)) . '.' . $extension;
                
                $filePath = $file->storeAs('pendaftaran', $fileName, 's3');
            }

            pendaftaran::create([
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

            try {
                AdminNotification::createFromPendaftaran($idPendaftaran, $validated['nama']);
            } catch (\Exception $ignored) {}

            return redirect('/daftar')->with('sukses', true);

        } catch (\Exception $e) {
            return back()->withInput()->withErrors([
                'error' => 'Terjadi kesalahan saat memproses pendaftaran: ' . $e->getMessage()
            ]);
        }
    }

    public function cekStatusIndex()
    {
        $company = CompanySetting::getInstance();
        return view('cek-status', compact('company'));
    }

    public function cekStatusApi($id)
    {
        $cleanId = strtoupper(trim($id));
        $pendaftaran = pendaftaran::with('paket')->where('id_pendaftaran', $cleanId)->first();

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
    }
}
