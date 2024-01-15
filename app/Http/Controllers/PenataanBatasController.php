<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\penataan_batas1;
use App\Models\penataan_batas2;
use App\Exports\PenataanBatasExport;
use Maatwebsite\Excel\Facades\Excel;

class PenataanBatasController extends Controller
{
    protected $modelMapping = [
        1 => penataan_batas1::class,
        2 => Penataan_batas2::class,

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
            $model = $this->modelMapping[$semester] ?? penataan_batas1::class;
            $modelsToQuery[] = new $model;
        }

        $penataanbatas = collect();

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

            $penataanbatas = $penataanbatas->merge($query->get());
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
        $penataanbatas = $penataanbatas->map(function ($item) {
            $item->tanggal = $item->tanggal ? Carbon::parse($item->tanggal)->translatedFormat('d F Y') : '';
            return $item;
        });
        return view('admin.penataanbatas.index', compact('penataanbatas', 'semester', 'uniqueYears', 'year'));
    }


    public function exportToExcel(Request $request)
    {
        $semester = $request->get('semester');
        $year = $request->get('year');

        if ($semester === 'all') {
            $fileName = 'Penataan Batas Kawasan Konservasi ALL semester ' . $year . '.xlsx';
        } elseif (in_array($semester, [1, 2])) {
            $fileName = 'Penataan Batas Kawasan Konservasi semester ' . $semester . ' ' . $year . '.xlsx';
        } else {
            return redirect()->back()->with('error', 'Invalid Semester selected for export.');
        }

        return (new PenataanBatasExport($semester, $year))->download($fileName);
    }

    public function create($semester)
    {
        $currentYear = date('Y');
        $years = range($currentYear - 5, $currentYear);
        $years = array_reverse($years);
        $model = $this->modelMapping[$semester] ?? null;
        if (!$model) {
            return redirect()->route('penataanbatas.index.semester', ['semester' => $semester])->with('error', 'semester tidak valid.');
        }
        //  $semester = penataanbatas1::all(); // Sesuaikan dengan model dan tabel semester Anda

        return view('admin.penataanbatas.create', compact('semester', 'model', 'semester', 'years'));
    }
    public function store(Request $request)
    {
        $semester = $request->input('semester', null);

        $model = $this->modelMapping[$semester] ?? null;

        if (!$model) {
            return redirect()->route('penataanbatas.index.semester', ['semester' => $semester])->with('error', 'Semester tidak valid.');
        }

        $data = $request->validate([
            'p_batas' => 'required|string|max:255',
            'tahun' => 'required|string|max:255',
            'panjang' => 'required|string|max:255',
            'jmlh_batas' => 'required|string|max:255',
            'nomor' => 'required|string|max:255',
            'tanggal' => 'required|date|max:255',
            'baik' => 'required|numeric|max:255',
            'rusak' => 'required|numeric|max:255',
            'hilang' => 'required|numeric|max:255',
            'jmlh_pal' => 'required|numeric|max:255',
            'keterangan' => 'nullable',
        ]);

        // Simpan nilai Semester bersama dengan data
        $data['semester'] = $semester;

        if ($model::create($data)) {
            // Data berhasil disimpan, arahkan pengguna ke indeks semester yang sesuai
            return redirect()->route('penataanbatas.index.semester', ['semester' => $semester])->with('success', 'Data berhasil ditambahkan.');
        } else {
            // Gagal menyimpan data, kembalikan pengguna ke halaman "create" dengan data input sebelumnya
            return redirect()->route('penataanbatas.create', ['semester' => $semester])->withInput()->withErrors(['Gagal menyimpan data.']);
        }
    }

    public function edit($semester, $id)
    {
        $currentYear = date('Y');
        $years = range($currentYear - 5, $currentYear);
        $years = array_reverse($years);
        $model = $this->modelMapping[$semester] ?? null;
        $model = $this->modelMapping[$semester] ?? null;
        $model = $this->modelMapping[$semester] ?? null;

        if (!$model) {
            return redirect()->route('penataanbatas.index', ['semester' => $semester])->with('error', 'Temester tidak valid.');
        }

        $data = $model::findOrFail($id);

        return view('admin.penataanbatas.edit', compact('semester', 'data', 'years'));
    }

    public function update(Request $request, $semester, $id)
    {
        $semester = $request->input('semester', 1);

        $model = $this->modelMapping[$semester] ?? null;

        if (!$model) {
            return redirect()->route('penataanbatas.index', ['semester' => $semester])->with('error', 'Semester tidak valid.');
        }

        $data = $request->validate([
            'p_batas' => 'required|string|max:255',
            'tahun' => 'required|string|max:255',
            'panjang' => 'required|string|max:255',
            'jmlh_batas' => 'required|string|max:255',
            'nomor' => 'required|string|max:255',
            'tanggal' => 'required|date|max:255',
            'baik' => 'required|numeric|max:255',
            'rusak' => 'required|numeric|max:255',
            'hilang' => 'required|numeric|max:255',
            'jmlh_pal' => 'required|numeric|max:255',
            'keterangan' => 'nullable',
        ]);

        // Temukan data yang akan diperbarui berdasarkan ID
        $dataToUpdate = $model::findOrFail($id);

        // Perbarui data dengan data yang valid
        $dataToUpdate->update($data);

        // Arahkan pengguna kembali ke indeks semester yang sesuai
        return redirect()->route('penataanbatas.index', ['semester' => $semester])->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($semester, $id)
    {
        $model = $this->modelMapping[$semester] ?? penataan_batas1::class;

        // Temukan data yang akan dihapus berdasarkan ID
        $dataToDelete = $model::findOrFail($id);

        // Hapus data
        $dataToDelete->delete();

        return redirect()->route('penataanbatas.index', ['semester' => $semester])->with('success', 'Data berhasil dihapus.');
    }
}
