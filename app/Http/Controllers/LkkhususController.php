<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\lkkhusus1;
use App\Models\lkkhusus2;
use App\Models\lkkhusus3;
use App\Models\lkkhusus4;
use Illuminate\Http\Request;
use App\Exports\Lkkhusus1Export;
use Maatwebsite\Excel\Facades\Excel;

class LkkhususController extends Controller
{
    protected $modelMapping = [
        1 => lkkhusus1::class,
        2 => lkkhusus2::class,
        3 => lkkhusus3::class,
        4 => lkkhusus4::class,
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
        return view('admin.lkkhusus.petaall', compact('encodedData'));
    }
    public function showPeta($triwulan, $id)
    {
        $model = $this->modelMapping[$triwulan] ?? null;

        if (!$model) {
            return redirect()->route('lkkhusus.index.triwulan', ['triwulan' => $triwulan])->with('error', 'Triwulan tidak valid.');
        }

        $data = $model::find($id);
        $latitude = $data->latitude; // Sesuaikan ini dengan nama properti pada model Anda
        $longitude = $data->longitude; // Sesuaikan ini dengan nama properti pada model Anda
        $nama_lk = $data->nama_lk;
        $nama_ilmiah = $data->nama_ilmiah;
        $jantan = $data->jantan;
        $betina = $data->betina;
        $belum_diketahui = $data->belum_diketahui;
        $jumlah = $data->jumlah;
        return view('admin.lkkhusus.peta', compact('jantan', 'betina', 'belum_diketahui', 'jumlah', 'triwulan', 'model', 'data', 'latitude', 'longitude', 'nama_lk', 'nama_ilmiah'));
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
            $model = $this->modelMapping[$triwulan] ?? lkkhusus1::class;
            $modelsToQuery[] = new $model;
        }

        $lkkhusus = collect();

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

            $lkkhusus = $lkkhusus->merge($query->get());
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
        $lkkhusus = $lkkhusus->map(function ($item) {
            $item->tanggal = $item->tanggal ? Carbon::parse($item->tanggal)->translatedFormat('d F Y') : '';
            return $item;
        });

