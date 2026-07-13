<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Concerns\HasAdminHelpers;
use Illuminate\Http\Request;
use App\Models\pengumuman;

class PengumumanController extends Controller
{
    use HasAdminHelpers;

    /**
     * [FITUR] Menyimpan pengumuman baru ke dalam database.
     */
    public function store(Request $request)
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

    /**
     * [FITUR] Memperbarui detail pengumuman tertentu dalam database.
     */
    public function update(Request $request, $id)
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

    /**
     * [FITUR] Menghapus pengumuman tertentu dari database.
     */
    public function destroy($id)
    {
        pengumuman::where('id_pengumuman', $id)->delete();
        $this->clearHomeCaches();
        return redirect()->back()->with('success', 'Pengumuman dihapus.');
    }

    /**
     * [FITUR] Mengalihkan ke dashboard admin pada bagian tab pengumuman.
     */
    public function showRedirect()
    {
        return redirect()->route('admin.index')->withFragment('pengumuman');
    }
}
