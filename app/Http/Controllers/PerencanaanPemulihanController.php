<?php

namespace App\Http\Controllers;

use App\Exports\PerencanaanPemulihanExport;
use App\Models\PerencanaanPemulihan;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PerencanaanPemulihanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $years = PerencanaanPemulihan::selectRaw('YEAR(created_at) as year')
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->pluck('year');

        $selectedYear = $request->query('year');

        if ($selectedYear) {
            $perencanaanPemulihans = PerencanaanPemulihan::whereYear('created_at', $selectedYear)->get();
        } else {
            $perencanaanPemulihans = PerencanaanPemulihan::all();
        }

        return view('admin.perencanaanpemulihan.index', compact('perencanaanPemulihans', 'years', 'selectedYear'));
    }

    public function exportToExcel(Request $request)
    {
        $selectedYear = $request->query('year');

        if ($selectedYear) {
            return Excel::download(new PerencanaanPemulihanExport($selectedYear), 'perencanaan_pemulihan_' . $selectedYear . '.xlsx');
        } else {
            // Handle jika tahun tidak dipilih
            return redirect()->route('perencanaanpemulihan.index')
                ->with('error', 'Tahun harus dipilih untuk mengekspor data.');
        }
    }

    public function create()
    {
        return view('admin.perencanaanpemulihan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'tahun_dokumen_rpe' => 'nullable|integer',
            'metode_pe' => 'nullable',
            'target_pe' => 'nullable|numeric',
        ]);

        // Create a new PerencanaanPemulihan instance
        PerencanaanPemulihan::create($validatedData);

        return redirect()->route('perencanaanpemulihan.index')
            ->with('success', 'Data perencanaan pemulihan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $perencanaanPemulihan = PerencanaanPemulihan::findOrFail($id);
        return view('admin.perencanaanpemulihan.edit', compact('perencanaanPemulihan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'tahun_dokumen_rpe' => 'nullable|integer',
            'metode_pe' => 'nullable',
            'target_pe' => 'nullable|numeric',
            'keterangan' => 'nullable',
        ]);
        $perencanaanPemulihan = PerencanaanPemulihan::findOrFail($id);

        // Perbarui data PerencanaanPemulihan
        $perencanaanPemulihan->update($request->all());

        return redirect()->route('perencanaanpemulihan.index')
            ->with('success', 'Data perencanaan pemulihan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $perencanaanPemulihan = PerencanaanPemulihan::find($id);
        $perencanaanPemulihan->delete();
        return redirect()->route('perencanaanpemulihan.index')
            ->with('success', 'Data perencanaan pemulihan berhasil dihapus.');
    }
}
