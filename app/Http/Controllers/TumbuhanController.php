<?php

namespace App\Http\Controllers;

use App\Models\Tumbuhan;
use Illuminate\Http\Request;

class TumbuhanController extends Controller
{
    public function showMap()
    {
        $data = Tumbuhan::select('latitude', 'longitude', 'nama', 'bulan', 'resort')->get();

        return view('admin.tumbuhan.peta', compact('data')); // Replace 'your.view.name' with your actual view name
    }
    public function index()
    {
        $data = Tumbuhan::all();
        return view('admin.tumbuhan.index', compact('data'));
    }

    public function create()
    {
        return view('admin.tumbuhan.create');
    }

    public function store(Request $request)
    {
        Tumbuhan::create($request->all());
        return redirect()->route('tumbuhan.index')
            ->with('success', 'Data pengambilan hasil hutan berhasil ditambahkan');
    }

    public function edit(Tumbuhan $tumbuhan)
    {
        return view('admin.tumbuhan.edit', compact('tumbuhan'));
    }

    public function update(Request $request, Tumbuhan $tumbuhan)
    {
        $tumbuhan->update($request->all());
        return redirect()->route('tumbuhan.index')
            ->with('success', 'Data pengambilan hasil hutan berhasil diperbarui');
    }

    public function destroy(Tumbuhan $tumbuhan)
    {
        $tumbuhan->delete();
        return redirect()->route('tumbuhan.index')
            ->with('success', 'Data pengambilan hasil hutan berhasil dihapus');
    }
}
