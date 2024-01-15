<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\resort;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::all();
        $resort = resort::all();
        return view('admin.user.index', compact('user', 'resort'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $resorts = resort::all();
        return view('admin.user.create', compact('resorts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_lengkap' => 'required',
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'hp' => 'required|string|unique:users',
            'password' => 'required',
            'level' => 'required',
            'blokir' => 'nullable',
            'resort_id' => 'nullable|exists:resorts,id',
        ]);

        // Hash the password before saving it
        $data['password'] = Hash::make($data['password']);
        User::create($data);
        return redirect()->route('user.index')->with('success', 'Sukses Tambah Data.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::findOrfail($id);
        $resorts = resort::all();
        return view('admin.user.edit', compact('user', 'resorts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'nama_lengkap' => 'required',
            'username' => 'required|unique:users,username,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
            'hp' => 'required|numeric|unique:users,hp,' . $id,
            'password' => 'required',
            'level' => 'required',
            'blokir' => 'nullable',
            'resort_id' => 'nullable|exists:resorts,id',
        ]);
        $data['password'] = Hash::make($data['password']);
        User::where('id', $id)->update($data);

        return redirect()->route('user.index')
            ->with('success', 'Data berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        User::findOrFail($id)->delete();
        return redirect()->route('user.index')
            ->with('danger', 'Data berhasil dihapus.');
    }
}
