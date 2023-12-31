<?php

namespace App\Http\Controllers;

use App\Exports\DesaBinaanExport;
use App\Models\Desa;
use App\Models\DesaBinaan;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DesaBinaanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $years = DesaBinaan::selectRaw('YEAR(created_at) as year')
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->pluck('year');

        $selectedYear = $request->query('year');

        if ($selectedYear) {
            $desaBinaan = DesaBinaan::whereYear('created_at', $selectedYear)->get();
        } else {
            $desaBinaan = DesaBinaan::all();
        }
        return view('admin.desabinaans.index', compact('desaBinaan', 'years', 'selectedYear'));
    }

    public function exportToExcel(Request $request)
    {
        $selectedYear = $request->query('year');

        if ($selectedYear) {
            return Excel::download(new DesaBinaanExport($selectedYear), 'desa_binaan_' . $selectedYear . '.xlsx');
        } else {
            // Handle jika tahun tidak dipilih
            return redirect()->route('desabinaans.index')
                ->with('error', 'Tahun harus dipilih untuk mengekspor data.');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $desas = Desa::all();
        return view('admin.desabinaans.create', compact('desas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'id_desa' => 'required',
            'nama_kelompok' => 'required',
            'keterangan' => 'nullable',
        ]);

        // Simpan data ke dalam database
        DesaBinaan::create($request->all());

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('desabinaans.index')->with('success', 'Desa Binaan berhasil dibuat.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $desaBinaan = DesaBinaan::findOrfail($id);
        $desas = Desa::all();
        return view('admin.desabinaans.edit', compact('desaBinaan', 'desas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'id_desa' => 'required',
            'nama_kelompok' => 'required',
            'keterangan' => 'nullable',
        ]);

        // Simpan data ke dalam database
        DesaBinaan::where('id', $id)->update($data);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('desabinaans.index')->with('success', 'Desa Binaan berhasil dibuat.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Hapus data dari database
        DesaBinaan::findOrFail($id)->delete();
        return redirect()->route('desabinaans.index')
            ->with('success', 'Data desa binaan berhasil dihapus.');
    }
}
