<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PeralatanMesinExport;
use App\Models\peralatan_mesin1;
use App\Models\peralatan_mesin2;

class PeralatanMesinController extends Controller
{
    protected $modelMapping = [
        1 => peralatan_mesin1::class,
        2 => peralatan_mesin2::class,

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
            $model = $this->modelMapping[$semester] ?? peralatan_mesin1::class;
            $modelsToQuery[] = new $model;
        }

        $peralatan_mesin = collect();

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

            $peralatan_mesin = $peralatan_mesin->merge($query->get());
        }

        $uniqueYears = collect();

        foreach ($modelsToQuery as $model) {
            $years = $model::selectRaw('YEAR(created_at) as year')
                ->distinct()
                ->orderBy('year', 'desc')
                ->pluck('year');

            $uniqueYears = $uniqueYears->merge($years);
        }

        return view('admin.peralatanmesin.index', compact('peralatan_mesin', 'semester', 'uniqueYears', 'year'));
    }

    public function exportToExcel(Request $request)
    {
        $semester = $request->get('semester');
        $year = $request->get('year');

        if ($semester === 'all') {
            $fileName = ' Peralatan Mesin Pompa dan Kelengkapannya untuk Kebutuhan Pengendalian Kebakaran Hutan ALL semester ' . $year . '.xlsx';
        } elseif (in_array($semester, [1, 2])) {
            $fileName = ' Peralatan Mesin Pompa dan Kelengkapannya untuk Kebutuhan Pengendalian Kebakaran Hutan semester ' . $semester . ' ' . $year . '.xlsx';
        } else {
            return redirect()->back()->with('error', 'Invalid Semester selected for export.');
        }

        return (new PeralatanMesinExport($semester, $year))->download($fileName);
    }

    public function create($semester)
    {
        $model = $this->modelMapping[$semester] ?? null;
        if (!$model) {
            return redirect()->route('peralatanmesin.index.semester', ['semester' => $semester])->with('error', 'semester tidak valid.');
        }
        // $semester = peralatan_mesin1::all(); // Sesuaikan dengan model dan tabel semester Anda

        return view('admin.peralatanmesin.create', compact('semester', 'model'));
    }
    public function store(Request $request)
    {
        $semester = $request->input('semester', null);

        $model = $this->modelMapping[$semester] ?? null;

        if (!$model) {
            return redirect()->route('peralatanmesin.index.semester', ['semester' => $semester])->with('error', 'semester tidak valid.');
        }

        $data = $request->validate([
            'daops' => 'required|string|max:255',
            'baik1' => 'required|integer|max:255',
            'rusak1' => 'required|integer|max:255',
            'baik2' => 'required|integer|max:255',
            'rusak2' => 'required|integer|max:255',
            'baik3' => 'required|integer|max:255',
            'rusak3' => 'required|integer|max:255',
            'baik4' => 'required|integer|max:255',
            'rusak4' => 'required|integer|max:255',
            'baik5' => 'required|integer|max:255',
            'rusak5' => 'required|integer|max:255',
            'baik6' => 'required|integer|max:255',
            'rusak6' => 'required|integer|max:255',
            'baik7' => 'required|integer|max:255',
            'rusak7' => 'required|integer|max:255',
            'baik8' => 'required|integer|max:255',
            'rusak8' => 'required|integer|max:255',
            'baik9' => 'required|integer|max:255',
            'rusak9' => 'required|integer|max:255',
            'baik10' => 'required|integer|max:255',
            'rusak10' => 'required|integer|max:255',
            'baik11' => 'required|integer|max:255',
            'rusak11' => 'required|integer|max:255',
            'baik12' => 'required|integer|max:255',
            'rusak12' => 'required|integer|max:255',
            'baik13' => 'required|integer|max:255',
            'rusak13' => 'required|integer|max:255',
            'baik14' => 'required|integer|max:255',
            'rusak14' => 'required|integer|max:255',
            'baik15' => 'required|integer|max:255',
            'rusak15' => 'required|integer|max:255',
            'lain' => 'required|string|max:255',
            'keterangan' => 'nullable',
        ]);

        // Simpan nilai semester bersama dengan data
        $data['semester'] = $semester;

        if ($model::create($data)) {
            // Data berhasil disimpan, arahkan pengguna ke indeks semester yang sesuai
            return redirect()->route('peralatanmesin.index.semester', ['semester' => $semester])->with('success', 'Data berhasil ditambahkan.');
        } else {
            // Gagal menyimpan data, kembalikan pengguna ke halaman "create" dengan data input sebelumnya
            return redirect()->route('peralatanmesin.create', ['semester' => $semester])->withInput()->withErrors(['Gagal menyimpan data.']);
        }
    }

    public function edit($semester, $id)
    {
        $model = $this->modelMapping[$semester] ?? null;

        if (!$model) {
            return redirect()->route('peralatan_mesin.index', ['semester' => $semester])->with('error', 'Temester tidak valid.');
        }

        $data = $model::findOrFail($id);

        return view('admin.peralatanmesin.edit', compact('semester', 'data'));
    }

    public function update(Request $request, $semester, $id)
    {
        $semester = $request->input('semester', 1);

        $model = $this->modelMapping[$semester] ?? null;

        if (!$model) {
            return redirect()->route('peralatanmesin.index', ['semester' => $semester])->with('error', 'semester tidak valid.');
        }

        $data = $request->validate([
            'daops' => 'required|string|max:255',
            'baik1' => 'required|integer|max:255',
            'rusak1' => 'required|integer|max:255',
            'baik2' => 'required|integer|max:255',
            'rusak2' => 'required|integer|max:255',
            'baik3' => 'required|integer|max:255',
            'rusak3' => 'required|integer|max:255',
            'baik4' => 'required|integer|max:255',
            'rusak4' => 'required|integer|max:255',
            'baik5' => 'required|integer|max:255',
            'rusak5' => 'required|integer|max:255',
            'baik6' => 'required|integer|max:255',
            'rusak6' => 'required|integer|max:255',
            'baik7' => 'required|integer|max:255',
            'rusak7' => 'required|integer|max:255',
            'baik8' => 'required|integer|max:255',
            'rusak8' => 'required|integer|max:255',
            'baik9' => 'required|integer|max:255',
            'rusak9' => 'required|integer|max:255',
            'baik10' => 'required|integer|max:255',
            'rusak10' => 'required|integer|max:255',
            'baik11' => 'required|integer|max:255',
            'rusak11' => 'required|integer|max:255',
            'baik12' => 'required|integer|max:255',
            'rusak12' => 'required|integer|max:255',
            'baik13' => 'required|integer|max:255',
            'rusak13' => 'required|integer|max:255',
            'baik14' => 'required|integer|max:255',
            'rusak14' => 'required|integer|max:255',
            'baik15' => 'required|integer|max:255',
            'rusak15' => 'required|integer|max:255',
            'lain' => 'required|string|max:255',
            'keterangan' => 'nullable',
        ]);

        // Temukan data yang akan diperbarui berdasarkan ID
        $dataToUpdate = $model::findOrFail($id);

        // Perbarui data dengan data yang valid
        $dataToUpdate->update($data);

        // Arahkan pengguna kembali ke indeks semester yang sesuai
        return redirect()->route('peralatanmesin.index', ['semester' => $semester])->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($semester, $id)
    {
        $model = $this->modelMapping[$semester] ?? peralatan_mesin1::class;

        // Temukan data yang akan dihapus berdasarkan ID
        $dataToDelete = $model::findOrFail($id);

        // Hapus data
        $dataToDelete->delete();

        return redirect()->route('peralatanmesin.index', ['semester' => $semester])->with('success', 'Data berhasil dihapus.');
    }
}
