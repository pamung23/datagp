<?php

namespace App\Http\Controllers;

use App\Exports\Iupjswaxport;
use App\Models\Iupjswa1;
use App\Models\Iupjswa2;
use App\Models\Iupjswa3;
use App\Models\Iupjswa4;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class IupjswaController extends Controller
{
    protected $modelMapping = [
        1 => Iupjswa1::class,
        2 => Iupjswa2::class,
        3 => Iupjswa3::class,
        4 => Iupjswa4::class,
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
            $model = $this->modelMapping[$triwulan] ?? Iupjswa1::class;
            $modelsToQuery[] = new $model;
        }

        $iupjswa = collect();

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

            $iupjswa = $iupjswa->merge($query->get());
        }

        $uniqueYears = collect();

        foreach ($modelsToQuery as $model) {
            $years = $model::selectRaw('YEAR(created_at) as year')
                ->distinct()
                ->orderBy('year', 'desc')
                ->pluck('year');

            $uniqueYears = $uniqueYears->merge($years);
        }

        return view('admin.iupjswa.index', compact('iupjswa', 'triwulan', 'uniqueYears', 'year'));
    }

    public function exportToExcel(Request $request)
    {
        $triwulan = $request->get('triwulan');
        $year = $request->get('year');

        if ($triwulan === 'all') {
            $fileName = 'Pengusahaan Pemanfaatan Jasa Lingkungan Wisata Alam ALL TRIWULAN ' . $year . '.xlsx';
        } elseif (in_array($triwulan, [1, 2, 3, 4])) {
            $fileName = 'Pengusahaan Pemanfaatan Jasa Lingkungan Wisata Alam TRIWULAN ' . $triwulan . ' ' . $year . '.xlsx';
        } else {
            return redirect()->back()->with('error', 'Invalid quarter selected for export.');
        }

        return (new Iupjswaxport($triwulan, $year))->download($fileName);
    }

    public function create($triwulan)
    {
        $currentYear = date('Y');
        $years = range($currentYear - 5, $currentYear);
        $years = array_reverse($years);
        $model = $this->modelMapping[$triwulan] ?? null;
        if (!$model) {
            return redirect()->route('iupjswa.index.triwulan', ['triwulan' => $triwulan])->with('error', 'Triwulan tidak valid.');
        }
        return view('admin.iupjswa.create', compact('triwulan', 'model', 'years'));
    }

    public function store(Request $request)
    {
        $triwulan = $request->input('triwulan', null);

        $model = $this->modelMapping[$triwulan] ?? null;

        if (!$model) {
            return redirect()->route('iupjswa.index.triwulan', ['triwulan' => $triwulan])->with('error', 'Triwulan tidak valid.');
        }

        $data = $request->validate([
            'nama_zona_blok_pemanfaatan' => 'required|string|max:255', // Bentuk LK
            'luas_zona_blok_pemanfaatan' => 'required|numeric|max:255', // Nama LK
            'iupswa_nama_perusahaan' => 'required|string|max:255', // Alamat LK
            'iupswa_tahun_penerbitan' => 'required|string|max:255', // Provinsi
            'iupswa_luas_area' => 'required|numeric', // Koordinat lintang
            'iupjwa_nama_pemegang_izin' => 'required|string', // Koordinat bujur
            'iupjwa_tahun_penerbitan_izin' => 'required|numeric', // Luas Areal (Ha)
            'iupjwa_jenis_jasa' => 'required|string|max:255', // Nomor
            'keterangan' => 'nullable|string|max:255', // Keterangan (opsional)
        ]);

        $data['triwulan'] = $triwulan;
        $model::create($data);

        // Arahkan pengguna kembali ke indeks triwulan yang sesuai
        return redirect()->route('iupjswa.index.triwulan', ['triwulan' => $triwulan])->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit($triwulan, $id)
    {
        $currentYear = date('Y');
        $years = range(2015, $currentYear);
        $years = array_reverse($years);
        $model = $this->modelMapping[$triwulan] ?? null;

        if (!$model) {
            return redirect()->route('iupjswa.index.triwulan', ['triwulan' => $triwulan])->with('error', 'Triwulan tidak valid.');
        }

        $data = $model::findOrFail($id);

        return view('admin.iupjswa.edit', compact('triwulan', 'data', 'years'));
    }


    public function update(Request $request, $triwulan, $id)
    {
        $triwulan = $request->input('triwulan', 1);

        $model = $this->modelMapping[$triwulan] ?? null;

        if (!$model) {
            return redirect()->route('iupjswa.index.triwulan', ['triwulan' => $triwulan])->with('error', 'Triwulan tidak valid.');
        }

        $data = $request->validate([
            'nama_zona_blok_pemanfaatan' => 'required|string|max:255', // Bentuk LK
            'luas_zona_blok_pemanfaatan' => 'required|numeric|max:255', // Nama LK
            'iupswa_nama_perusahaan' => 'required|string|max:255', // Alamat LK
            'iupswa_tahun_penerbitan' => 'required|string|max:255', // Provinsi
            'iupswa_luas_area' => 'required|numeric', // Koordinat lintang
            'iupjwa_nama_pemegang_izin' => 'required|string', // Koordinat bujur
            'iupjwa_tahun_penerbitan_izin' => 'required|numeric', // Luas Areal (Ha)
            'iupjwa_jenis_jasa' => 'required|string|max:255', // Nomor
            'keterangan' => 'nullable|string|max:255', // Keterangan (opsional)
        ]);
        // Temukan data yang akan diperbarui berdasarkan ID
        $dataToUpdate = $model::findOrFail($id);

        // Perbarui data dengan data yang valid
        $dataToUpdate->update($data);

        // Arahkan pengguna kembali ke indeks triwulan yang sesuai
        return redirect()->route('iupjswa.index.triwulan', ['triwulan' => $triwulan])->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($triwulan, $id)
    {
        $model = $this->modelMapping[$triwulan] ?? iupjswa1::class;

        // Temukan data yang akan dihapus berdasarkan ID
        $dataToDelete = $model::findOrFail($id);

        // Hapus data
        $dataToDelete->delete();

        return redirect()->route('iupjswa.index', ['triwulan' => $triwulan])->with('success', 'Data berhasil dihapus.');
    }
}
