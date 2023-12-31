<?php

namespace App\Http\Controllers;

use App\Models\Hewan;
use Illuminate\Http\Request;

class HewanController extends Controller
{
    public function showMap()
    {
        $data = Hewan::select('latitude', 'longitude', 'nama', 'bulan', 'resort')->get();

        return view('admin.hewan.peta', compact('data')); // Replace 'your.view.name' with your actual view name
    }
    public function index()
    {
        $data = Hewan::all();
        return view('admin.hewan.index', compact('data'));
    }

    public function create()
    {
        return view('admin.hewan.create');
    }

    public function store(Request $request)
    {
        Hewan::create($request->all());
        return redirect()->route('hewan.index')
            ->with('success', 'Data pengambilan hasil hutan berhasil ditambahkan');
    }

    public function edit(Hewan $hewan)
    {
        return view('admin.hewan.edit', compact('hewan'));
    }

    public function update(Request $request, Hewan $hewan)
    {
        $hewan->update($request->all());
        return redirect()->route('hewan.index')
            ->with('success', 'Data pengambilan hasil hutan berhasil diperbarui');
    }

    public function destroy(Hewan $hewan)
    {
        $hewan->delete();
        return redirect()->route('hewan.index')
            ->with('success', 'Data pengambilan hasil hutan berhasil dihapus');
    }
}
