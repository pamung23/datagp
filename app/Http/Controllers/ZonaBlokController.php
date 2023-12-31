<?php

namespace App\Http\Controllers;

use App\Exports\ZonaBlokExport;
use App\Models\Desa;
use App\Models\ZonaBlok;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ZonaBlokController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $years = ZonaBlok::selectRaw('YEAR(created_at) as year')
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->pluck('year');

        $selectedYear = $request->query('year');

        if ($selectedYear) {
            $zonablok = ZonaBlok::whereYear('created_at', $selectedYear)->get();
        } else {
            $zonablok = ZonaBlok::all();
        }
        return view('admin.zonablok.index', compact('zonablok', 'years', 'selectedYear'));
    }

    public function exportToExcel(Request $request)
    {
        $selectedYear = $request->query('year');

        if ($selectedYear) {
            return Excel::download(new ZonaBlokExport($selectedYear), 'zona_blok_' . $selectedYear . '.xlsx');
        } else {
            // Handle jika tahun tidak dipilih
            return redirect()->route('zonablok.index')
                ->with('error', 'Tahun harus dipilih untuk mengekspor data.');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $desas = Desa::all();
        return view('admin.zonablok.create', compact('desas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data yang masuk
        $request->validate([
            'id_desa' => 'required|exists:desas,id',
            'luas_ha' => 'required|numeric',
            'keterangan' => 'nullable|string',
        ]);

        // Buat objek ZonaBlok baru
        ZonaBlok::create([
            'id_desa' => $request->id_desa,
            'luas_ha' => $request->luas_ha,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('zonablok.index')->with('success', 'Data Zona/Blok berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $zonablok = ZonaBlok::findOrfail($id);
        $desas = Desa::all();
        return view('admin.zonablok.edit', compact('zonablok', 'desas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'id_desa' => 'required|exists:desas,id',
            'luas_ha' => 'required|numeric',
            'keterangan' => 'nullable|string',
        ]);

        // Perbarui data ZonaBlok
        ZonaBlok::where('id', $id)->update($data);

        return redirect()->route('zonablok.index')->with('success', 'Data Zona/Blok berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ZonaBlok $zonablok)
    {
        $zonablok->delete();
        return redirect()->route('zonablok.index')->with('success', 'Data Zona/Blok berhasil dihapus.');
    }
}
