<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\pendaftaran;
use App\Models\CompanySetting;
use Illuminate\Support\Facades\Auth;

class TechnicianController extends Controller
{
    public function dashboard()
    {
        $activeTasks = pendaftaran::with('paket')
            ->whereIn('status', ['validated', 'setup'])
            ->orderBy('created_at', 'desc')
            ->get();
            
        $completedTasks = pendaftaran::with('paket')
            ->where('status', 'active')
            ->where('installed_by', Auth::id())
            ->orderBy('installed_at', 'desc')
            ->get();
            
        $company = CompanySetting::getInstance();
        return view('teknisi.dashboard', compact('activeTasks', 'completedTasks', 'company'));
    }

    public function installStore(Request $request, $id)
    {
        $pendaftaran = pendaftaran::findOrFail($id);
        $validated = $request->validate([
            'pon_sn' => 'required|string|max:100',
            'wifi_name' => 'required|string|max:100',
            'wifi_password' => 'required|string|max:100',
        ]);

        $pendaftaran->update([
            'status' => 'active',
            'pon_sn' => $validated['pon_sn'],
            'wifi_name' => $validated['wifi_name'],
            'wifi_password' => $validated['wifi_password'],
            'installed_by' => Auth::id(),
            'installed_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Instalasi berhasil didokumentasikan dan status pendaftaran aktif.');
    }
}
