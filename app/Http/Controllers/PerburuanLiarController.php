<?php

namespace App\Http\Controllers;

use App\Models\PerburuanLiar;
use Illuminate\Http\Request;

class PerburuanLiarController extends Controller
{
    public function showMap()
    {
        $data = PerburuanLiar::select('latitude', 'longitude', 'nama', 'bulan', 'resort')->get();

        return view('admin.perburuanliar.peta', compact('data')); // Replace 'your.view.name' with your actual view name
    }
    public function index()
    {
        $data = PerburuanLiar::all();
        return view('admin.perburuanliar.index', compact('data'));
    }

    public function create()
    {
        return view('admin.perburuanliar.create');
    }

    public function store(Request $request)
    {
        PerburuanLiar::create($request->all());
        return redirect()->route('perburuanliar.index')
            ->with('success', 'Data pengambilan hasil hutan berhasil ditambahkan');
    }

    public function edit(PerburuanLiar $PerburuanLiar)
    {
        return view('admin.perburuanliar.edit', compact('PerburuanLiar'));
    }

    public function update(Request $request, PerburuanLiar $PerburuanLiar)
    {
        $PerburuanLiar->update($request->all());
        return redirect()->route('perburuanliar.index')
            ->with('success', 'Data pengambilan hasil hutan berhasil diperbarui');
    }

    public function destroy(PerburuanLiar $PerburuanLiar)
    {
        $PerburuanLiar->delete();
        return redirect()->route('perburuanliar.index')
            ->with('success', 'Data pengambilan hasil hutan berhasil dihapus');
    }
}
