<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\Concerns\HasAdminHelpers;
use Illuminate\Http\Request;
use App\Models\promosi;

class PromosiController extends Controller
{
    use HasAdminHelpers;

    /**
     * [FITUR] Menyimpan promosi baru ke dalam database.
     */
    public function store(Request $request)
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

    /**
     * [FITUR] Memperbarui detail promosi tertentu dalam database.
     */
    public function update(Request $request, $id)
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

    /**
     * [FITUR] Menghapus promosi tertentu dari database.
     */
    public function destroy($id)
    {
        promosi::where('id_promosi', $id)->delete();
        $this->clearHomeCaches();
        return redirect()->back()->with('success', 'Promosi dihapus.');
    }

    /**
     * [FITUR] Mengalihkan ke dashboard admin pada bagian tab promosi.
     */
    public function showRedirect()
    {
        return redirect()->route('admin.index')->withFragment('promosi');
    }
}
