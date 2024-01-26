<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PameranExport;
use App\Models\pameran1;
use App\Models\pameran2;

class PameranController extends Controller
{
    protected $modelMapping = [
        1 => pameran1::class,
        2 => pameran2::class,

    ];

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
            $model = $this->modelMapping[$semester] ?? pameran1::class;
            $modelsToQuery[] = new $model;
        }

        $pameran = collect();

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

            $pameran = $pameran->merge($query->get());
        }

        $uniqueYears = collect();

        foreach ($modelsToQuery as $model) {
            $years = $model::selectRaw('YEAR(created_at) as year')
                ->distinct()
                ->orderBy('year', 'desc')
                ->pluck('year');

            $uniqueYears = $uniqueYears->merge($years);
        }

        // Filter out duplicates and sort the unique years
        $uniqueYears = $uniqueYears->unique()->sort()->reverse();

        return view('admin.pameran.index', compact('pameran', 'semester', 'uniqueYears', 'year'));
    }


    public function exportToExcel(Request $request)
    {
        $semester = $request->get('semester');
        $year = $request->get('year');

        if ($semester === 'all') {
            $fileName = 'Promosi dan Publikasi Jasa Lingkungan Kawasan Konservasi ALL semester ' . $year . '.xlsx';
        } elseif (in_array($semester, [1, 2])) {
            $fileName = 'Promosi dan Publikasi Jasa Lingkungan Kawasan Konservasi semester ' . $semester . ' ' . $year . '.xlsx';
        } else {
            return redirect()->back()->with('error', 'Invalid Semester selected for export.');
        }

        return (new PameranExport($semester, $year))->download($fileName);
    }

    public function create($semester)
    {
        $model = $this->modelMapping[$semester] ?? null;
        if (!$model) {
            return redirect()->route('pameran.index.semester', ['semester' => $semester])->with('error', 'semester tidak valid.');
        }
        //  $semester = pameran1::all(); // Sesuaikan dengan model dan tabel semester Anda

        return view('admin.pameran.create', compact('semester', 'model'));
    }
    public function store(Request $request)
    {
        $semester = $request->input('semester', null);

        $model = $this->modelMapping[$semester] ?? null;

        if (!$model) {
            return redirect()->route('pameran.index.semester', ['semester' => $semester])->with('error', 'Semester tidak valid.');
        }

        $data = $request->validate([
            'jenis' => 'required|string|max:255',
            'judul' => 'required|string|max:255',
            'penyelenggara' => 'required|string|max:255',
            'sumber' => 'required|string|max:255',
            'keterangan' => 'nullable',
        ]);

        // Simpan nilai Semester bersama dengan data
        $data['semester'] = $semester;

        if ($model::create($data)) {
            // Data berhasil disimpan, arahkan pengguna ke indeks semester yang sesuai
            return redirect()->route('pameran.index.semester', ['semester' => $semester])->with('success', 'Data berhasil ditambahkan.');
        } else {
            // Gagal menyimpan data, kembalikan pengguna ke halaman "create" dengan data input sebelumnya
            return redirect()->route('pameran.create', ['semester' => $semester])->withInput()->withErrors(['Gagal menyimpan data.']);
        }
    }

    public function edit($semester, $id)
    {
        $model = $this->modelMapping[$semester] ?? null;

        if (!$model) {
            return redirect()->route('pameran.index', ['semester' => $semester])->with('error', 'Temester tidak valid.');
        }

        $data = $model::findOrFail($id);

        return view('admin.pameran.edit', compact('semester', 'data'));
    }

    public function update(Request $request, $semester, $id)
    {
        $semester = $request->input('semester', 1);

        $model = $this->modelMapping[$semester] ?? null;

        if (!$model) {
            return redirect()->route('pameran.index', ['semester' => $semester])->with('error', 'Semester tidak valid.');
        }

        $data = $request->validate([
            'jenis' => 'required|string|max:255',
            'judul' => 'required|string|max:255',
            'penyelenggara' => 'required|string|max:255',
            'sumber' => 'required|string|max:255',
            'keterangan' => 'nullable',
        ]);

        // Temukan data yang akan diperbarui berdasarkan ID
        $dataToUpdate = $model::findOrFail($id);

        // Perbarui data dengan data yang valid
        $dataToUpdate->update($data);

        // Arahkan pengguna kembali ke indeks semester yang sesuai
        return redirect()->route('pameran.index', ['semester' => $semester])->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($semester, $id)
    {
        $model = $this->modelMapping[$semester] ?? pameran1::class;

        // Temukan data yang akan dihapus berdasarkan ID
        $dataToDelete = $model::findOrFail($id);

        // Hapus data
        $dataToDelete->delete();

        return redirect()->route('pameran.index', ['semester' => $semester])->with('success', 'Data berhasil dihapus.');
    }
}
