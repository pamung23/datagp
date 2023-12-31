<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Desa;
use NumberFormatter;
use Illuminate\Http\Request;

use App\Models\KemitraanKonservasi;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\KemitraanKonservasiExport;
use Illuminate\Support\Facades\Validator;


class KemitraanKonservasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $years = KemitraanKonservasi::selectRaw('YEAR(created_at) as year')
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->pluck('year');

        $selectedYear = $request->query('year');

        if ($selectedYear) {
            $kemitraanKonservasis = KemitraanKonservasi::with('desa')
                ->whereYear('created_at', $selectedYear)
                ->get();
        } else {
            $kemitraanKonservasis = KemitraanKonservasi::with('desa')->get();
        }

        return view('admin.kemitraankonservasi.index', compact('kemitraanKonservasis', 'years', 'selectedYear'));
    }

    public function exportToExcel(Request $request)
    {
        $selectedYear = $request->query('year');

        if ($selectedYear) {
            return Excel::download(new KemitraanKonservasiExport($selectedYear), 'kemitraan_konservasi_' . $selectedYear . '.xlsx');
        } else {
            // Handle jika tahun tidak dipilih
            return redirect()->route('kemitraankonservasi.index')
                ->with('error', 'Tahun harus dipilih untuk mengekspor data.');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $desas = Desa::all();
        return view('admin.kemitraankonservasi.create', compact('desas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'desa_id' => 'required',
            'nama_kelompok' => 'required',
            'jumlah_anggota' => 'required|numeric',
            'luas_pks' => 'required|numeric',
            'zona_blok' => 'required',
            'bentuk_kemitraan' => 'required',
            'nilai_ekonomi_per_tahun' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Mengisi nomor register secara otomatis

        $kemitraankonservasi = new KemitraanKonservasi();
        $kemitraankonservasi->desa_id = $request->desa_id;
        $kemitraankonservasi->nama_kelompok = $request->nama_kelompok;
        $kemitraankonservasi->jumlah_anggota = $request->jumlah_anggota;
        $kemitraankonservasi->luas_pks = $request->luas_pks;
        $kemitraankonservasi->zona_blok = $request->zona_blok;
        $kemitraankonservasi->bentuk_kemitraan = $request->bentuk_kemitraan;
        $kemitraankonservasi->nilai_ekonomi_per_tahun = $request->nilai_ekonomi_per_tahun;
        $kemitraankonservasi->keterangan = $request->keterangan;
        $kemitraankonservasi->save();

        return redirect()->route('kemitraankonservasi.index')->with('success', 'Data Kemitraan Konservasi berhasil disimpan.');
    }

    public function edit($id)
    {
        $kemitraankonservasi = KemitraanKonservasi::findOrFail($id);
        $desas = Desa::all(); // Sesuaikan dengan model Desa yang Anda gunakan

        return view('admin.kemitraankonservasi.edit', compact('kemitraankonservasi', 'desas'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'desa_id' => 'required',
            'nama_kelompok' => 'required',
            'jumlah_anggota' => 'required|numeric',
            'luas_pks' => 'required|numeric',
            'zona_blok' => 'required',
            'bentuk_kemitraan' => 'required',
            'nilai_ekonomi_per_tahun' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }



        $kemitraankonservasi = KemitraanKonservasi::findOrFail($id);
        $kemitraankonservasi->desa_id = $request->desa_id;
        $kemitraankonservasi->nama_kelompok = $request->nama_kelompok;
        $kemitraankonservasi->jumlah_anggota = $request->jumlah_anggota;
        $kemitraankonservasi->luas_pks = $request->luas_pks;
        $kemitraankonservasi->zona_blok = $request->zona_blok;
        $kemitraankonservasi->bentuk_kemitraan = $request->bentuk_kemitraan;
        $kemitraankonservasi->nilai_ekonomi_per_tahun = $request->nilai_ekonomi_per_tahun;
        $kemitraankonservasi->keterangan = $request->keterangan;
        $kemitraankonservasi->save();

        return redirect()->route('kemitraankonservasi.index')->with('success', 'Data Kemitraan Konservasi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $kemitraanKonservasi = KemitraanKonservasi::findOrFail($id);
        $kemitraanKonservasi->delete();
        return redirect()->route('kemitraankonservasi.index')
            ->with('success', 'Data kemitraan konservasi berhasil dihapus.');
    }
}