        return view('admin.lkkhusus.index', compact('lkkhusus', 'triwulan', 'uniqueYears', 'year'));
    }

    public function exportToExcel(Request $request)
    {
        $triwulan = $request->get('triwulan');
        $year = $request->get('year');

        if ($triwulan === 'all') {
            $fileName = 'Lembaga Konservasi Khusus ALL TRIWULAN ' . $year . '.xlsx';
        } elseif (in_array($triwulan, [1, 2, 3, 4])) {
            $fileName = 'Lembaga Konservasi Khusus TRIWULAN ' . $triwulan . ' ' . $year . '.xlsx';
        } else {
            return redirect()->back()->with('error', 'Invalid quarter selected for export.');
        }

        return (new Lkkhusus1Export($triwulan, $year))->download($fileName);
    }

    public function create($triwulan)
    {
        $model = $this->modelMapping[$triwulan] ?? null;
        if (!$model) {
            return redirect()->route('lkkhusus.index.triwulan', ['triwulan' => $triwulan])->with('error', 'Triwulan tidak valid.');
        }
        return view('admin.lkkhusus.create', compact('triwulan', 'model'));
    }

    public function store(Request $request)
    {
        $triwulan = $request->input('triwulan', null);

        $model = $this->modelMapping[$triwulan] ?? null;

        if (!$model) {
            return redirect()->route('lkkhusus.index.triwulan', ['triwulan' => $triwulan])->with('error', 'Triwulan tidak valid.');
        }

        $data = $request->validate([
            'bentuk_lk' => 'required|string|max:255', // Bentuk LK
            'nama_lk' => 'required|string|max:255', // Nama LK
            'alamat_lk' => 'required|string|max:255', // Alamat LK
            'provinsi' => 'required|string|max:255', // Provinsi
            'latitude' => 'required|numeric', // Koordinat lintang
            'longitude' => 'required|numeric', // Koordinat bujur
            'luas_areal_hektar' => 'required|numeric', // Luas Areal (Ha)
            'nomor' => 'required|string|max:255', // Nomor
            'tanggal' => 'required|date', // Tanggal
            'masa_berlaku_tahun' => 'required|integer', // Masa Berlaku (Tahun)
            'nama_ilmiah' => 'required|string|max:255', // Nama Ilmiah
            'jantan' => 'required|integer', // Jantan
            'betina' => 'required|integer', // Betina
            'belum_diketahui' => 'required|integer', // Belum Diketahui
            'keterangan' => 'nullable|string|max:255', // Keterangan (opsional)
        ]);
        // Ubah format data koordinat dari koma (,) ke titik (.) jika diperlukan
        $data['latitude'] = str_replace(',', '.', $data['latitude']);
        $data['longitude'] = str_replace(',', '.', $data['longitude']);
        // Simpan nilai Triwulan bersama dengan data
        $data['triwulan'] = $triwulan;
        // Simpan luas areal dalam format desimal

        $data['jumlah'] = $data['jantan'] + $data['betina'] + $data['belum_diketahui'];
        $model::create($data);

        // Arahkan pengguna kembali ke indeks triwulan yang sesuai
        return redirect()->route('lkkhusus.index.triwulan', ['triwulan' => $triwulan])->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit($triwulan, $id)
    {
        $model = $this->modelMapping[$triwulan] ?? null;

        if (!$model) {
            return redirect()->route('lkkhusus.index.triwulan', ['triwulan' => $triwulan])->with('error', 'Triwulan tidak valid.');
        }

        $data = $model::findOrFail($id);

        return view('admin.lkkhusus.edit', compact('triwulan', 'data'));
    }


    public function update(Request $request, $triwulan, $id)
    {
        $triwulan = $request->input('triwulan', 1);

        $model = $this->modelMapping[$triwulan] ?? null;

        if (!$model) {
            return redirect()->route('lkkhusus.index.triwulan', ['triwulan' => $triwulan])->with('error', 'Triwulan tidak valid.');
        }

        $data = $request->validate([
            'bentuk_lk' => 'required|string|max:255', // Bentuk LK
            'nama_lk' => 'required|string|max:255', // Nama LK
            'alamat_lk' => 'required|string|max:255', // Alamat LK
            'provinsi' => 'required|string|max:255', // Provinsi
            'latitude' => 'required|numeric', // Koordinat lintang
            'longitude' => 'required|numeric', // Koordinat bujur
            'luas_areal_hektar' => 'required|numeric', // Luas Areal (Ha)
            'nomor' => 'required|string|max:255', // Nomor
            'tanggal' => 'required|date', // Tanggal
            'masa_berlaku_tahun' => 'required|integer', // Masa Berlaku (Tahun)
            'nama_ilmiah' => 'required|string|max:255', // Nama Ilmiah
            'jantan' => 'required|integer', // Jantan
            'betina' => 'required|integer', // Betina
            'belum_diketahui' => 'required|integer', // Belum Diketahui
            'keterangan' => 'nullable|string|max:255', // Keterangan (opsional)
        ]);

        // Temukan data yang akan diperbarui berdasarkan ID
        $dataToUpdate = $model::findOrFail($id);

        // Perbarui data dengan data yang valid
        $dataToUpdate->update([
            'bentuk_lk' => $data['bentuk_lk'],
            'nama_lk' => $data['nama_lk'],
            'alamat_lk' => $data['alamat_lk'],
            'provinsi' => $data['provinsi'],
            'latitude' => $data['latitude'],
            'longitude' => $data['longitude'],
            'luas_areal_hektar' => $data['luas_areal_hektar'],
            'nomor' => $data['nomor'],
            'tanggal' => $data['tanggal'],
            'masa_berlaku_tahun' => $data['masa_berlaku_tahun'],
            'nama_ilmiah' => $data['nama_ilmiah'],
            'jantan' => $data['jantan'],
            'betina' => $data['betina'],
            'belum_diketahui' => $data['belum_diketahui'],
            'keterangan' => $data['keterangan'],
            'jumlah' => $data['jantan'] + $data['betina'] + $data['belum_diketahui'],
        ]);

        // Arahkan pengguna kembali ke indeks triwulan yang sesuai
        return redirect()->route('lkkhusus.index.triwulan', ['triwulan' => $triwulan])->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($triwulan, $id)
    {
        $model = $this->modelMapping[$triwulan] ?? lkkhusus1::class;

        // Temukan data yang akan dihapus berdasarkan ID
        $dataToDelete = $model::findOrFail($id);

        // Hapus data
        $dataToDelete->delete();

        return redirect()->route('lkkhusus.index', ['triwulan' => $triwulan])->with('success', 'Data berhasil dihapus.');
    }
}
