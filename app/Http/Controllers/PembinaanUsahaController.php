<?php

namespace App\Http\Controllers;

use App\Exports\PembinaanUsahaExport;
use Illuminate\Http\Request;
use App\Models\PembinaanUsaha;
use App\Models\PembinaanUsaha1;
use App\Models\PembinaanUsaha2;
use App\Models\PembinaanUsaha3;
use App\Models\PembinaanUsaha4;
use Maatwebsite\Excel\Facades\Excel;

class PembinaanUsahaController extends Controller
{
    protected $modelMapping = [
        1 => PembinaanUsaha1::class,
        2 => PembinaanUsaha2::class,
        3 => PembinaanUsaha3::class,
        4 => PembinaanUsaha4::class,
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
            $model = $this->modelMapping[$triwulan] ?? PembinaanUsaha1::class;
            $modelsToQuery[] = new $model;
        }

        $pembinaanUsahas = collect();

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

            $pembinaanUsahas = $pembinaanUsahas->merge($query->get());
        }

        $uniqueYears = collect();

        foreach ($modelsToQuery as $model) {
            $years = $model::selectRaw('YEAR(created_at) as year')
                ->distinct()
                ->orderBy('year', 'desc')
                ->pluck('year');

            $uniqueYears = $uniqueYears->merge($years);
        }

        return view('admin.pembinaanusaha.index', compact('pembinaanUsahas', 'triwulan', 'uniqueYears', 'year'));
    }

    public function exportToExcel(Request $request)
    {
        $triwulan = $request->get('triwulan');
        $year = $request->get('year');

        if ($triwulan === 'all') {
            $fileName = 'Pembinaan Usaha Ekonomi Produktif pada Daerah Penyangga Kawasan Konservasi ALL TRIWULAN ' . $year . '.xlsx';
        } elseif (in_array($triwulan, [1, 2, 3, 4])) {
            $fileName = 'Pembinaan Usaha Ekonomi Produktif pada Daerah Penyangga Kawasan Konservasi TRIWULAN ' . $triwulan . ' ' . $year . '.xlsx';
        } else {
            return redirect()->back()->with('error', 'Invalid quarter selected for export.');
        }

        return (new PembinaanUsahaExport($triwulan, $year))->download($fileName);
    }

    public function create($triwulan)
    {
        $model = $this->modelMapping[$triwulan] ?? null;
        if (!$model) {
            return redirect()->route('pembinaanusaha.index.triwulan', ['triwulan' => $triwulan])->with('error', 'Triwulan tidak valid.');
        }
        return view('admin.pembinaanusaha.create', compact('triwulan', 'model'));
    }

    public function store(Request $request)
    {
        $triwulan = $request->input('triwulan', 1);

        $model = $this->modelMapping[$triwulan] ?? null;

        if (!$model) {
            return redirect()->route('pembinaanusaha.index.triwulan', ['triwulan' => $triwulan])->with('error', 'Triwulan tidak valid.');
        }

        $data = $request->validate([
            'nama_kelompok' => 'required|string|max:255',
            'anggota' => 'required|integer',
            'jenis_kegiatan' => 'required|string|max:255',
            'jumlah_dana' => 'required|numeric',
            'sumber_dana' => 'required|string|max:255',
            'hasil_manfaat' => 'required|string',
            'pendamping' => 'required|string|max:255',
            'keterangan' => 'nullable',
        ]);

        // Simpan nilai Triwulan bersama dengan data
        $data['triwulan'] = $triwulan;

        $model::create($data);

        // Arahkan pengguna kembali ke indeks triwulan yang sesuai
        return redirect()->route('pembinaanusaha.index.triwulan', ['triwulan' => $triwulan])->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit($triwulan, $id)
    {
        $model = $this->modelMapping[$triwulan] ?? null;

        if (!$model) {
            return redirect()->route('pembinaanusaha.index.triwulan', ['triwulan' => $triwulan])->with('error', 'Triwulan tidak valid.');
        }

        $data = $model::findOrFail($id);

        return view('admin.pembinaanusaha.edit', compact('triwulan', 'data'));
    }


    public function update(Request $request, $triwulan, $id)
    {
        $triwulan = $request->input('triwulan', 1);

        $model = $this->modelMapping[$triwulan] ?? null;

        if (!$model) {
            return redirect()->route('pembinaanusaha.index.triwulan', ['triwulan' => $triwulan])->with('error', 'Triwulan tidak valid.');
        }

        $data = $request->validate([
            'nama_kelompok' => 'required|string|max:255',
            'anggota' => 'required|integer',
            'jenis_kegiatan' => 'required|string|max:255',
            'jumlah_dana' => 'required|numeric',
            'sumber_dana' => 'required|string|max:255',
            'hasil_manfaat' => 'required|string',
            'pendamping' => 'required|string|max:255',
            'keterangan' => 'nullable',
        ]);
        $data['jumlah_dana'] = (int) str_replace(',', '', number_format($data['jumlah_dana'], 0, ',', ''));
        // Temukan data yang akan diperbarui berdasarkan ID
        $dataToUpdate = $model::findOrFail($id);

        // Perbarui data dengan data yang valid
        $dataToUpdate->update($data);

        // Arahkan pengguna kembali ke indeks triwulan yang sesuai
        return redirect()->route('pembinaanusaha.index.triwulan', ['triwulan' => $triwulan])->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($triwulan, $id)
    {
        $model = $this->modelMapping[$triwulan] ?? PembinaanUsaha1::class;

        // Temukan data yang akan dihapus berdasarkan ID
        $dataToDelete = $model::findOrFail($id);

        // Hapus data
        $dataToDelete->delete();

        return redirect()->route('pembinaanusaha.index', ['triwulan' => $triwulan])->with('success', 'Data berhasil dihapus.');
    }
}
