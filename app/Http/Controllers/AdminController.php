<?php

namespace App\Http\Controllers;

use App\Services\SupabaseService;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    protected SupabaseService $supabase;

    public function __construct(SupabaseService $supabase)
    {
        $this->supabase = $supabase;
    }

    // ========== DASHBOARD ==========
    public function dashboard()
    {
        $pendaftaran = $this->supabase->get('pendaftaran');
        $promotions  = $this->supabase->get('promosi');
        $messages    = $this->supabase->get('pesan');

        $stats = [
            'total_pendaftaran' => count($pendaftaran),
            'total_promosi'     => count($promotions),
            'total_pesan'       => count($messages),
            'aktif_promosi'     => count(array_filter($promotions, fn($p) => $p['visibility'] ?? false)),
        ];

        return view('admin.dashboard', compact('stats', 'pendaftaran', 'promotions', 'messages'));
    }

    // ========== PENDAFTARAN ==========
    public function pendaftaranIndex()
    {
        $pendaftaran = $this->supabase->get('pendaftaran', ['order' => 'id_pendaftaran.desc']);
        return view('admin.pendaftaran.index', compact('pendaftaran'));
    }

    public function pendaftaranShow(string $id)
    {
        $data = $this->supabase->find('pendaftaran', 'id_pendaftaran', $id);
        return view('admin.pendaftaran.show', compact('data'));
    }

    public function pendaftaranDestroy(string $id)
    {
        $this->supabase->delete('pendaftaran', 'id_pendaftaran', $id);
        return redirect()->route('admin.pendaftaran')->with('success', 'Data pendaftaran berhasil dihapus.');
    }

    // ========== PROMOSI ==========
    public function promosiIndex()
    {
        $promotions = $this->supabase->get('promosi', ['order' => 'start_valid.desc']);
        return view('admin.promosi.index', compact('promotions'));
    }

    public function promosiCreate()
    {
        return view('admin.promosi.form', ['promosi' => null]);
    }

    public function promosiStore(Request $request)
    {
        $request->validate([
            'judul_promosi' => 'required|string|max:255',
            'isi_promosi'   => 'required|string',
            'value_promosi' => 'required|integer|min:0|max:100',
            'start_valid'   => 'required|date',
            'end_valid'     => 'required|date|after_or_equal:start_valid',
            'tema'          => 'required|string',
        ]);

        $data = [
            'id_promosi'    => 'PR-' . strtoupper(substr(uniqid(), -6)),
            'judul_promosi' => $request->judul_promosi,
            'isi_promosi'   => $request->isi_promosi,
            'value_promosi' => (int) $request->value_promosi,
            'start_valid'   => $request->start_valid,
            'end_valid'     => $request->end_valid,
            'tema'          => $request->tema,
            'visibility'    => $request->has('visibility'),
        ];

        $this->supabase->insert('promosi', $data);
        return redirect()->route('admin.promosi')->with('success', 'Promosi berhasil ditambahkan!');
    }

    public function promosiEdit(string $id)
    {
        $promosi = $this->supabase->find('promosi', 'id_promosi', $id);
        return view('admin.promosi.form', compact('promosi'));
    }

    public function promosiUpdate(Request $request, string $id)
    {
        $request->validate([
            'judul_promosi' => 'required|string|max:255',
            'isi_promosi'   => 'required|string',
            'value_promosi' => 'required|integer|min:0|max:100',
            'start_valid'   => 'required|date',
            'end_valid'     => 'required|date|after_or_equal:start_valid',
            'tema'          => 'required|string',
        ]);

        $data = [
            'judul_promosi' => $request->judul_promosi,
            'isi_promosi'   => $request->isi_promosi,
            'value_promosi' => (int) $request->value_promosi,
            'start_valid'   => $request->start_valid,
            'end_valid'     => $request->end_valid,
            'tema'          => $request->tema,
            'visibility'    => $request->has('visibility'),
        ];

        $this->supabase->update('promosi', 'id_promosi', $id, $data);
        return redirect()->route('admin.promosi')->with('success', 'Promosi berhasil diperbarui!');
    }

    public function promosiDestroy(string $id)
    {
        $this->supabase->delete('promosi', 'id_promosi', $id);
        return redirect()->route('admin.promosi')->with('success', 'Promosi berhasil dihapus.');
    }

    // ========== PESAN ==========
    public function pesanIndex()
    {
        $messages = $this->supabase->get('pesan', ['order' => 'id_pesan.desc']);
        return view('admin.pesan.index', compact('messages'));
    }

    public function pesanCreate()
    {
        return view('admin.pesan.form', ['pesan' => null]);
    }

    public function pesanStore(Request $request)
    {
        $request->validate([
            'pesan'     => 'required|string',
            'tema'      => 'required|string|max:100',
            'type_view' => 'required|string|max:100',
        ]);

        $data = [
            'id_pesan'  => 'PS-' . strtoupper(substr(uniqid(), -6)),
            'pesan'     => $request->pesan,
            'tema'      => $request->tema,
            'type_view' => $request->type_view,
            'visibility' => $request->has('visibility'),
        ];

        $this->supabase->insert('pesan', $data);
        return redirect()->route('admin.pesan')->with('success', 'Pesan berhasil ditambahkan!');
    }

    public function pesanEdit(string $id)
    {
        $pesan = $this->supabase->find('pesan', 'id_pesan', $id);
        return view('admin.pesan.form', compact('pesan'));
    }

    public function pesanUpdate(Request $request, string $id)
    {
        $request->validate([
            'pesan'     => 'required|string',
            'tema'      => 'required|string|max:100',
            'type_view' => 'required|string|max:100',
        ]);

        $data = [
            'pesan'     => $request->pesan,
            'tema'      => $request->tema,
            'type_view' => $request->type_view,
            'visibility' => $request->has('visibility'),
        ];

        $this->supabase->update('pesan', 'id_pesan', $id, $data);
        return redirect()->route('admin.pesan')->with('success', 'Pesan berhasil diperbarui!');
    }

    public function pesanDestroy(string $id)
    {
        $this->supabase->delete('pesan', 'id_pesan', $id);
        return redirect()->route('admin.pesan')->with('success', 'Pesan berhasil dihapus.');
    }
}
