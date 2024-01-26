<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PegawaiGolonganExport;
use App\Models\pegawai_golongan1;
use App\Models\pegawai_golongan2;

class PegawaiGolonganController extends Controller
{
    protected $modelMapping = [
        1 => pegawai_golongan1::class,
        2 => pegawai_golongan2::class,

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
            $model = $this->modelMapping[$semester] ?? pegawai_golongan1::class;
            $modelsToQuery[] = new $model;
        }

        $pegawai_golongan = collect();

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

            $pegawai_golongan = $pegawai_golongan->merge($query->get());
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

        return view('admin.pegawaigolongan.index', compact('pegawai_golongan', 'semester', 'uniqueYears', 'year'));
    }

    public function exportToExcel(Request $request)
    {
        $semester = $request->get('semester');
        $year = $request->get('year');

        // Replace "/" and "\" with an underscore "_"
        $replaceCharacter = '_';

        if ($semester === 'all') {
            $fileName = 'Sebaran PNS/CPNS Menurut Golongan dan Jenis Kelamin ALL semester ' . $year . '.xlsx';
        } elseif (in_array($semester, [1, 2])) {
            $fileName = 'Sebaran PNS/CPNS Menurut Golongan dan Jenis Kelamin semester ' . $semester . ' ' . $year . '.xlsx';
        } else {
            return redirect()->back()->with('error', 'Invalid Semester selected for export.');
        }

        // Replace "/" and "\" with the specified character
        $fileName = str_replace(['/', '\\'], $replaceCharacter, $fileName);

        return (new PegawaiGolonganExport($semester, $year))->download($fileName);
    }



    public function create($semester)
    {
        $model = $this->modelMapping[$semester] ?? null;
        if (!$model) {
            return redirect()->route('pegawaigolongan.index.semester', ['semester' => $semester])->with('error', 'semester tidak valid.');
        }
        // $semester = Pegawai_golongan1::all(); // Sesuaikan dengan model dan tabel semester Anda

        return view('admin.pegawaigolongan.create', compact('semester', 'model'));
    }
    public function store(Request $request)
    {
        $semester = $request->input('semester', null);

        $model = $this->modelMapping[$semester] ?? null;

        if (!$model) {
            return redirect()->route('pegawaigolongan.index.semester', ['semester' => $semester])->with('error', 'semester tidak valid.');
        }

        $data = $request->validate([
            'laki_iv' => 'required|integer|max:255',
            'perempuan_iv' => 'required|integer|max:255',
            'laki_iii' => 'required|integer|max:255',
            'perempuan_iii' => 'required|integer|max:255',
            'laki_ii' => 'required|integer|max:255',
            'perempuan_ii' => 'required|integer|max:255',
            'laki_i' => 'required|integer|max:255',
            'perempuan_i' => 'required|integer|max:255',
            'laki_jumlah' => 'required|integer|max:255',
            'perempuan_jumlah' => 'required|integer|max:255',
            'total' => 'required|integer|max:255',
            'keterangan' => 'nullable',
        ]);

        // Simpan nilai semester bersama dengan data
        $data['semester'] = $semester;

        if ($model::create($data)) {
            // Data berhasil disimpan, arahkan pengguna ke indeks semester yang sesuai
            return redirect()->route('pegawaigolongan.index.semester', ['semester' => $semester])->with('success', 'Data berhasil ditambahkan.');
        } else {
            // Gagal menyimpan data, kembalikan pengguna ke halaman "create" dengan data input sebelumnya
            return redirect()->route('pegawaigolongan.create', ['semester' => $semester])->withInput()->withErrors(['Gagal menyimpan data.']);
        }
    }

    public function edit($semester, $id)
    {
        $model = $this->modelMapping[$semester] ?? null;

        if (!$model) {
            return redirect()->route('pegawai_golongan.index', ['semester' => $semester])->with('error', 'Temester tidak valid.');
        }

        $data = $model::findOrFail($id);

        return view('admin.pegawaigolongan.edit', compact('semester', 'data'));
    }

    public function update(Request $request, $semester, $id)
    {
        $semester = $request->input('semester', 1);

        $model = $this->modelMapping[$semester] ?? null;

        if (!$model) {
            return redirect()->route('pegawaigolongan.index', ['semester' => $semester])->with('error', 'semester tidak valid.');
        }

        $data = $request->validate([
            'laki_iv' => 'required|integer|max:255',
            'perempuan_iv' => 'required|integer|max:255',
            'laki_iii' => 'required|integer|max:255',
            'perempuan_iii' => 'required|integer|max:255',
            'laki_ii' => 'required|integer|max:255',
            'perempuan_ii' => 'required|integer|max:255',
            'laki_i' => 'required|integer|max:255',
            'perempuan_i' => 'required|integer|max:255',
            'laki_jumlah' => 'required|integer|max:255',
            'perempuan_jumlah' => 'required|integer|max:255',
            'total' => 'required|integer|max:255',
            'keterangan' => 'nullable',
        ]);

        // Temukan data yang akan diperbarui berdasarkan ID
        $dataToUpdate = $model::findOrFail($id);

        // Perbarui data dengan data yang valid
        $dataToUpdate->update($data);

        // Arahkan pengguna kembali ke indeks semester yang sesuai
        return redirect()->route('pegawaigolongan.index', ['semester' => $semester])->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($semester, $id)
    {
        $model = $this->modelMapping[$semester] ?? pegawai_golongan1::class;

        // Temukan data yang akan dihapus berdasarkan ID
        $dataToDelete = $model::findOrFail($id);

        // Hapus data
        $dataToDelete->delete();

        return redirect()->route('pegawaigolongan.index', ['semester' => $semester])->with('success', 'Data berhasil dihapus.');
    }
}
