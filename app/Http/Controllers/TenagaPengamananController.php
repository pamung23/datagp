<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TenagaPengamanan1;
use App\Models\TenagaPengamanan2;
use App\Models\TenagaPengamanan3;
use App\Models\TenagaPengamanan4;

class TenagaPengamananController extends Controller
{
    protected $modelMapping = [
        1 => TenagaPengamanan1::class,
        2 => TenagaPengamanan2::class,
        3 => TenagaPengamanan3::class,
        4 => TenagaPengamanan4::class,
    ];

    public function index(Request $request)
    {
        $triwulan = $request->input('triwulan', 1);

        $model = $this->modelMapping[$triwulan] ?? TenagaPengamanan1::class;

        $tenagaPengamanan = $model::all();

        return view('admin.tenaga_pengaman.index', compact('tenagaPengamanan', 'triwulan'));
    }

    public function create($triwulan)
    {
        $model = $this->modelMapping[$triwulan] ?? null;
        if (!$model) {
            return redirect()->route('tenaga_pengaman.index.triwulan', ['triwulan' => $triwulan])->with('error', 'Triwulan tidak valid.');
        }
        return view('admin.tenaga_pengaman.create', compact('triwulan', 'model'));
    }

    public function store(Request $request)
    {
        $triwulan = $request->input('triwulan', 1);

        $model = $this->modelMapping[$triwulan] ?? null;

        if (!$model) {
            return redirect()->route('tenaga_pengaman.index.triwulan', ['triwulan' => $triwulan])->with('error', 'Triwulan tidak valid.');
        }

        $data = $request->validate([
            'satker_id' => 'required|integer',
            'polhut' => 'required|integer',
            'ppns' => 'required|integer',
            'tphl' => 'required|integer',
            'mmp' => 'required|integer',
            'keterangan' => 'required',
        ]);

        // Simpan nilai Triwulan bersama dengan data
        $data['triwulan'] = $triwulan;

        $model::create($data);

        // Arahkan pengguna kembali ke indeks triwulan yang sesuai
        return redirect()->route('tenaga_pengaman.index.triwulan', ['triwulan' => $triwulan])->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit($triwulan, $id)
    {
        $model = $this->modelMapping[$triwulan] ?? null;

        if (!$model) {
            return redirect()->route('tenaga_pengaman.index', ['triwulan' => $triwulan])->with('error', 'Triwulan tidak valid.');
        }

        $data = $model::findOrFail($id);

        return view('admin.tenaga_pengaman.edit', compact('triwulan', 'data'));
    }

    public function update(Request $request, $triwulan, $id)
    {
        $triwulan = $request->input('triwulan', 1);

        $model = $this->modelMapping[$triwulan] ?? null;

        if (!$model) {
            return redirect()->route('tenaga_pengaman.index', ['triwulan' => $triwulan])->with('error', 'Triwulan tidak valid.');
        }

        $data = $request->validate([
            'satker_id' => 'required|integer',
            'polhut' => 'required|integer',
            'ppns' => 'required|integer',
            'tphl' => 'required|integer',
            'mmp' => 'required|integer',
            'keterangan' => 'required',
        ]);

        // Temukan data yang akan diperbarui berdasarkan ID
        $dataToUpdate = $model::findOrFail($id);

        // Perbarui data dengan data yang valid
        $dataToUpdate->update($data);

        // Arahkan pengguna kembali ke indeks triwulan yang sesuai
        return redirect()->route('tenaga_pengaman.index', ['triwulan' => $triwulan])->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($triwulan, $id)
    {
        $model = $this->modelMapping[$triwulan] ?? TenagaPengamanan1::class;

        // Temukan data yang akan dihapus berdasarkan ID
        $dataToDelete = $model::findOrFail($id);

        // Hapus data
        $dataToDelete->delete();

        return redirect()->route('tenaga_pengaman.index', ['triwulan' => $triwulan])->with('success', 'Data berhasil dihapus.');
    }
}
