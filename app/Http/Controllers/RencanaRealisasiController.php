<?php

namespace App\Http\Controllers;

use App\Models\RencanaRealisasi;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RencanaRealisasiExport;

class RencanaRealisasiController extends Controller
{
    public function index(Request $request)
    {
        // Mengambil tahun-tahun yang tersedia
        $years = RencanaRealisasi::selectRaw('YEAR(created_at) as year')
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->pluck('year');

        // Mengambil tahun yang dipilih dari query parameter
        $selectedYear = $request->query('year');

        // Mengambil data rencana realisasi berdasarkan tahun yang dipilih (jika ada)
        if ($selectedYear) {
            $rencanaRealisasis = RencanaRealisasi::whereYear('created_at', $selectedYear)->get();
        } else {
            // Jika tahun tidak dipilih, ambil semua data rencana realisasi
            $rencanaRealisasis = RencanaRealisasi::all();
        }

        // Mengirim data ke view
        return view('admin.rencanarealisasi.index', compact('rencanaRealisasis', 'years', 'selectedYear'));
    }


    public function exportToExcel(Request $request)
    {
        $selectedYear = $request->query('year');

        if ($selectedYear) {
            return Excel::download(new RencanaRealisasi($selectedYear), 'rencana_realisasi_' . $selectedYear . '.xlsx');
        } else {
            // Handle jika tahun tidak dipilih
            return redirect()->route('rencanarealisasi.index')
                ->with('error', 'Tahun harus dipilih untuk mengekspor data.');
        }
    }

    public function create()
    {
        return view('admin.rencanarealisasi.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'sumber_pembiayaan' => 'required',
            'metode_pe' => 'required',
            'target_ha' => 'required|numeric',
            'luas_ha' => 'required|numeric',
            'persentase_keberhasilan' => 'nullable|numeric',
            'sumber_keberhasilan' => 'nullable|required_if:metode_pe,Restorasi',

        ]);

        RencanaRealisasi::create($validatedData);

        return redirect()->route('rencanarealisasi.index')
            ->with('success', 'Rencana Realisasi Pemulihan Ekosistem berhasil ditambahkan.');
    }
    public function edit($id)
    {
        $rencanaRealisasi = RencanaRealisasi::findOrFail($id);
        return view('admin.rencanarealisasi.edit', compact('rencanaRealisasi'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'sumber_pembiayaan' => 'required',
            'metode_pe' => 'required',
            'target_ha' => 'required|numeric',
            'luas_ha' => 'required|numeric',
            'persentase_keberhasilan' => 'nullable|numeric',
            'sumber_keberhasilan' => 'nullable|required_if:metode_pe,Restorasi',
            'keterangan' => 'nullable',
        ]);

        RencanaRealisasi::where('id', $id)->update($validatedData);

        return redirect()->route('rencanarealisasi.index')
            ->with('success', 'Data Rencana Realisasi Pemulihan Ekosistem berhasil diperbarui.');
    }

    public function destroy($id)
    {
        RencanaRealisasi::findOrFail($id)->delete();
        return redirect()->route('rencanarealisasi.index')
            ->with('success', 'Data Rencana Realisasi Pemulihan Ekosistem berhasil dihapus.');
    }
}
