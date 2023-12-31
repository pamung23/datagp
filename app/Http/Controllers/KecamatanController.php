<?php

namespace App\Http\Controllers;

use App\Models\Kabupaten;
use App\Models\Kecamatan;
use Illuminate\Http\Request;

class KecamatanController extends Controller
{
    public function index()
    {
        $kecamatan = Kecamatan::all();
        return view('admin.kecamatan.index', compact('kecamatan'));
    }

    public function create()
    {
        $kabupatens = Kabupaten::all();
        return view('admin.kecamatan.create', compact('kabupatens'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'kabupaten_id' => 'required|exists:kabupatens,id',
        ]);

        Kecamatan::create($request->all());

        return redirect()->route('kecamatan.index')->with('success', 'Sukses Menambahkan Data');
    }

    public function edit(Kecamatan $kecamatan)
    {
        $kabupatens = Kabupaten::all();
        return view('admin.kecamatan.edit', compact('kecamatan', 'kabupatens'));
    }

    public function update(Request $request, Kecamatan $kecamatan)
    {
        $request->validate([
            'nama' => 'required',
            'kabupaten_id' => 'required|exists:kabupatens,id',
        ]);

        $kecamatan->update($request->all());

        return redirect()->route('kecamatan.index')->with('success', 'Sukses Update Data');
    }

    public function destroy(Kecamatan $kecamatan)
    {
        $kecamatan->delete();

        return redirect()->route('kecamatan.index')->with('success', 'Sukses Delete Data');
    }
}
