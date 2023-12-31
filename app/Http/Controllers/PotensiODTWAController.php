<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PotensiODTWA1;
use App\Models\PotensiODTWA2;
use App\Models\PotensiODTWA3;
use App\Models\PotensiODTWA4;
use App\Exports\PotensiODTWAExport;
use Maatwebsite\Excel\Facades\Excel;

class PotensiODTWAController extends Controller
{
    protected $modelMapping = [
        1 => PotensiODTWA1::class,
        2 => PotensiODTWA2::class,
        3 => PotensiODTWA3::class,
        4 => PotensiODTWA4::class,
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
        return view('admin.potensiodtwa.petaall', compact('encodedData'));
    }
    public function showPeta($triwulan, $id)
    {
        $model = $this->modelMapping[$triwulan] ?? null;

        if (!$model) {
            return redirect()->route('potensiodtwa.index.triwulan', ['triwulan' => $triwulan])->with('error', 'Triwulan tidak valid.');
        }

        $data = $model::find($id);
        $latitude = $data->latitude; // Sesuaikan ini dengan nama properti pada model Anda
        $longitude = $data->longitude; // Sesuaikan ini dengan nama properti pada model Anda
        $nama_zona_blok_pemanfaatan = $data->nama_zona_blok_pemanfaatan;
        return view('admin.potensiodtwa.peta', compact('triwulan', 'model', 'data', 'latitude', 'longitude', 'nama_zona_blok_pemanfaatan'));
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
            $model = $this->modelMapping[$triwulan] ?? PotensiODTWA1::class;
            $modelsToQuery[] = new $model;
        }

        $potensiodtwa = collect();

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

            $potensiodtwa = $potensiodtwa->merge($query->get());
        }

        $uniqueYears = collect();

        foreach ($modelsToQuery as $model) {
            $years = $model::selectRaw('YEAR(created_at) as year')
                ->distinct()
                ->orderBy('year', 'desc')
                ->pluck('year');

            $uniqueYears = $uniqueYears->merge($years);
        }
        return view('admin.potensiodtwa.index', compact('potensiodtwa', 'triwulan', 'uniqueYears', 'year'));
    }

    public function exportToExcel(Request $request)
    {
        $triwulan = $request->get('triwulan');
        $year = $request->get('year');

        if ($triwulan === 'all') {
            $fileName = 'POTENSI ODTWA ALL TRIWULAN ' . $year . '.xlsx';
        } elseif (in_array($triwulan, [1, 2, 3, 4])) {
            $fileName = 'POTENSI ODTWA TRIWULAN ' . $triwulan . ' ' . $year . '.xlsx';
        } else {
            return redirect()->back()->with('error', 'Invalid quarter selected for export.');
        }

        return (new PotensiODTWAExport($triwulan, $year))->download($fileName);
    }

    public function create($triwulan)
    {
        $model = $this->modelMapping[$triwulan] ?? null;
        if (!$model) {
            return redirect()->route('potensiodtwa.index.triwulan', ['triwulan' => $triwulan])->with('error', 'Triwulan tidak valid.');
        }
        return view('admin.potensiodtwa.create', compact('triwulan', 'model'));
    }

    public function store(Request $request)
    {
        $triwulan = $request->input('triwulan', null);

        $potensiModel = $this->modelMapping[$triwulan] ?? null;

        if (!$potensiModel) {
            return redirect()->route('potensiodtwa.index.triwulan', ['triwulan' => $triwulan])->with('error', 'Triwulan tidak valid.');
        }

        $data = $request->validate([
            'nama_zona_blok_pemanfaatan' => 'required|string',
            'luas_zona_blok_pemanfaatan' => 'required|numeric',
            'jenis_odtwa' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'jenis_atraksi_wisata' => 'required|string',
            'jenis_prasarana.*' => 'required|string',
            'jumlah_unit.*' => 'required|integer',
            'kondisi.*' => 'required|string',
            'pengusahaan_oleh_pihak_iii' => 'required|string',
            'keterangan' => 'nullable|string',
        ]);
        $potensiODTWA = $potensiModel::create($data);

        // Handle array data and save them if needed
        if ($request->has('array_data')) {
            $arrayData = $request->input('array_data');
            $potensiODTWA->arrayData()->createMany($arrayData);
        }
        return redirect()->route('potensiodtwa.index')->with('success', 'Data berhasil ditambahkan.');
    }
    public function edit($triwulan, $id)
    {
        $model = $this->modelMapping[$triwulan] ?? null;

        if (!$model) {
            return redirect()->route('potensiodtwa.index.triwulan', ['triwulan' => $triwulan])->with('error', 'Triwulan tidak valid.');
        }

        $data = $model::find($id);
        $prasaranaUnits = $data->jenis_prasarana; // Sesuaikan ini dengan nama kolom yang menyimpan relasi prasarana

        return view('admin.potensiodtwa.edit', compact('triwulan', 'model', 'data', 'prasaranaUnits'));
    }

    public function update(Request $request, $triwulan, $id)
    {
        $model = $this->modelMapping[$triwulan] ?? null;

        if (!$model) {
            return redirect()->route('potensiodtwa.index.triwulan', ['triwulan' => $triwulan])->with('error', 'Triwulan tidak valid.');
        }

        $data = $model::findOrFail($id);

        $validatedData = $request->validate([
            'nama_zona_blok_pemanfaatan' => 'required|string',
            'luas_zona_blok_pemanfaatan' => 'required|numeric',
            'jenis_odtwa' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'jenis_atraksi_wisata' => 'required|string',
            'jenis_prasarana.*' => 'required|string',
            'jumlah_unit.*' => 'required|integer',
            'kondisi.*' => 'required|string',
            'pengusahaan_oleh_pihak_iii' => 'required|string',
            'keterangan' => 'nullable|string',
        ]);


        // Update the model with the validated data
        $data->update($validatedData);

        // Update JSON fields
        $jenisPrasarana = $request->input('jenis_prasarana', []);
        $jumlahUnit = $request->input('jumlah_unit', []);
        $kondisi = $request->input('kondisi', []);

        $data->update([
            'jenis_prasarana' => $jenisPrasarana,
            'jumlah_unit' => $jumlahUnit,
            'kondisi' => $kondisi,
        ]);
        return redirect()->route('potensiodtwa.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($triwulan, $id)
    {
        $model = $this->modelMapping[$triwulan] ?? PotensiODTWA1::class;

        // Temukan data yang akan dihapus berdasarkan ID
        $dataToDelete = $model::findOrFail($id);

        // Hapus data
        $dataToDelete->delete();

        return redirect()->route('potensiodtwa.index', ['triwulan' => $triwulan])->with('success', 'Data berhasil dihapus.');
    }
}
