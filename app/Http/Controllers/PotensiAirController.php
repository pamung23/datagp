<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\PotensiAir1;
use App\Models\PotensiAir2;
use App\Models\PotensiAir3;
use App\Models\PotensiAir4;
use Illuminate\Http\Request;
use App\Exports\PotensiAirExport;
use Maatwebsite\Excel\Facades\Excel;

class PotensiAirController extends Controller
{
    protected $modelMapping = [
        1 => PotensiAir1::class,
        2 => PotensiAir2::class,
        3 => PotensiAir3::class,
        4 => PotensiAir4::class,
    ];
    public function showAllDataOnMap()
    {
        $allDataByQuarter = [];

        foreach ($this->modelMapping as $triwulan => $modelClass) {
            $data = $modelClass::all()->map(function ($item) use ($triwulan) {
                $item['triwulan'] = $triwulan;
                return $item;
            });

            $allDataByQuarter[$triwulan] = $data;
        }
        $encodedData = base64_encode(json_encode($allDataByQuarter));
        return view('admin.potensiair.petaall', compact('encodedData'));
    }
    public function showPeta($triwulan, $id)
    {
        $model = $this->modelMapping[$triwulan] ?? null;

        if (!$model) {
            return redirect()->route('potensiair.index.triwulan', ['triwulan' => $triwulan])->with('error', 'Triwulan tidak valid.');
        }

        $data = $model::find($id);
        $latitude = $data->latitude; // Sesuaikan ini dengan nama properti pada model Anda
        $longitude = $data->longitude; // Sesuaikan ini dengan nama properti pada model Anda
        $nama_sumber_air = $data->nama_sumber_air;
        $debit = $data->debit;
        $massa_air = $data->massa_air;
        return view('admin.potensiair.peta', compact('triwulan', 'model', 'data', 'latitude', 'longitude', 'nama_sumber_air', 'debit', 'massa_air'));
    }
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
            $model = $this->modelMapping[$triwulan] ?? PotensiAir1::class;
            $modelsToQuery[] = new $model;
        }

        $potensiair = collect();

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

            $potensiair = $potensiair->merge($query->get());
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
        $potensiair = $potensiair->map(function ($item) {
            $item->tanggal = $item->tanggal ? Carbon::parse($item->tanggal)->translatedFormat('d F Y') : '';
            return $item;
        });

        return view('admin.potensiair.index', compact('potensiair', 'triwulan', 'uniqueYears', 'year'));
    }

    public function exportToExcel(Request $request)
    {
        $triwulan = $request->get('triwulan');
        $year = $request->get('year');

        if ($triwulan === 'all') {
            $fileName = 'Potensi Pemanfaatan Air di Kawasan Konservasi ALL TRIWULAN ' . $year . '.xlsx';
        } elseif (in_array($triwulan, [1, 2, 3, 4])) {
            $fileName = 'Potensi Pemanfaatan Air di Kawasan Konservasi TRIWULAN ' . $triwulan . ' ' . $year . '.xlsx';
        } else {
            return redirect()->back()->with('error', 'Invalid quarter selected for export.');
        }

        return (new PotensiAirExport($triwulan, $year))->download($fileName);
    }



    public function create($triwulan)
    {
        $model = $this->modelMapping[$triwulan] ?? null;
        if (!$model) {
            return redirect()->route('potensiair.index.triwulan', ['triwulan' => $triwulan])->with('error', 'Triwulan tidak valid.');
        }
        return view('admin.potensiair.create', compact('triwulan', 'model'));
    }

    public function store(Request $request)
    {
        $triwulan = $request->input('triwulan', null);

        $model = $this->modelMapping[$triwulan] ?? null;

        if (!$model) {
            return redirect()->route('potensiair.index.triwulan', ['triwulan' => $triwulan])->with('error', 'Triwulan tidak valid.');
        }

        $data = $request->validate([
            'nama_sumber_air' => 'required|string|max:255',
            'debit' => 'required|regex:/^[-.,\d]+$/',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'massa_air' => 'required|regex:/^[-.,\d]+$/',
            'energi_air' => 'regex:/^[-.,\d]+$/',
            'nomor' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'pengusahaan_pihak_iii' => 'string|max:255',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $data['triwulan'] = $triwulan;
        $model::create($data);

        // Arahkan pengguna kembali ke indeks triwulan yang sesuai
        return redirect()->route('potensiair.index.triwulan', ['triwulan' => $triwulan])->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit($triwulan, $id)
    {
        $model = $this->modelMapping[$triwulan] ?? null;

        if (!$model) {
            return redirect()->route('potensiair.index.triwulan', ['triwulan' => $triwulan])->with('error', 'Triwulan tidak valid.');
        }

        $data = $model::findOrFail($id);

        return view('admin.potensiair.edit', compact('triwulan', 'data'));
    }


    public function update(Request $request, $triwulan, $id)
    {
        $triwulan = $request->input('triwulan', 1);

        $model = $this->modelMapping[$triwulan] ?? null;

        if (!$model) {
            return redirect()->route('potensiair.index.triwulan', ['triwulan' => $triwulan])->with('error', 'Triwulan tidak valid.');
        }

        $data = $request->validate([
            'nama_sumber_air' => 'required|string|max:255',
            'debit' => 'required|regex:/^[-.,\d]+$/',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'massa_air' => 'required|regex:/^[-.,\d]+$/',
            'energi_air' => 'regex:/^[-.,\d]+$/',
            'nomor' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'pengusahaan_pihak_iii' => 'string|max:255',
            'keterangan' => 'nullable|string|max:255',
        ]);
        // Temukan data yang akan diperbarui berdasarkan ID
        $dataToUpdate = $model::findOrFail($id);

        // Perbarui data dengan data yang valid
        $dataToUpdate->update($data);

        // Arahkan pengguna kembali ke indeks triwulan yang sesuai
        return redirect()->route('potensiair.index.triwulan', ['triwulan' => $triwulan])->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($triwulan, $id)
    {
        $model = $this->modelMapping[$triwulan] ?? potensiair1::class;

        // Temukan data yang akan dihapus berdasarkan ID
        $dataToDelete = $model::findOrFail($id);

        // Hapus data
        $dataToDelete->delete();

        return redirect()->route('potensiair.index', ['triwulan' => $triwulan])->with('success', 'Data berhasil dihapus.');
    }
}
