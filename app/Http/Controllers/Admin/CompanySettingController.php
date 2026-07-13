<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Concerns\HasAdminHelpers;
use Illuminate\Http\Request;
use App\Models\CompanySetting;
use Illuminate\Support\Facades\Storage;

class CompanySettingController extends Controller
{
    use HasAdminHelpers;

    /**
     * [FITUR] Memperbarui pengaturan dasar perusahaan dan tata letak warna dashboard.
     */
    public function update(Request $request)
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

    /**
     * [FITUR] Memperbarui tautan media sosial perusahaan.
     */
    public function social(Request $request)
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

    /**
     * [FITUR] Memperbarui parameter jam operasional kerja perusahaan.
     */
    public function hours(Request $request)
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

    /**
     * [FITUR] Mengunggah dan memperbarui logo gambar perusahaan ke local/S3.
     */
    public function logo(Request $request)
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

    /**
     * [FITUR] Menghapus logo gambar perusahaan dari local/S3.
     */
    public function logoDelete(Request $request)
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
}
