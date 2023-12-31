<?php

namespace App\Http\Controllers;

use App\Models\PenetapanKK1;
use App\Models\PenetapanKK2;
use App\Models\PenetapanKK3;
use App\Models\PenetapanKK4;
use Illuminate\Http\Request;
use App\Exports\PenetapanKKExport;
use Carbon\Carbon;


class PenetapanKKController extends Controller
{
    protected $modelMapping = [
        1 => PenetapanKK1::class,
        2 => PenetapanKK2::class,
        3 => PenetapanKK3::class,
        4 => PenetapanKK4::class,
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
            $model = $this->modelMapping[$triwulan] ?? PenetapanKK1::class;
            $modelsToQuery[] = new $model;
        }

        $penetapankk = collect();

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

            $penetapankk = $penetapankk->merge($query->get());
        }

        $uniqueYears = collect();

        foreach ($modelsToQuery as $model) {
            $years = $model::selectRaw('YEAR(created_at) as year')
                ->distinct()
                ->orderBy('year', 'desc')
                ->pluck('year');

            $uniqueYears = $uniqueYears->merge($years);
        }

        // Function to convert English month to Indonesian
        function getMonthInBahasa($englishMonth)
        {
            $months = [
                'January' => 'Januari',
                'February' => 'Februari',
                'March' => 'Maret',
                'April' => 'April',
                'May' => 'Mei',
                'June' => 'Juni',
                'July' => 'Juli',
                'August' => 'Agustus',
                'September' => 'September',
                'October' => 'Oktober',
                'November' => 'November',
                'December' => 'Desember',
            ];

            return $months[$englishMonth];
        }
        $penetapankk = $penetapankk->map(function ($item) {
            $item->tanggal_sk_parsial = $item->tanggal_sk_parsial ? Carbon::parse($item->tanggal_sk_parsial)->translatedFormat('d F Y') : '';
            $item->tanggal_sk_provinsi = $item->tanggal_sk_provinsi ? Carbon::parse($item->tanggal_sk_provinsi)->translatedFormat('d F Y') : '';
            $item->tanggal_sk_kawasan = $item->tanggal_sk_kawasan ? Carbon::parse($item->tanggal_sk_kawasan)->translatedFormat('d F Y') : '';
            return $item;
        });

        return view('admin.penetapankk.index', compact('penetapankk', 'triwulan', 'uniqueYears', 'year'));
    }

    public function exportToExcel(Request $request)
    {
        $triwulan = $request->get('triwulan');
        $year = $request->get('year');

        if ($triwulan === 'all') {
            $fileName = 'Kawasan Konservasi ALL TRIWULAN ' . $year . '.xlsx';
        } elseif (in_array($triwulan, [1, 2, 3, 4])) {
            $fileName = 'Kawasan Konservasi TRIWULAN ' . $triwulan . ' ' . $year . '.xlsx';
        } else {
            return redirect()->back()->with('error', 'Invalid quarter selected for export.');
        }

        return (new PenetapanKKExport($triwulan, $year))->download($fileName);
    }



    public function create($triwulan)
    {
        $model = $this->modelMapping[$triwulan] ?? null;
        if (!$model) {
            return redirect()->route('penetapankk.index.triwulan', ['triwulan' => $triwulan])->with('error', 'Triwulan tidak valid.');
        }
        return view('admin.penetapankk.create', compact('triwulan', 'model'));
    }

    public function store(Request $request)
    {
        $triwulan = $request->input('triwulan', 1);

        $model = $this->modelMapping[$triwulan] ?? null;

        if (!$model) {
            return redirect()->route('penetapankk.index.triwulan', ['triwulan' => $triwulan])->with('error', 'Triwulan tidak valid.');
        }

        $data = $request->validate([
            'nomor_sk_parsial' => 'required|string|max:255',
            'tanggal_sk_parsial' => 'required|date',
            'luas_ha_parsial' => 'required|regex:/^[-.,\d]+$/',
            'nomor_sk_provinsi' => 'required|string|max:255',
            'tanggal_sk_provinsi' => 'required|date',
            'luas_ha_provinsi' => 'required|regex:/^[-.,\d]+$/',
            'nomor_sk_kawasan' => 'required|string|max:255',
            'tanggal_sk_kawasan' => 'required|date',
            'luas_ha_kawasan' => 'required|regex:/^[-.,\d]+$/',
            'keterangan' => 'nullable|string|max:255',
        ]);


        // Simpan nilai Triwulan bersama dengan data
        $data['triwulan'] = $triwulan;

        $model::create($data);

        // Arahkan pengguna kembali ke indeks triwulan yang sesuai
        return redirect()->route('penetapankk.index.triwulan', ['triwulan' => $triwulan])->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit($triwulan, $id)
    {
        $model = $this->modelMapping[$triwulan] ?? null;

        if (!$model) {
            return redirect()->route('penetapankk.index.triwulan', ['triwulan' => $triwulan])->with('error', 'Triwulan tidak valid.');
        }

        $data = $model::findOrFail($id);

        return view('admin.penetapankk.edit', compact('triwulan', 'data'));
    }


    public function update(Request $request, $triwulan, $id)
    {
        $triwulan = $request->input('triwulan', 1);

        $model = $this->modelMapping[$triwulan] ?? null;

        if (!$model) {
            return redirect()->route('penetapankk.index.triwulan', ['triwulan' => $triwulan])->with('error', 'Triwulan tidak valid.');
        }

        $data = $request->validate([
            'nomor_sk_parsial' => 'required|string|max:255',
            'tanggal_sk_parsial' => 'required|date',
            'luas_ha_parsial' => 'required|regex:/^[-.,\d]+$/',
            'nomor_sk_provinsi' => 'required|string|max:255',
            'tanggal_sk_provinsi' => 'required|date',
            'luas_ha_provinsi' => 'required|regex:/^[-.,\d]+$/',
            'nomor_sk_kawasan' => 'required|string|max:255',
            'tanggal_sk_kawasan' => 'required|date',
            'luas_ha_kawasan' => 'required|regex:/^[-.,\d]+$/',
            'keterangan' => 'nullable|string|max:255',
        ]);

        // Temukan data yang akan diperbarui berdasarkan ID
        $dataToUpdate = $model::findOrFail($id);

        // Perbarui data dengan data yang valid
        $dataToUpdate->update($data);

        // Arahkan pengguna kembali ke indeks triwulan yang sesuai
        return redirect()->route('penetapankk.index.triwulan', ['triwulan' => $triwulan])->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($triwulan, $id)
    {
        $model = $this->modelMapping[$triwulan] ?? penetapankk1::class;

        // Temukan data yang akan dihapus berdasarkan ID
        $dataToDelete = $model::findOrFail($id);

        // Hapus data
        $dataToDelete->delete();

        return redirect()->route('penetapankk.index', ['triwulan' => $triwulan])->with('success', 'Data berhasil dihapus.');
    }
}
