<?php

namespace App\Http\Controllers;

use App\Services\SupabaseService;
use Illuminate\Http\Request;

class PageController extends Controller
{
    protected SupabaseService $supabase;

    public function __construct(SupabaseService $supabase)
    {
        $this->supabase = $supabase;
    }

    public function index()
    {
        // Get active promotions (visibility = true, within date range)
        $today = now()->format('Y-m-d');
        $promotions = $this->supabase->get('promosi', [
            'visibility' => 'eq.true',
            'start_valid' => 'lte.' . $today,
            'end_valid'   => 'gte.' . $today,
        ]);

        // Get active messages
        $messages = $this->supabase->get('pesan', [
            'visibility' => 'eq.true',
        ]);

        return view('landing', compact('promotions', 'messages'));
    }

    public function pendaftaran()
    {
        return view('pendaftaran');
    }

    public function storePendaftaran(Request $request)
    {
        $request->validate([
            'nama'        => 'required|string|max:255',
            'alamat'      => 'required|string',
            'no_telepon'  => 'required|string|max:20',
            'koordinat'   => 'nullable|string',
            'paket'       => 'required|string',
        ]);

        // Handle image upload to storage if provided
        $imagePath = null;
        if ($request->hasFile('l_gambar')) {
            $file = $request->file('l_gambar');
            $imagePath = $file->store('pendaftaran', 'public');
        }

        $data = [
            'id_pendaftaran' => 'PD-' . strtoupper(substr(uniqid(), -6)),
            'nama'           => $request->nama,
            'alamat'         => $request->alamat,
            'no_telepon'     => $request->no_telepon,
            'koordinat'      => $request->koordinat,
            'paket'          => $request->paket,
            'l_gambar'       => $imagePath,
        ];

        $result = $this->supabase->insert('pendaftaran', $data);

        return redirect()->route('pendaftaran.success')->with('success', 'Pendaftaran berhasil dikirim! Tim kami akan segera menghubungi Anda.');
    }

    public function pendaftaranSuccess()
    {
        return view('pendaftaran_success');
    }
}
