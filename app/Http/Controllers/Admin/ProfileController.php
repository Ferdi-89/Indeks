<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Concerns\HasAdminHelpers;
use Illuminate\Http\Request;
use App\Models\AdminProfile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    use HasAdminHelpers;

    /**
     * [FITUR] Memperbarui data profil pribadi milik admin.
     */
    public function update(Request $request)
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

    /**
     * [FITUR] Memperbarui kata sandi akun admin.
     */
    public function password(Request $request)
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

    /**
     * [FITUR] Memperbarui preferensi tampilan atau notifikasi bagi admin.
     */
    public function preferences(Request $request)
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

    /**
     * [FITUR] Mengunggah dan memperbarui foto profil (avatar) admin ke local/S3.
     */
    public function avatar(Request $request)
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
}
