<?php

namespace App\Http\Controllers;

use App\Exports\DaerahPenyanggaExport;
use App\Models\Desa;
use Illuminate\Http\Request;
use App\Models\DaerahPenyangga;
use Maatwebsite\Excel\Facades\Excel;

class DaerahPenyanggaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $years = DaerahPenyangga::selectRaw('YEAR(created_at) as year')
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->pluck('year');

        $selectedYear = $request->query('year');

        if ($selectedYear) {
            $daerahPenyanggas = DaerahPenyangga::whereYear('created_at', $selectedYear)->get();
        } else {
            $daerahPenyanggas = DaerahPenyangga::all();
        }

        return view('admin.daerahpenyangga.index', compact('daerahPenyanggas', 'years', 'selectedYear'));
    }
    public function exportToExcel(Request $request)
    {
        $selectedYear = $request->query('year');

        if ($selectedYear) {
            return Excel::download(new DaerahPenyanggaExport($selectedYear), 'daerah_penyangga_' . $selectedYear . '.xlsx');
        } else {
            // Handle jika tahun tidak dipilih
            return redirect()->route('daerahpenyangga.index')
                ->with('error', 'Tahun harus dipilih untuk mengekspor data.');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $desas = Desa::all();
        return view('admin.daerahpenyangga.create', compact('desas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_desa' => 'required',
            'keterangan' => 'nullable',
        ]);

        DaerahPenyangga::create($request->all());

        return redirect()->route('daerahpenyangga.index')
            ->with('success', 'Data daerah penyangga berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(DaerahPenyangga $daerahPenyangga)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $daerahpenyangga = DaerahPenyangga::findOrfail($id);
        $desas = Desa::all();
        return view('admin.daerahpenyangga.edit', compact('daerahpenyangga', 'desas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'id_desa' => 'required',
            'keterangan' => 'nullable',
        ]);

        DaerahPenyangga::where('id', $id)->update($data);

        return redirect()->route('daerahpenyangga.index')
            ->with('success', 'Data daerah penyangga berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        DaerahPenyangga::findOrFail($id)->delete();
        return redirect()->route('daerahpenyangga.index')
            ->with('success', 'Data daerah penyangga berhasil dihapus.');
    }
}
