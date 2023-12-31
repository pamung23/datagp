<?php

namespace App\Http\Controllers;

use App\Models\PenebanganLiar;
use Illuminate\Http\Request;

class PenebanganLiarController extends Controller
{
    public function showMap()
    {
        $data = PenebanganLiar::select('latitude', 'longitude', 'nama', 'bulan', 'resort')->get();

        return view('admin.penebanganliar.peta', compact('data')); // Replace 'your.view.name' with your actual view name
    }
    public function index()
    {
        $data = PenebanganLiar::all();
        return view('admin.penebanganliar.index', compact('data'));
    }

    public function create()
    {
        return view('admin.penebanganliar.create');
    }

    public function store(Request $request)
    {
        PenebanganLiar::create($request->all());
        return redirect()->route('penebanganliar.index')
            ->with('success', 'Data pengambilan hasil hutan berhasil ditambahkan');
    }

    public function edit(PenebanganLiar $PenebanganLiar)
    {
        return view('admin.penebanganliar.edit', compact('PenebanganLiar'));
    }

    public function update(Request $request, PenebanganLiar $PenebanganLiar)
    {
        $PenebanganLiar->update($request->all());
        return redirect()->route('penebanganliar.index')
            ->with('success', 'Data pengambilan hasil hutan berhasil diperbarui');
    }

    public function destroy(PenebanganLiar $PenebanganLiar)
    {
        $PenebanganLiar->delete();
        return redirect()->route('penebanganliar.index')
            ->with('success', 'Data pengambilan hasil hutan berhasil dihapus');
    }
}
