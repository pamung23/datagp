<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PenangananJenisExport;
use App\Models\penanganan_jenis1;
use App\Models\penanganan_jenis2;


class PenangananJenisController extends Controller
{
    protected $modelMapping = [
        1 => penanganan_jenis1::class,
        2 => penanganan_jenis2::class,

    ];
    public function showAllDataOnMap()
    {
        $allDataByQuarter = [];

        foreach ($this->modelMapping as $semester => $modelClass) {
            $data = $modelClass::all()->map(function ($item) use ($semester) {
                $item['semester'] = $semester;
                return $item;
            });

            $allDataByQuarter[$semester] = $data;
        }
        $encodedData = base64_encode(json_encode($allDataByQuarter));
        return view('admin.penangananjenis.petaall', compact('encodedData'));
    }
    public function showPeta($semester, $id)
    {
        $model = $this->modelMapping[$semester] ?? null;

        if (!$model) {
            return redirect()->route('penangananjenis.index.semester', ['semester' => $semester])->with('error', 'Semester tidak valid.');
        }

        $data = $model::find($id);
        $latitude = $data->latitude; // Sesuaikan ini dengan nama properti pada model Anda
        $longitude = $data->longitude; // Sesuaikan ini dengan nama properti pada model Anda
        $ilmiah = $data->ilmiah;
        return view('admin.penangananjenis.peta', compact('semester', 'model', 'data', 'latitude', 'longitude', 'ilmiah'));
    }
    public function index(Request $request)
    {
        $semester = $request->input('semester', 1);
        $year = $request->input('year');
        $modelsToQuery = [];

        // Ambil level pengguna saat ini
        $userLevel = auth()->user()->level;

        // Inisialisasi array level yang diizinkan mengakses semua triwulan
        $levelsAllowedForAllsemester = ['Admin', 'Balai'];

        if (in_array($userLevel, $levelsAllowedForAllsemester)) {
            // Jika level pengguna adalah 'Admin' atau 'Balai', perbolehkan akses ke semua triwulan
            foreach ($this->modelMapping as $model) {
                $modelsToQuery[] = new $model;
            }
        } elseif (in_array($userLevel, ['Wilayah Cianjur', 'Wilayah Sukabumi', 'Wilayah Bogor'])) {
            // Jika level pengguna adalah 'Wilayah Cianjur', 'Wilayah Sukabumi', atau 'Wilayah Bogor',
            // batasi akses hanya ke triwulan yang dipilih dan resort yang sesuai
            $model = $this->modelMapping[$semester] ?? penanganan_jenis1::class;
            $modelsToQuery[] = new $model;
        }

        $penanganan_jenis = collect();

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

            $penanganan_jenis = $penanganan_jenis->merge($query->get());
        }

        $uniqueYears = collect();

        foreach ($modelsToQuery as $model) {
            $years = $model::selectRaw('YEAR(created_at) as year')
                ->distinct()
                ->orderBy('year', 'desc')
                ->pluck('year');

            $uniqueYears = $uniqueYears->merge($years);
        }

        return view('admin.penangananjenis.index', compact('penanganan_jenis', 'semester', 'uniqueYears', 'year'));
    }


    public function exportToExcel(Request $request)
    {
        $semester = $request->get('semester');
        $year = $request->get('year');

        if ($semester === 'all') {
            $fileName = 'Penanganan Jenis Asing Invasif (IAS) di Kawasan Konservasi ALL semester ' . $year . '.xlsx';
        } elseif (in_array($semester, [1, 2])) {
            $fileName = 'Penanganan Jenis Asing Invasif (IAS) di Kawasan Konservasi semester ' . $semester . ' ' . $year . '.xlsx';
        } else {
            return redirect()->back()->with('error', 'Invalid Semester selected for export.');
        }

        return (new PenangananJenisExport($semester, $year))->download($fileName);
    }

    public function create($semester)
    {
        $model = $this->modelMapping[$semester] ?? null;
        if (!$model) {
            return redirect()->route('penangananjenis.index.semester', ['semester' => $semester])->with('error', 'semester tidak valid.');
        }
        //  $semester = penangananjenis1::all(); // Sesuaikan dengan model dan tabel semester Anda

        return view('admin.penangananjenis.create', compact('semester', 'model'));
    }
    public function store(Request $request)
    {
        $semester = $request->input('semester', null);

        $model = $this->modelMapping[$semester] ?? null;

        if (!$model) {
            return redirect()->route('penangananjenis.index.semester', ['semester' => $semester])->with('error', 'Semester tidak valid.');
        }

        $data = $request->validate([
            'ilmiah' => 'required|string|max:255',
            'luas' => 'required|numeric|max:255',
            'latitude' => 'required|numeric|max:255',
            'longitude' => 'required|numeric|max:255',
            'penanganan' => 'required|string|max:255',
            'rencana' => 'required|string|max:255',
            'kemitraan' => 'required|string|max:255',
            'keterangan' => 'nullable',
        ]);

        // Simpan nilai Semester bersama dengan data
        $data['semester'] = $semester;

        if ($model::create($data)) {
            // Data berhasil disimpan, arahkan pengguna ke indeks semester yang sesuai
            return redirect()->route('penangananjenis.index.semester', ['semester' => $semester])->with('success', 'Data berhasil ditambahkan.');
        } else {
            // Gagal menyimpan data, kembalikan pengguna ke halaman "create" dengan data input sebelumnya
            return redirect()->route('penangananjenis.create', ['semester' => $semester])->withInput()->withErrors(['Gagal menyimpan data.']);
        }
    }

    public function edit($semester, $id)
    {
        $model = $this->modelMapping[$semester] ?? null;

        if (!$model) {
            return redirect()->route('penangananjenis.index', ['semester' => $semester])->with('error', 'Temester tidak valid.');
        }

        $data = $model::findOrFail($id);

        return view('admin.penangananjenis.edit', compact('semester', 'data'));
    }

    public function update(Request $request, $semester, $id)
    {
        $semester = $request->input('semester', 1);

        $model = $this->modelMapping[$semester] ?? null;

        if (!$model) {
            return redirect()->route('penangananjenis.index', ['semester' => $semester])->with('error', 'Semester tidak valid.');
        }

        $data = $request->validate([
            'ilmiah' => 'required|string|max:255',
            'luas' => 'required|numeric|max:255',
            'latitude' => 'required|numeric|max:255',
            'longitude' => 'required|numeric|max:255',
            'penanganan' => 'required|string|max:255',
            'rencana' => 'required|string|max:255',
            'kemitraan' => 'required|string|max:255',
            'keterangan' => 'nullable',
        ]);

        // Temukan data yang akan diperbarui berdasarkan ID
        $dataToUpdate = $model::findOrFail($id);

        // Perbarui data dengan data yang valid
        $dataToUpdate->update($data);

        // Arahkan pengguna kembali ke indeks semester yang sesuai
        return redirect()->route('penangananjenis.index', ['semester' => $semester])->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($semester, $id)
    {
        $model = $this->modelMapping[$semester] ?? penanganan_jenis1::class;

        // Temukan data yang akan dihapus berdasarkan ID
        $dataToDelete = $model::findOrFail($id);

        // Hapus data
        $dataToDelete->delete();

        return redirect()->route('penangananjenis.index', ['semester' => $semester])->with('success', 'Data berhasil dihapus.');
    }
}
