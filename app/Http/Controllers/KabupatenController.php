<?php

namespace App\Http\Controllers;

use App\Models\Kabupaten;
use Illuminate\Http\Request;

class KabupatenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        // Apply 'checkrole:Admin,Balai' middleware only for specific methods
        $this->middleware('checkrole:Admin,Balai')->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);
    }

    public function index()
    {
        $kabupaten = Kabupaten::all();
        return view('admin.kabupaten.index', compact('kabupaten'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.kabupaten.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
        ]);
        Kabupaten::create($data);
        return redirect()->route('kabupaten.index')->with('success', 'Sukses Menambahkan Data');
    }

    /**
     * Display the specified resource.
     */
    public function show(kabupaten $kabupaten)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $kabupaten = Kabupaten::findOrfail($id);
        return view('admin.kabupaten.edit', compact('kabupaten'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',

        ]);
        Kabupaten::where('id', $id)->update($data);

        return redirect()->route('kabupaten.index')
            ->with('success', 'Sukses Update Data');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Kabupaten::findOrFail($id)->delete();
        return redirect()->route('kabupaten.index')
            ->with('success', 'Sukses Delete Data');
    }
}
