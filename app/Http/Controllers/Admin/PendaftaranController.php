<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\pendaftaran;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PendaftaranController extends Controller
{
    /**
     * [FITUR] Menyimpan data pendaftaran baru yang dibuat oleh admin ke dalam database.
     */
    public function store(Request $request)
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
            'wilayah' => 'required|string|max:100',
            'nomor_tlpn' => ['required', 'string', 'max:20', 'regex:/^(\+62|08)[0-9]{8,15}$/'],
            'id_paket' => 'required|string|max:5'
        ], [
            'nomor_tlpn.regex' => 'Format nomor HP/WhatsApp harus diawali dengan 08 atau +62.',
        ]);

        do {
            $idPendaftaran = strtoupper(Str::random(5));
        } while (pendaftaran::where('id_pendaftaran', $idPendaftaran)->exists());

        pendaftaran::create([
            'id_pendaftaran' => $idPendaftaran,
            'nama' => $validated['nama'],
            'alamat' => $validated['alamat'],
            'wilayah' => $validated['wilayah'],
            'nomor_tlpn' => $validated['nomor_tlpn'],
            'id_paket' => $validated['id_paket'],
            'status' => 'pending',
            'latitude' => 0,
            'longtitude' => 0,
            'path_gambar' => null
        ]);

        return redirect()->back()->with('success', 'Pendaftaran baru berhasil ditambahkan.');
    }

    /**
     * [FITUR] Memperbarui status pendaftaran pelanggan tertentu.
     */
    public function updateStatus(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,validated,rejected,setup,active,aktif'
        ]);
        
        $pendaftaran = pendaftaran::findOrFail($id);
        $pendaftaran->update(['status' => $validated['status']]);
        
        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'status' => $validated['status']]);
        }
        return redirect()->back()->with('success', 'Status pendaftaran berhasil diperbarui.');
    }

    /**
     * [FITUR] Menghapus data pendaftaran tertentu dan berkas gambarnya di S3 jika ada.
     */
    public function destroy($id)
    {
        $pendaftaran = pendaftaran::findOrFail($id);
        if ($pendaftaran->path_gambar) {
            Storage::disk('s3')->delete($pendaftaran->path_gambar);
        }
        $pendaftaran->delete();
        return redirect()->back()->with('success', 'Pendaftaran dihapus.');
    }

    /**
     * [FITUR] Memperbarui data informasi pendaftaran pelanggan tertentu.
     */
    public function update(Request $request, $id)
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

        $data = $request->validate([
            'nama' => 'required|string|max:50',
            'alamat' => 'required|string|max:100',
            'wilayah' => 'required|string|max:100',
            'nomor_tlpn' => ['required', 'string', 'max:20', 'regex:/^(\+62|08)[0-9]{8,15}$/'],
            'id_paket' => 'required|string|max:5'
        ], [
            'nomor_tlpn.regex' => 'Format nomor HP/WhatsApp harus diawali dengan 08 atau +62.',
        ]);
        pendaftaran::findOrFail($id)->update($data);
        return redirect()->back()->with('success', 'Data pendaftaran diperbarui.');
    }

    /**
     * [FITUR] Mengekspor data pendaftaran (semua/terfilter) ke berkas CSV dengan kolom pilihan.
     */
    public function export(Request $request)
    {
        $search = $request->input('search');
        $exportOption = $request->input('export_option', 'all');
        $selectedColumns = $request->input('columns', []);

        $statusFilter = $request->input('filter_status');
        $paketFilter = $request->input('filter_paket');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $sortBy = $request->input('sort_by', 'created_at');
        $sortOrder = $request->input('sort_order', 'desc');

        $query = pendaftaran::with('paket');

        if ($exportOption === 'filtered') {
            if (!empty($search)) {
                $query->where(function($q) use ($search) {
                    $q->where('id_pendaftaran', 'LIKE', "%{$search}%")
                      ->orWhere('nama', 'LIKE', "%{$search}%")
                      ->orWhere('nomor_tlpn', 'LIKE', "%{$search}%")
                      ->orWhere('wilayah', 'LIKE', "%{$search}%")
                      ->orWhere('alamat', 'LIKE', "%{$search}%")
                      ->orWhereHas('paket', function($pq) use ($search) {
                          $pq->where('title_paket', 'LIKE', "%{$search}%");
                      });
                });
            }

            if (!empty($statusFilter)) {
                $query->where('status', $statusFilter);
            }

            if (!empty($paketFilter)) {
                $query->where('id_paket', $paketFilter);
            }

            if (!empty($startDate)) {
                $query->whereDate('created_at', '>=', $startDate);
            }

            if (!empty($endDate)) {
                $query->whereDate('created_at', '<=', $endDate);
            }
        }

        $allowedSort = ['created_at', 'status', 'id_paket', 'nama'];
        $sortBy = in_array($sortBy, $allowedSort) ? $sortBy : 'created_at';
        $sortOrder = in_array(strtolower($sortOrder), ['asc', 'desc']) ? strtolower($sortOrder) : 'desc';

        $query->orderBy($sortBy, $sortOrder);

        $records = $query->get();

        $columnMap = [
            'id_pendaftaran' => 'ID Pendaftaran',
            'nama'           => 'Nama Lengkap',
            'nomor_tlpn'     => 'No. Telepon / WA',
            'wilayah'        => 'Wilayah',
            'alamat'         => 'Alamat Pemasangan',
            'latitude'       => 'Latitude',
            'longtitude'     => 'Longitude',
            'paket'          => 'Paket Layanan',
            'harga'          => 'Harga Paket',
            'status'         => 'Status',
            'created_at'     => 'Tanggal Daftar',
        ];

        $filename = "data_pendaftaran_" . date('Ymd_His') . ".csv";

        $headers = [
            "Content-Type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=\"$filename\"",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use ($records, $selectedColumns, $columnMap) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF)); // UTF-8 BOM

            $headerRow = [];
            foreach ($selectedColumns as $colKey) {
                if (isset($columnMap[$colKey])) {
                    $headerRow[] = $columnMap[$colKey];
                }
            }
            fputcsv($file, $headerRow);

            foreach ($records as $row) {
                $dataRow = [];
                foreach ($selectedColumns as $colKey) {
                    switch ($colKey) {
                        case 'id_pendaftaran':
                            $dataRow[] = $row->id_pendaftaran;
                            break;
                        case 'nama':
                            $dataRow[] = $row->nama;
                            break;
                        case 'nomor_tlpn':
                            $dataRow[] = $row->nomor_tlpn;
                            break;
                        case 'wilayah':
                            $dataRow[] = $row->wilayah;
                            break;
                        case 'alamat':
                            $dataRow[] = $row->alamat;
                            break;
                        case 'latitude':
                            $dataRow[] = $row->latitude;
                            break;
                        case 'longtitude':
                            $dataRow[] = $row->longtitude;
                            break;
                        case 'paket':
                            $dataRow[] = $row->paket ? $row->paket->title_paket : $row->id_paket;
                            break;
                        case 'harga':
                            $dataRow[] = $row->paket ? $row->paket->harga_paket : 0;
                            break;
                        case 'status':
                            $dataRow[] = ucfirst($row->status);
                            break;
                        case 'created_at':
                            $dataRow[] = $row->created_at->format('Y-m-d H:i:s');
                            break;
                    }
                }
                fputcsv($file, $dataRow);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
