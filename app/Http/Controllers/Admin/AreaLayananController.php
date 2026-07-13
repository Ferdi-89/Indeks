<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Concerns\HasAdminHelpers;
use Illuminate\Http\Request;
use App\Models\AreaLayanan;

class AreaLayananController extends Controller
{
    use HasAdminHelpers;

    /**
     * [FITUR] Menyimpan wilayah layanan baru ke dalam database.
     */
    public function store(Request $request)
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

    /**
     * [FITUR] Memperbarui detail wilayah layanan tertentu dalam database.
     */
    public function update(Request $request, $id)
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

    /**
     * [FITUR] Beralih status keaktifan/visibilitas wilayah layanan tertentu.
     */
    public function toggleHide($id)
    {
        $area = AreaLayanan::findOrFail($id);
        $area->update(['is_active' => !$area->is_active]);
        $this->clearHomeCaches();
        return redirect()->back()->with('success', 'Status visibilitas area diperbarui.');
    }

    /**
     * [FITUR] Menghapus wilayah layanan tertentu dari database.
     */
    public function destroy(Request $request, $id)
    {
        AreaLayanan::findOrFail($id)->delete();
        $this->clearHomeCaches();
        return $this->jsonOrRedirect($request, 'Area layanan dihapus.');
    }

    /**
     * [FITUR] Mengalihkan ke dashboard admin pada bagian tab wilayah layanan.
     */
    public function showRedirect()
    {
        return redirect()->route('admin.index')->withFragment('wilayah');
    }
}
