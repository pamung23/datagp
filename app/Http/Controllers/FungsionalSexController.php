<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\FungsionalSexExport;
use App\Models\fungsional_sex1;
use App\Models\fungsional_sex2;

class FungsionalSexController extends Controller
{
    protected $modelMapping = [
        1 => fungsional_sex1::class,
        2 => fungsional_sex2::class,

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
            $model = $this->modelMapping[$semester] ?? fungsional_sex1::class;
            $modelsToQuery[] = new $model;
        }

        $fungsional_sex = collect();

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

            $fungsional_sex = $fungsional_sex->merge($query->get());
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

        return view('admin.fungsionalsex.index', compact('fungsional_sex', 'semester', 'uniqueYears', 'year'));
    }

    public function exportToExcel(Request $request)
    {
        $semester = $request->get('semester');
        $year = $request->get('year');

        // Replace "/" and "\" with an underscore "_"
        $replaceCharacter = '_';

        if ($semester === 'all') {
            $fileName = 'Sebaran Pejabat Fungsional Tertentu Menurut Fungsi dan Jenis Kelamin ALL semester ' . $year . '.xlsx';
        } elseif (in_array($semester, [1, 2])) {
            $fileName = 'Sebaran Pejabat Fungsional Tertentu Menurut Fungsi dan Jenis Kelamin semester ' . $semester . ' ' . $year . '.xlsx';
        } else {
            return redirect()->back()->with('error', 'Invalid Semester selected for export.');
        }

        // Replace "/" and "\" with the specified character
        $fileName = str_replace(['/', '\\'], $replaceCharacter, $fileName);

        return (new FungsionalSexExport($semester, $year))->download($fileName);
    }



    public function create($semester)
    {
        $model = $this->modelMapping[$semester] ?? null;
        if (!$model) {
            return redirect()->route('fungsionalsex.index.semester', ['semester' => $semester])->with('error', 'semester tidak valid.');
        }
        // $semester = fungsional_sex1::all(); // Sesuaikan dengan model dan tabel semester Anda

        return view('admin.fungsionalsex.create', compact('semester', 'model'));
    }
    public function store(Request $request)
    {
        $semester = $request->input('semester', null);

        $model = $this->modelMapping[$semester] ?? null;

        if (!$model) {
            return redirect()->route('fungsionalsex.index.semester', ['semester' => $semester])->with('error', 'semester tidak valid.');
        }

        $data = $request->validate([
            'laki_peh' => 'required|integer|max:255',
            'perempuan_peh' => 'required|integer|max:255',
            'laki_polhut' => 'required|integer|max:255',
            'perempuan_polhut' => 'required|integer|max:255',
            'laki_penyuluh' => 'required|integer|max:255',
            'perempuan_penyuluh' => 'required|integer|max:255',
            'laki_pranata' => 'required|integer|max:255',
            'perempuan_pranata' => 'required|integer|max:255',
            'laki_statistisi' => 'required|integer|max:255',
            'perempuan_statistisi' => 'required|integer|max:255',
            'laki_analis' => 'required|integer|max:255',
            'perempuan_analis' => 'required|integer|max:255',
            'laki_arsiparis' => 'required|integer|max:255',
            'perempuan_arsiparis' => 'required|integer|max:255',
            'laki_perencana' => 'required|integer|max:255',
            'perempuan_perencana' => 'required|integer|max:255',
            'laki_pengadaan' => 'required|integer|max:255',
            'perempuan_pengadaan' => 'required|integer|max:255',
            'laki_jumlah' => 'required|integer|max:255',
            'perempuan_jumlah' => 'required|integer|max:255',
            'total' => 'required|integer|max:255',
            'keterangan' => 'nullable',
        ]);

        // Simpan nilai semester bersama dengan data
        $data['semester'] = $semester;

        if ($model::create($data)) {
            // Data berhasil disimpan, arahkan pengguna ke indeks semester yang sesuai
            return redirect()->route('fungsionalsex.index.semester', ['semester' => $semester])->with('success', 'Data berhasil ditambahkan.');
        } else {
            // Gagal menyimpan data, kembalikan pengguna ke halaman "create" dengan data input sebelumnya
            return redirect()->route('fungsionalsex.create', ['semester' => $semester])->withInput()->withErrors(['Gagal menyimpan data.']);
        }
    }

    public function edit($semester, $id)
    {
        $model = $this->modelMapping[$semester] ?? null;

        if (!$model) {
            return redirect()->route('fungsional_sex.index', ['semester' => $semester])->with('error', 'Temester tidak valid.');
        }

        $data = $model::findOrFail($id);

        return view('admin.fungsionalsex.edit', compact('semester', 'data'));
    }

    public function update(Request $request, $semester, $id)
    {
        $semester = $request->input('semester', 1);

        $model = $this->modelMapping[$semester] ?? null;

        if (!$model) {
            return redirect()->route('fungsionalsex.index', ['semester' => $semester])->with('error', 'semester tidak valid.');
        }

        $data = $request->validate([
            'laki_peh' => 'required|integer|max:255',
            'perempuan_peh' => 'required|integer|max:255',
            'laki_polhut' => 'required|integer|max:255',
            'perempuan_polhut' => 'required|integer|max:255',
            'laki_penyuluh' => 'required|integer|max:255',
            'perempuan_penyuluh' => 'required|integer|max:255',
            'laki_pranata' => 'required|integer|max:255',
            'perempuan_pranata' => 'required|integer|max:255',
            'laki_statistisi' => 'required|integer|max:255',
            'perempuan_statistisi' => 'required|integer|max:255',
            'laki_analis' => 'required|integer|max:255',
            'perempuan_analis' => 'required|integer|max:255',
            'laki_arsiparis' => 'required|integer|max:255',
            'perempuan_arsiparis' => 'required|integer|max:255',
            'laki_perencana' => 'required|integer|max:255',
            'perempuan_perencana' => 'required|integer|max:255',
            'laki_pengadaan' => 'required|integer|max:255',
            'perempuan_pengadaan' => 'required|integer|max:255',
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
        return redirect()->route('fungsionalsex.index', ['semester' => $semester])->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($semester, $id)
    {
        $model = $this->modelMapping[$semester] ?? fungsional_sex1::class;

        // Temukan data yang akan dihapus berdasarkan ID
        $dataToDelete = $model::findOrFail($id);

        // Hapus data
        $dataToDelete->delete();

        return redirect()->route('fungsionalsex.index', ['semester' => $semester])->with('success', 'Data berhasil dihapus.');
    }
}
