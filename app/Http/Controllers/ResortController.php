<?php

namespace App\Http\Controllers;

use App\Models\resort;
use Illuminate\Http\Request;

class ResortController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $resort = resort::all();
        return view('admin.resort.index', compact('resort'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.resort.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
        ]);
        resort::create($data);
        return redirect()->route('resort.index')->with('success', 'Sukses Tambah Data.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $resort = Resort::findOrfail($id);
        return view('admin.resort.edit', compact('resort'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
        ]);
        resort::where('id', $id)->update($data);

        return redirect()->route('resort.index')
            ->with('success', 'Data berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        resort::findOrFail($id)->delete();
        return redirect()->route('resort.index')
            ->with('danger', 'Data berhasil dihapus.');
    }
}
