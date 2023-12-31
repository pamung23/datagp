<?php

namespace App\Http\Controllers;

// use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\KawasanKonservasiExport;
use App\Models\kawasan_konservasi1;
use App\Models\kawasan_konservasi2;


class KawasanKonserController extends Controller
{
    protected $modelMapping = [
        1 => kawasan_konservasi1::class,
        2 => kawasan_konservasi2::class,

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
            $model = $this->modelMapping[$semester] ?? kawasan_konservasi1::class;
            $modelsToQuery[] = new $model;
        }

        $kawasan_konservasi = collect();

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

            $kawasan_konservasi = $kawasan_konservasi->merge($query->get());
        }

        $uniqueYears = collect();

        foreach ($modelsToQuery as $model) {
            $years = $model::selectRaw('YEAR(created_at) as year')
                ->distinct()
                ->orderBy('year', 'desc')
                ->pluck('year');

            $uniqueYears = $uniqueYears->merge($years);
        }
        return view('admin.kawasankonser.index', compact('kawasan_konservasi', 'semester', 'uniqueYears', 'year'));
    }

    public function exportToExcel(Request $request)
    {
        $semester = $request->get('semester');
        $year = $request->get('year');

        if ($semester === 'all') {
            $fileName = 'Kawasan Konservasi yang Mendapat Penetapan Status Internasional sebagai Cagar Biosfer ALL semester ' . $year . '.xlsx';
        } elseif (in_array($semester, [1, 2, 3, 4])) {
            $fileName = 'Kawasan Konservasi yang Mendapat Penetapan Status Internasional sebagai Cagar Biosfer semester ' . $semester . ' ' . $year . '.xlsx';
        } else {
            return redirect()->back()->with('error', 'Invalid Semester selected for export.');
        }

        return (new KawasanKonservasiExport($semester, $year))->download($fileName);
    }

    public function create($semester)
    {
        $currentYear = date('Y');
        $years = range($currentYear - 5, $currentYear);
        $years = array_reverse($years);
        $model = $this->modelMapping[$semester] ?? null;
        if (!$model) {
            return redirect()->route('kawasankonservasi.index.semester', ['semester' => $semester])->with('error', 'semester tidak valid.');
        }
        //  $semester = kawasan_konservasi1::all(); // Sesuaikan dengan model dan tabel semester Anda

        return view('admin.kawasankonser.create', compact('semester', 'model', 'years'));
    }
    public function store(Request $request)
    {
        $semester = $request->input('semester', null);

        $model = $this->modelMapping[$semester] ?? null;

        if (!$model) {
            return redirect()->route('kawasankonservasi.index.semester', ['semester' => $semester])->with('error', 'Semester tidak valid.');
        }

        $data = $request->validate([
            'nama_cagar_biosfer' => 'required|string|max:255',
            'tahun_penetapan' => 'required|string|max:255',
            'area_inti' => 'required|string|max:255',
            'zona_penyangga' => 'required|string|max:255',
            'area_transisi' => 'required|string|max:255',
            'keterangan' => 'nullable',
        ]);

        // Simpan nilai Semester bersama dengan data
        $data['semester'] = $semester;

        if ($model::create($data)) {
            // Data berhasil disimpan, arahkan pengguna ke indeks semester yang sesuai
            return redirect()->route('kawasankonservasi.index.semester', ['semester' => $semester])->with('success', 'Data berhasil ditambahkan.');
        } else {
            // Gagal menyimpan data, kembalikan pengguna ke halaman "create" dengan data input sebelumnya
            return redirect()->route('kawasankonservasi.create', compact('semester', 'model', 'years'))->withInput()->withErrors(['Gagal menyimpan data.']);
        }
    }

    public function edit($semester, $id)
    {
        $currentYear = date('Y');
        $years = range($currentYear - 5, $currentYear);
        $years = array_reverse($years);
        $model = $this->modelMapping[$semester] ?? null;

        if (!$model) {
            return redirect()->route('kawasan_konservasi.index', ['semester' => $semester])->with('error', 'Temester tidak valid.');
        }

        $data = $model::findOrFail($id);

        return view('admin.kawasankonser.edit', compact('semester', 'data', 'years'));
    }

    public function update(Request $request, $semester, $id)
    {
        $semester = $request->input('semester', 1);

        $model = $this->modelMapping[$semester] ?? null;

        if (!$model) {
            return redirect()->route('kawasankonservasi.index', ['semester' => $semester])->with('error', 'Semester tidak valid.');
        }

        $data = $request->validate([
            'nama_cagar_biosfer' => 'required|string|max:255',
            'tahun_penetapan' => 'required|string|max:255',
            'area_inti' => 'required|string|max:255',
            'zona_penyangga' => 'required|string|max:255',
            'area_transisi' => 'required|string|max:255',
            'keterangan' => 'nullable',
        ]);

        // Temukan data yang akan diperbarui berdasarkan ID
        $dataToUpdate = $model::findOrFail($id);

        // Perbarui data dengan data yang valid
        $dataToUpdate->update($data);

        // Arahkan pengguna kembali ke indeks semester yang sesuai
        return redirect()->route('kawasankonservasi.index', ['semester' => $semester])->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($semester, $id)
    {
        $model = $this->modelMapping[$semester] ?? kawasan_konservasi1::class;

        // Temukan data yang akan dihapus berdasarkan ID
        $dataToDelete = $model::findOrFail($id);

        // Hapus data
        $dataToDelete->delete();

        return redirect()->route('kawasankonservasi.index', ['semester' => $semester])->with('success', 'Data berhasil dihapus.');
    }
}
