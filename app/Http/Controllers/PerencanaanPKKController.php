<?php

namespace App\Http\Controllers;

// use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\PerencanaanPKK1;
use App\Models\PerencanaanPKK2;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PerencanaanPKKExport;

class PerencanaanPKKController extends Controller
{
    protected $modelMapping = [
        1 => PerencanaanPKK1::class,
        2 => PerencanaanPKK2::class,

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
            $model = $this->modelMapping[$semester] ?? PerencanaanPKK1::class;
            $modelsToQuery[] = new $model;
        }

        $PerencanaanPKK = collect();

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

            $PerencanaanPKK = $PerencanaanPKK->merge($query->get());
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
        $PerencanaanPKK = $PerencanaanPKK->map(function ($item) {
            $item->jpan_tanggal = $item->jpan_tanggal ? Carbon::parse($item->jpan_tanggal)->translatedFormat('d F Y') : '';
            $item->jpan_mulai = $item->jpan_mulai ? Carbon::parse($item->jpan_mulai)->translatedFormat('d F Y') : '';
            $item->jpan_akhir = $item->jpan_akhir ? Carbon::parse($item->jpan_akhir)->translatedFormat('d F Y') : '';
            $item->jpen_tanggal = $item->jpen_tanggal ? Carbon::parse($item->jpen_tanggal)->translatedFormat('d F Y') : '';
            return $item;
        });

        return view('admin.perencanaanpkk.index', compact('PerencanaanPKK', 'semester', 'uniqueYears', 'year'));
    }


    public function exportToExcel(Request $request)
    {
        $semester = $request->get('semester');
        $year = $request->get('year');

        if ($semester === 'all') {
            $fileName = 'Perencanaan Pengelolaan Kawasan Konservasi ALL semester ' . $year . '.xlsx';
        } elseif (in_array($semester, [1, 2, 3, 4])) {
            $fileName = 'Perencanaan Pengelolaan Kawasan Konservasi semester ' . $semester . ' ' . $year . '.xlsx';
        } else {
            return redirect()->back()->with('error', 'Invalid Semester selected for export.');
        }

        return (new PerencanaanPKKExport($semester, $year))->download($fileName);
    }

    public function create($semester)
    {
        $model = $this->modelMapping[$semester] ?? null;
        if (!$model) {
            return redirect()->route('perencanaanpkk.index.semester', ['semester' => $semester])->with('error', 'semester tidak valid.');
        }
        //  $semester = perencanaanpkk1::all(); // Sesuaikan dengan model dan tabel semester Anda

        return view('admin.perencanaanpkk.create', compact('semester', 'model'));
    }
    public function store(Request $request)
    {
        $semester = $request->input('semester', null);

        $model = $this->modelMapping[$semester] ?? null;

        if (!$model) {
            return redirect()->route('perencanaanpkk.index.semester', ['semester' => $semester])->with('error', 'Semester tidak valid.');
        }

        $data = $request->validate([
            'jpan_nomor' => 'required|string|max:255',
            'jpan_tanggal' => 'required|date|max:255',
            'jpan_mulai' => 'required|date|max:255',
            'jpan_akhir' => 'required|date|max:255',
            'jpen_nomor' => 'required|string|max:255',
            'jpen_tanggal' => 'required|date|max:255',
            'jpen_periode' => 'required|string|max:255',
            'jpen_luas' => 'nullable|string|max:255',
            'keterangan' => 'nullable',
        ]);

        // Simpan nilai Semester bersama dengan data
        $data['semester'] = $semester;

        if ($model::create($data)) {
            // Data berhasil disimpan, arahkan pengguna ke indeks semester yang sesuai
            return redirect()->route('perencanaanpkk.index.semester', ['semester' => $semester])->with('success', 'Data berhasil ditambahkan.');
        } else {
            // Gagal menyimpan data, kembalikan pengguna ke halaman "create" dengan data input sebelumnya
            return redirect()->route('perencanaanpkk.create', ['semester' => $semester])->withInput()->withErrors(['Gagal menyimpan data.']);
        }
    }

    public function edit($semester, $id)
    {
        $model = $this->modelMapping[$semester] ?? null;

        if (!$model) {
            return redirect()->route('perencanaanpkk.index', ['semester' => $semester])->with('error', 'Temester tidak valid.');
        }

        $data = $model::findOrFail($id);

        return view('admin.perencanaanpkk.edit', compact('semester', 'data'));
    }

    public function update(Request $request, $semester, $id)
    {
        $semester = $request->input('semester', 1);

        $model = $this->modelMapping[$semester] ?? null;

        if (!$model) {
            return redirect()->route('perencanaanpkk.index', ['semester' => $semester])->with('error', 'Semester tidak valid.');
        }

        $data = $request->validate([
            'jpan_nomor' => 'required|string|max:255',
            'jpan_tanggal' => 'required|date|max:255',
            'jpan_mulai' => 'required|date|max:255',
            'jpan_akhir' => 'required|date|max:255',
            'jpen_nomor' => 'required|string|max:255',
            'jpen_tanggal' => 'required|date|max:255',
            'jpen_periode' => 'required|string|max:255',
            'jpen_luas' => 'nullable|string|max:255',
            'keterangan' => 'nullable',
        ]);

        // Temukan data yang akan diperbarui berdasarkan ID
        $dataToUpdate = $model::findOrFail($id);

        // Perbarui data dengan data yang valid
        $dataToUpdate->update($data);

        // Arahkan pengguna kembali ke indeks semester yang sesuai
        return redirect()->route('perencanaanpkk.index', ['semester' => $semester])->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($semester, $id)
    {
        $model = $this->modelMapping[$semester] ?? perencanaanpkk1::class;

        // Temukan data yang akan dihapus berdasarkan ID
        $dataToDelete = $model::findOrFail($id);

        // Hapus data
        $dataToDelete->delete();

        return redirect()->route('perencanaanpkk.index', ['semester' => $semester])->with('success', 'Data berhasil dihapus.');
    }
}
