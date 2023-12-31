<?php

namespace App\Http\Controllers;

use App\Exports\PemanfaatnZonaBlokExport;
use App\Models\Desa;
use Illuminate\Http\Request;
use App\Models\PemanfaatanZonaBlok;
use Maatwebsite\Excel\Facades\Excel;

class PemanfaatanZonaBlokController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $years = PemanfaatanZonaBlok::selectRaw('YEAR(created_at) as year')
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->pluck('year');

        $selectedYear = $request->query('year');

        if ($selectedYear) {
            $PemanfaatanZonaBlok = PemanfaatanZonaBlok::whereYear('created_at', $selectedYear)->get();
        } else {
            $PemanfaatanZonaBlok = PemanfaatanZonaBlok::all();
        }
        return view('admin.pemanfaatanzona.index', compact('PemanfaatanZonaBlok', 'years', 'selectedYear'));
    }

    public function exportToExcel(Request $request)
    {
        $selectedYear = $request->query('year');

        if ($selectedYear) {
            return Excel::download(new PemanfaatnZonaBlokExport($selectedYear), 'pemanfaatan_zona_blok_' . $selectedYear . '.xlsx');
        } else {
            // Handle jika tahun tidak dipilih
            return redirect()->route('pemanfaatanzona.index')
                ->with('error', 'Tahun harus dipilih untuk mengekspor data.');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $desas = Desa::all();
        return view('admin.pemanfaatanzona.create', compact('desas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_desa' => 'required|exists:desas,id',
            'nama_kelompok' => 'required|string|max:255',
            'anggota' => 'required|integer',
            'luas' => 'required|numeric',
            'potensi' => 'required|string',
            'nilai_ekonomi_per_tahun' => 'nullable|numeric',
            'keterangan' => 'nullable|string',
        ]);

        PemanfaatanZonaBlok::create($request->all());

        return redirect()->route('pemanfaatanzona.index')
            ->with('success', 'Data Pemanfaatan Zona Blok berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PemanfaatanZonaBlok $pemanfaatanZonaBlok)
    {
        return view('admin.pemanfaatanzona.show', compact('pemanfaatanZonaBlok'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $pemanfaatanZonaBlok = PemanfaatanZonaBlok::findOrfail($id);
        $desas = Desa::all();
        return view('admin.pemanfaatanzona.edit', compact('pemanfaatanZonaBlok', 'desas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'id_desa' => 'required|exists:desas,id',
            'nama_kelompok' => 'required|string|max:255',
            'anggota' => 'required|integer',
            'luas' => 'required|numeric',
            'potensi' => 'required|string',
            'nilai_ekonomi_per_tahun' => 'nullable|numeric',
            'keterangan' => 'nullable|string',
        ]);

        PemanfaatanZonaBlok::where('id', $id)->update($data);

        return redirect()->route('pemanfaatanzona.index')
            ->with('success', 'Data Pemanfaatan Zona Blok berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        PemanfaatanZonaBlok::findOrFail($id)->delete();

        return redirect()->route('pemanfaatanzona.index')
            ->with('success', 'Data Pemanfaatan Zona Blok berhasil dihapus.');
    }
}
