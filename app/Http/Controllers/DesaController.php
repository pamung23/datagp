<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use App\Models\Kecamatan;
use Illuminate\Http\Request;

class DesaController extends Controller
{
    public function __construct()
    {
        // Middleware 'checkrole:Admin,Balai' akan dijalankan untuk semua metode kecuali 'show'
        $this->middleware('checkrole:Admin,Balai')->except(['show']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $desa = Desa::all();
        return view('admin.desa.index', compact('desa'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kecamatan = Kecamatan::all();
        return view('admin.desa.create', compact('kecamatan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required',
            'kecamatan_id' => 'required|exists:kecamatans,id',
        ]);
        Desa::create($data);
        return redirect()->route('desa.index')->with('success', 'Sukses Tambah Data');
    }

    /**
     * Display the specified resource.
     */
    public function show(Desa $desa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Desa $desa)
    {
        $kecamatan = Kecamatan::all();
        return view('admin.desa.edit', compact('desa', 'kecamatan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Desa $desa)
    {
        $request->validate([
            'nama' => 'required',
            'kecamatan_id' => 'required|exists:kecamatans,id',
        ]);

        $desa->update($request->all());

        return redirect()->route('desa.index')->with('success', 'Sukses Edit Data');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Desa::findOrFail($id)->delete();
        return redirect()->route('desa.index')
            ->with('success', 'Berhasil Delete Data');
    }
}
