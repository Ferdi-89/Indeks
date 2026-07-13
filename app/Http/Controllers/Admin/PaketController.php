<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Concerns\HasAdminHelpers;
use Illuminate\Http\Request;
use App\Models\paket;
use App\Models\pengumuman;

class PaketController extends Controller
{
    use HasAdminHelpers;

    /**
     * [FITUR] Menyimpan paket baru ke dalam database beserta opsi pengumuman otomatis.
     */
    public function store(Request $request)
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

    /**
     * [FITUR] Memperbarui detail paket tertentu dalam database.
     */
    public function update(Request $request, $id)
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

    /**
     * [FITUR] Menghapus paket tertentu jika tidak sedang digunakan oleh data pendaftaran.
     */
    public function destroy($id)
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

    /**
     * [FITUR] Mengalihkan ke dashboard admin pada bagian tab paket.
     */
    public function showRedirect()
    {
        return redirect()->route('admin.index')->withFragment('paket');
    }

    /**
     * [FITUR] Beralih status visibilitas (tampilkan/sembunyikan) paket tertentu.
     */
    public function toggleHide($id)
    {
        $paket = paket::findOrFail($id);
        $paket->update(['is_hidden' => !$paket->is_hidden]);
        $this->clearHomeCaches();
        return redirect()->back()->with('success', 'Status visibilitas paket diperbarui.');
    }
}
