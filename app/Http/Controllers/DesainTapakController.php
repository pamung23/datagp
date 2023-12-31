<?php

namespace App\Http\Controllers;

use App\Models\DesainTapak;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DesainTapakExport;

class DesainTapakController extends Controller
{
    public function index(Request $request)
    {
        $years = DesainTapak::selectRaw('YEAR(created_at) as year')
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->pluck('year');

        $selectedYear = $request->query('year');

        if ($selectedYear) {
            $desainTapaks = DesainTapak::whereYear('created_at', $selectedYear)->get();
        } else {
            $desainTapaks = DesainTapak::all();
        }

        return view('admin.desaintapak.index', compact('desainTapaks', 'years', 'selectedYear'));
    }

    public function exportToExcel(Request $request)
    {
        $selectedYear = $request->query('year');

        if ($selectedYear) {
            return Excel::download(new DesainTapakExport($selectedYear), 'desain_tapaks_' . $selectedYear . '.xlsx');
        } else {
            // Handle jika tahun tidak dipilih
            return redirect()->route('desaintapak.index')
                ->with('error', 'Tahun harus dipilih untuk mengekspor data.');
        }
    }


    public function create()
    {
        return view('admin.desaintapak.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'nama_zona_blok_pemanfaatan' => 'required|string|max:255',
            'luas_zona_blok_pemanfaatan' => 'required|numeric',
            'ruang_publik' => 'required|numeric',
            'ruang_usaha' => 'required|numeric',
        ]);
        DesainTapak::create($request->all());

        return redirect()->route('desaintapak.index')->with('success', 'Data successfully added.');
    }


    public function edit($id)
    {
        $desainTapak = DesainTapak::findOrFail($id);
        return view('admin.desaintapak.edit', compact('desainTapak'));
    }

    public function update(Request $request, $desainTapaks)
    {

        $request->validate([
            'nama_zona_blok_pemanfaatan' => 'required|string|max:255',
            'luas_zona_blok_pemanfaatan' => 'required|numeric',
            'ruang_publik' => 'required|numeric',
            'ruang_usaha' => 'required|numeric',
            'keterangan' => 'nullable|string|max:255',
        ]);

        DesainTapak::find($desainTapaks)->update($request->all());

        return redirect()->route('desaintapak.index')->with('success', 'Data berhasil diperbarui');
    }

    public function destroy($id)
    {
        $desainTapaks = DesainTapak::findOrFail($id);
        $desainTapaks->delete();

        return redirect()->route('desaintapak.index')->with('success', 'Data berhasil dihapus');
    }
}
