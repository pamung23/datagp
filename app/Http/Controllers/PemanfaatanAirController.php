<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\PemanfaatanAir1;
use App\Models\PemanfaatanAir2;
use App\Models\PemanfaatanAir3;
use App\Models\PemanfaatanAir4;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PemanfaatanAirExport;

class PemanfaatanAirController extends Controller
{
    protected $modelMapping = [
        1 => PemanfaatanAir1::class,
        2 => PemanfaatanAir2::class,
        3 => PemanfaatanAir3::class,
        4 => PemanfaatanAir4::class,
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
            $model = $this->modelMapping[$triwulan] ?? PemanfaatanAir1::class;
            $modelsToQuery[] = new $model;
        }

        $pemanfaatanair = collect();

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

            $pemanfaatanair = $pemanfaatanair->merge($query->get());
        }

        $uniqueYears = collect();

        foreach ($modelsToQuery as $model) {
            $years = $model::selectRaw('YEAR(created_at) as year')
                ->distinct()
                ->orderBy('year', 'desc')
                ->pluck('year');

            $uniqueYears = $uniqueYears->merge($years);
        }
        $desa = Desa::all();
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
        $pemanfaatanair = $pemanfaatanair->map(function ($item) {
            $item->tanggal_izin = $item->tanggal_izin ? Carbon::parse($item->tanggal_izin)->translatedFormat('d F Y') : '';
            return $item;
        });
        return view('admin.pemanfaatanair.index', compact('pemanfaatanair', 'triwulan', 'uniqueYears', 'year', 'desa'));
    }

    public function exportToExcel(Request $request)
    {
        $triwulan = $request->get('triwulan');
        $year = $request->get('year');

        if ($triwulan === 'all') {
            $fileName = 'Pemanfaatan Massa Air di Kawasan Konservasi ALL TRIWULAN ' . $year . '.xlsx';
        } elseif (in_array($triwulan, [1, 2, 3, 4])) {
            $fileName = 'Pemanfaatan Massa Air di Kawasan Konservasi TRIWULAN ' . $triwulan . ' ' . $year . '.xlsx';
        } else {
            return redirect()->back()->with('error', 'Invalid quarter selected for export.');
        }

        return (new PemanfaatanAirExport($triwulan, $year))->download($fileName);
    }


    public function getKecamatan($kabupaten_id)
    {
        $kecamatans = Kecamatan::where('kabupaten_id', $kabupaten_id)->get();
        return response()->json($kecamatans);
    }

    public function getDesa($kecamatan_id)
    {
        $desas = Desa::where('kecamatan_id', $kecamatan_id)->get();
        return response()->json($desas);
    }

    public function create($triwulan)
    {
        $model = $this->modelMapping[$triwulan] ?? null;
        if (!$model) {
            return redirect()->route('pemanfaatanair.index.triwulan', ['triwulan' => $triwulan])->with('error', 'Triwulan tidak valid.');
        }
        $kabupaten = Kabupaten::all();
        $kecamatan = Kecamatan::all();
        $desa = Desa::all();
        return view('admin.pemanfaatanair.create', compact('triwulan', 'model', 'desa', 'kabupaten', 'kecamatan'));
    }

    public function store(Request $request)
    {
        $triwulan = $request->input('triwulan', null);

        $model = $this->modelMapping[$triwulan] ?? null;

        if (!$model) {
            return redirect()->route('pemanfaatanair.index.triwulan', ['triwulan' => $triwulan])->with('error', 'Triwulan tidak valid.');
        }

        $data = $request->validate([
            'nama_sumber_air' => 'required|string|max:255',
            'jenis_izin' => 'required|string|max:255',
            'nomor_izin' => 'required|string|max:255',
            'tanggal_izin' => 'required|date',
            'nama' => 'required|string|max:255',
            'desa_id' => 'required|exists:desas,id',
            'jumlah_dilayani_kk' => 'required|integer',
            'debit' => 'required|numeric',
            'jumlah_tenaga_kerja' => 'required|integer',
            'nilai_investasi' => 'required|numeric',
            'keterangan' => 'nullable|string|max:255', // Keterangan (opsional)
        ]);

        $data['triwulan'] = $triwulan;
        $model::create($data);

        // Arahkan pengguna kembali ke indeks triwulan yang sesuai
        return redirect()->route('pemanfaatanair.index.triwulan', ['triwulan' => $triwulan])->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit($triwulan, $id)
    {
        $model = $this->modelMapping[$triwulan] ?? null;

        if (!$model) {
            return redirect()->route('pemanfaatanair.index.triwulan', ['triwulan' => $triwulan])->with('error', 'Triwulan tidak valid.');
        }

        $data = $model::findOrFail($id);
        $kabupaten = Kabupaten::all();
        $kecamatan = Kecamatan::all();
        $desa = Desa::all();
        return view('admin.pemanfaatanair.edit', compact('data', 'triwulan', 'model', 'desa', 'kabupaten', 'kecamatan'));
    }


    public function update(Request $request, $triwulan, $id)
    {
        $triwulan = $request->input('triwulan', 1);

        $model = $this->modelMapping[$triwulan] ?? null;

        if (!$model) {
            return redirect()->route('pemanfaatanair.index.triwulan', ['triwulan' => $triwulan])->with('error', 'Triwulan tidak valid.');
        }

        $data = $request->validate([
            'nama_sumber_air' => 'required|string|max:255',
            'jenis_izin' => 'required|string|max:255',
            'nomor_izin' => 'required|string|max:255',
            'tanggal_izin' => 'required|date',
            'nama' => 'required|string|max:255',
            'alamat_desa_id' => 'required|exists:desas,id',
            'lokasi_desa_id' => 'required|exists:desas,id',
            'jumlah_dilayani_kk' => 'required|integer',
            'debit' => 'required|numeric',
            'jumlah_tenaga_kerja' => 'required|integer',
            'nilai_investasi' => 'required|numeric',
            'keterangan' => 'nullable|string|max:255', // Keterangan (opsional)
        ]);
        // Temukan data yang akan diperbarui berdasarkan ID
        $dataToUpdate = $model::findOrFail($id);

        // Perbarui data dengan data yang valid
        $dataToUpdate->update($data);

        // Arahkan pengguna kembali ke indeks triwulan yang sesuai
        return redirect()->route('pemanfaatanair.index.triwulan', ['triwulan' => $triwulan])->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($triwulan, $id)
    {
        $model = $this->modelMapping[$triwulan] ?? pemanfaatanair1::class;

        // Temukan data yang akan dihapus berdasarkan ID
        $dataToDelete = $model::findOrFail($id);

        // Hapus data
        $dataToDelete->delete();

        return redirect()->route('pemanfaatanair.index', ['triwulan' => $triwulan])->with('success', 'Data berhasil dihapus.');
    }
}
