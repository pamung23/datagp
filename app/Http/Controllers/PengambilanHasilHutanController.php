<?php

namespace App\Http\Controllers;

use App\Models\PengambilanHasilHutan;
use Illuminate\Http\Request;

class PengambilanHasilHutanController extends Controller
{
    public function showMap()
    {
        $data = PengambilanHasilHutan::select('latitude', 'longitude', 'nama', 'bulan', 'resort')->get();

        return view('admin.pengambilanhasilhutan.peta', compact('data')); // Replace 'your.view.name' with your actual view name
    }
    public function index()
    {
        $data = PengambilanHasilHutan::all();
        return view('admin.pengambilanhasilhutan.index', compact('data'));
    }

    public function create()
    {
        return view('admin.pengambilanhasilhutan.create');
    }

    public function store(Request $request)
    {
        PengambilanHasilHutan::create($request->all());
        return redirect()->route('pengambilanhasilhutan.index')
            ->with('success', 'Data pengambilan hasil hutan berhasil ditambahkan');
    }

    public function edit(PengambilanHasilHutan $pengambilanHasilHutan)
    {
        return view('admin.pengambilanhasilhutan.edit', compact('pengambilanHasilHutan'));
    }

    public function update(Request $request, PengambilanHasilHutan $pengambilanHasilHutan)
    {
        $pengambilanHasilHutan->update($request->all());
        return redirect()->route('pengambilanhasilhutan.index')
            ->with('success', 'Data pengambilan hasil hutan berhasil diperbarui');
    }

    public function destroy(PengambilanHasilHutan $pengambilanHasilHutan)
    {
        $pengambilanHasilHutan->delete();
        return redirect()->route('pengambilanhasilhutan.index')
            ->with('success', 'Data pengambilan hasil hutan berhasil dihapus');
    }
}
