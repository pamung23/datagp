<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TenagaPengamanSatkerExport;
use App\Models\TenagaPengamananHutanPerSatuanKerja1;
use App\Models\TenagaPengamananHutanPerSatuanKerja2;
use App\Models\TenagaPengamananHutanPerSatuanKerja3;
use App\Models\TenagaPengamananHutanPerSatuanKerja4;

class TenagaPengamananSatkerController extends Controller
{
    protected $modelMapping = [
        1 => TenagaPengamananHutanPerSatuanKerja1::class,
        2 => TenagaPengamananHutanPerSatuanKerja2::class,
        3 => TenagaPengamananHutanPerSatuanKerja3::class,
        4 => TenagaPengamananHutanPerSatuanKerja4::class,
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
            $model = $this->modelMapping[$triwulan] ?? TenagaPengamananHutanPerSatuanKerja1::class;
            $modelsToQuery[] = new $model;
        }

        $tenagaPengamananHutan = collect();

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

            $tenagaPengamananHutan = $tenagaPengamananHutan->merge($query->get());
        }

        $uniqueYears = collect();

        foreach ($modelsToQuery as $model) {
            $years = $model::selectRaw('YEAR(created_at) as year')
                ->distinct()
                ->orderBy('year', 'desc')
                ->pluck('year');

            $uniqueYears = $uniqueYears->merge($years);
        }

        return view('admin.tenagapengamansatker.index', compact('tenagaPengamananHutan', 'triwulan', 'uniqueYears', 'year'));
    }

    public function exportToExcel(Request $request)
    {
        $triwulan = $request->get('triwulan');
        $year = $request->get('year');

        if ($triwulan === 'all') {
            $fileName = 'Tenaga Pengamanan Hutan Per Satuan Kerja ALL TRIWULAN ' . $year . '.xlsx';
        } elseif (in_array($triwulan, [1, 2, 3, 4])) {
            $fileName = 'Tenaga Pengamanan Hutan Per Satuan Kerja TRIWULAN ' . $triwulan . ' ' . $year . '.xlsx';
        } else {
            return redirect()->back()->with('error', 'Invalid quarter selected for export.');
        }

        return (new TenagaPengamanSatkerExport($triwulan, $year))->download($fileName);
    }

    public function create($triwulan)
    {
        $model = $this->modelMapping[$triwulan] ?? null;
        if (!$model) {
            return redirect()->route('tenagapengamansatker.index.triwulan', ['triwulan' => $triwulan])->with('error', 'Triwulan tidak valid.');
        }
        return view('admin.tenagapengamansatker.create', compact('triwulan', 'model'));
    }

    public function store(Request $request)
    {
        $triwulan = $request->input('triwulan', 1);
        $model = $this->modelMapping[$triwulan] ?? null;
        if (!$model) {
            return redirect()->route('tenagapengamansatker.index.triwulan', ['triwulan' => $triwulan])->with('error', 'Triwulan tidak valid.');
        }
        $data = $request->validate([
            'polhut' => 'required|integer',
            'ppns' => 'required|integer',
            'tphl' => 'required|integer',
            'mmp' => 'required|integer',
            'keterangan' => 'nullable',
        ]);
        // Simpan nilai Triwulan bersama dengan data
        $data['triwulan'] = $triwulan;
        $model::create($data);
        // Arahkan pengguna kembali ke indeks triwulan yang sesuai
        return redirect()->route('tenagapengamansatker.index.triwulan', ['triwulan' => $triwulan])->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit($triwulan, $id)
    {
        $model = $this->modelMapping[$triwulan] ?? null;

        if (!$model) {
            return redirect()->route('tenagapengamansatker.index.triwulan', ['triwulan' => $triwulan])->with('error', 'Triwulan tidak valid.');
        }

        $data = $model::findOrFail($id);

        return view('admin.tenagapengamansatker.edit', compact('triwulan', 'data'));
    }

    public function update(Request $request, $triwulan, $id)
    {
        $triwulan = $request->input('triwulan', 1);

        $model = $this->modelMapping[$triwulan] ?? null;

        if (!$model) {
            return redirect()->route('tenagapengamansatker.index.triwulan', ['triwulan' => $triwulan])->with('error', 'Triwulan tidak valid.');
        }

        $data = $request->validate([
            'polhut' => 'required|integer',
            'ppns' => 'required|integer',
            'tphl' => 'required|integer',
            'mmp' => 'required|integer',
            'keterangan' => 'nullable',
        ]);

        // Temukan data yang akan diperbarui berdasarkan ID
        $dataToUpdate = $model::findOrFail($id);

        // Perbarui data dengan data yang valid
        $dataToUpdate->update($data);

        // Arahkan pengguna kembali ke indeks triwulan yang sesuai
        return redirect()->route('tenagapengamansatker.index.triwulan', ['triwulan' => $triwulan])->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($triwulan, $id)
    {
        $model = $this->modelMapping[$triwulan] ?? null;

        if (!$model) {
            return redirect()->route('tenagapengamansatker.index.triwulan', ['triwulan' => $triwulan])->with('error', 'Triwulan tidak valid.');
        }

        // Temukan data yang akan dihapus berdasarkan ID
        $dataToDelete = $model::findOrFail($id);

        // Hapus data
        $dataToDelete->delete();

        return redirect()->route('tenagapengamansatker.index', ['triwulan' => $triwulan])->with('success', 'Data berhasil dihapus.');
    }
}
