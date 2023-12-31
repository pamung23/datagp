<?php

namespace App\Http\Controllers;

use App\Exports\PenangananPerkaraExport;
use Illuminate\Http\Request;
use App\Models\PenangananPerkara1;
use App\Models\PenangananPerkara2;
use App\Models\PenangananPerkara3;
use App\Models\PenangananPerkara4;
use Maatwebsite\Excel\Facades\Excel;

class PenangananPerkaraController extends Controller
{
    protected $modelMapping = [
        1 => PenangananPerkara1::class,
        2 => PenangananPerkara2::class,
        3 => PenangananPerkara3::class,
        4 => PenangananPerkara4::class,
    ];

    public function index(Request $request)
    {
        $triwulan = $request->input('triwulan', 1);
        $year = $request->input('year'); // Get the selected year from the request
        $modelsToQuery = [];

        // Ambil level pengguna saat ini
        $userLevel = auth()->user()->level;

        // Inisialisasi array level yang diizinkan mengakses semua triwulan
        $levelsAllowedForAllTriwulan = ['Admin', 'Balai'];

        if (in_array($userLevel, $levelsAllowedForAllTriwulan)) {
            // Jika level pengguna adalah 'Admin' atau 'Balai', perbolehkan akses ke semua triwulan
            foreach ($this->modelMapping as $model) {
                $modelsToQuery[] = new $model;
            }
        } elseif (in_array($userLevel, ['Wilayah Cianjur', 'Wilayah Sukabumi', 'Wilayah Bogor'])) {
            // Jika level pengguna adalah 'Wilayah Cianjur', 'Wilayah Sukabumi', atau 'Wilayah Bogor',
            // batasi akses hanya ke triwulan yang dipilih dan resort yang sesuai
            $model = $this->modelMapping[$triwulan] ?? PenangananPerkara1::class;
            $modelsToQuery[] = new $model;
        }

        $penangananPerkara = collect();

        foreach ($modelsToQuery as $model) {
            $query = $model::query()->with('user.resort');

            if ($year) {
                $query->whereYear('created_at', $year);
            }

            // Jika level pengguna adalah 'Wilayah Cianjur', 'Wilayah Sukabumi', atau 'Wilayah Bogor',
            // tambahkan kondisi untuk membatasi berdasarkan resort
            if (in_array($userLevel, ['Wilayah Cianjur', 'Wilayah Sukabumi', 'Wilayah Bogor'])) {
                $query->whereHas('user.resort', function ($subquery) use ($userLevel) {
                    $subquery->where('nama', auth()->user()->resort->nama);
                });
            }

            $penangananPerkara = $penangananPerkara->merge($query->get());
        }

        $uniqueYears = collect();

        foreach ($modelsToQuery as $model) {
            $years = $model::selectRaw('YEAR(created_at) as year')
                ->distinct()
                ->orderBy('year', 'desc')
                ->pluck('year');

            $uniqueYears = $uniqueYears->merge($years);
        }
        return view('admin.penanganan_perkara.index', compact('penangananPerkara', 'triwulan', 'uniqueYears', 'year'));
    }

    public function exportToExcel(Request $request)
    {
        $triwulan = $request->query('triwulan', null);
        $year = $request->query('year', null);

        if ($year && $triwulan) {
            return Excel::download(new PenangananPerkaraExport($triwulan, $year), 'penagananperkara_triwulan_' . $triwulan . '_tahun_' . $year . '.xlsx');
        } elseif ($triwulan) {
            return Excel::download(new PenangananPerkaraExport($triwulan, null), 'penagananperkara_triwulan_' . $triwulan . '.xlsx');
        } else {
            // Redirect to a default page if neither year nor triwulan is selected
            return redirect()->route('pembinaanusaha.index'); // Replace with your desired default route
        }
    }


    public function create($triwulan)
    {
        $model = $this->modelMapping[$triwulan] ?? null;
        if (!$model) {
            return redirect()->route('penanganan_perkara.index.triwulan', ['triwulan' => $triwulan])->with('error', 'Triwulan tidak valid.');
        }
        return view('admin.penanganan_perkara.create', compact('triwulan', 'model'));
    }

    public function store(Request $request)
    {
        $triwulan = $request->input('triwulan', 1);

        $model = $this->modelMapping[$triwulan] ?? null;

        if (!$model) {
            return redirect()->route('penanganan_perkara.index.triwulan', ['triwulan' => $triwulan])->with('error', 'Triwulan tidak valid.');
        }

        $data = $request->validate([
            'uraian_kasus' => 'required|string|max:255',
            'tersangka' => 'required|string|max:255',
            'barang_bukti' => 'required|string|max:255',
            'lidik' => 'required|string|max:255',
            'sidik' => 'required|string|max:255',
            'sp3' => 'required|string|max:255',
            'p21' => 'required|string|max:255',
            'vonis' => 'required|string|max:255',
            'keterangan' => 'nullable|string|max:255',
        ]);

        // Simpan nilai Triwulan bersama dengan data
        $data['triwulan'] = $triwulan;

        if ($model::create($data)) {
            // Data berhasil disimpan, arahkan pengguna ke indeks triwulan yang sesuai
            return redirect()->route('penanganan_perkara.index.triwulan', ['triwulan' => $triwulan])->with('success', 'Data berhasil ditambahkan.');
        } else {
            // Gagal menyimpan data, kembalikan pengguna ke halaman "create" dengan data input sebelumnya
            return redirect()->route('penanganan_perkara.create', ['triwulan' => $triwulan])->withInput()->withErrors(['Gagal menyimpan data.']);
        }
    }

    public function edit($triwulan, $id)
    {
        $model = $this->modelMapping[$triwulan] ?? null;

        if (!$model) {
            return redirect()->route('penanganan_perkara.index', ['triwulan' => $triwulan])->with('error', 'Triwulan tidak valid.');
        }

        $data = $model::findOrFail($id);

        return view('admin.penanganan_perkara.edit', compact('triwulan', 'data'));
    }

    public function update(Request $request, $triwulan, $id)
    {
        $triwulan = $request->input('triwulan', 1);

        $model = $this->modelMapping[$triwulan] ?? null;

        if (!$model) {
            return redirect()->route('penanganan_perkara.index', ['triwulan' => $triwulan])->with('error', 'Triwulan tidak valid.');
        }

        $data = $request->validate([
            'uraian_kasus' => 'required|string|max:255',
            'tersangka' => 'required|string|max:255',
            'barang_bukti' => 'required|string|max:255',
            'lidik' => 'required|string|max:255',
            'sidik' => 'required|string|max:255',
            'sp3' => 'required|string|max:255',
            'p21' => 'required|string|max:255',
            'vonis' => 'required|string|max:255',
            'keterangan' => 'nullable|string|max:255',
        ]);

        // Temukan data yang akan diperbarui berdasarkan ID
        $dataToUpdate = $model::findOrFail($id);

        // Perbarui data dengan data yang valid
        $dataToUpdate->update($data);

        // Arahkan pengguna kembali ke indeks triwulan yang sesuai
        return redirect()->route('penanganan_perkara.index', ['triwulan' => $triwulan])->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($triwulan, $id)
    {
        $model = $this->modelMapping[$triwulan] ?? PenangananPerkara1::class;

        // Temukan data yang akan dihapus berdasarkan ID
        $dataToDelete = $model::findOrFail($id);

        // Hapus data
        $dataToDelete->delete();

        return redirect()->route('penanganan_perkara.index', ['triwulan' => $triwulan])->with('success', 'Data berhasil dihapus.');
    }
}
