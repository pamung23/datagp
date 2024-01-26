<?php

namespace App\Http\Controllers;

use App\Exports\FungsionalExport;
use App\Models\fungsional1;
use App\Models\fungsional2;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class FungsionalController extends Controller
{
    protected $modelMapping = [
        1 => fungsional1::class,
        2 => fungsional2::class,

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
            $model = $this->modelMapping[$semester] ?? fungsional1::class;
            $modelsToQuery[] = new $model;
        }

        $fungsional = collect();

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

            $fungsional = $fungsional->merge($query->get());
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

        return view('admin.fungsional.index', compact('fungsional', 'semester', 'uniqueYears', 'year'));
    }

    public function exportToExcel(Request $request)
    {
        $semester = $request->get('semester');
        $year = $request->get('year');

        // Replace "/" and "\" with an underscore "_"
        $replaceCharacter = '_';

        if ($semester === 'all') {
            $fileName = 'Sebaran Pejabat Fungsional Tertentu Menurut Fungsi dan Jenjang Jabatan ALL semester ' . $year . '.xlsx';
        } elseif (in_array($semester, [1, 2])) {
            $fileName = 'Sebaran Pejabat Fungsional Tertentu Menurut Fungsi dan Jenjang Jabatan semester ' . $semester . ' ' . $year . '.xlsx';
        } else {
            return redirect()->back()->with('error', 'Invalid Semester selected for export.');
        }

        // Replace "/" and "\" with the specified character
        $fileName = str_replace(['/', '\\'], $replaceCharacter, $fileName);

        return (new FungsionalExport($semester, $year))->download($fileName);
    }



    public function create($semester)
    {
        $model = $this->modelMapping[$semester] ?? null;
        if (!$model) {
            return redirect()->route('fungsional.index.semester', ['semester' => $semester])->with('error', 'semester tidak valid.');
        }
        // $semester = fungsional_sex1::all(); // Sesuaikan dengan model dan tabel semester Anda

        return view('admin.fungsional.create', compact('semester', 'model'));
    }
    public function store(Request $request)
    {
        $semester = $request->input('semester', null);

        $model = $this->modelMapping[$semester] ?? null;

        if (!$model) {
            return redirect()->route('fungsional.index.semester', ['semester' => $semester])->with('error', 'semester tidak valid.');
        }

        $data = $request->validate([
            'calon_terampil_peh' => 'required|integer',
            'terampil_peh' => 'required|integer',
            'calon_ahli_peh' => 'required|integer',
            'ahli_peh' => 'required|integer',
            'jumlah_peh' => 'required|integer',
            'calon_terampil_polhut' => 'required|integer',
            'terampil_polhut' => 'required|integer',
            'calon_ahli_polhut' => 'required|integer',
            'ahli_polhut' => 'required|integer',
            'jumlah_polhut' => 'required|integer',
            'calon_terampil_penyuluh' => 'required|integer',
            'terampil_penyuluh' => 'required|integer',
            'calon_ahli_penyuluh' => 'required|integer',
            'ahli_penyuluh' => 'required|integer',
            'jumlah_penyuluh' => 'required|integer',
            'calon_terampil_pranata' => 'required|integer',
            'terampil_pranata' => 'required|integer',
            'calon_ahli_pranata' => 'required|integer',
            'ahli_pranata' => 'required|integer',
            'jumlah_pranata' => 'required|integer',
            'calon_terampil_statis' => 'required|integer',
            'terampil_statis' => 'required|integer',
            'calon_ahli_statis' => 'required|integer',
            'ahli_statis' => 'required|integer',
            'jumlah_statis' => 'required|integer',
            'calon_terampil_analisis' => 'required|integer',
            'terampil_analisis' => 'required|integer',
            'calon_ahli_analisis' => 'required|integer',
            'ahli_analisis' => 'required|integer',
            'jumlah_analisis' => 'required|integer',
            'calon_terampil_arsiparis' => 'required|integer',
            'terampil_arsiparis' => 'required|integer',
            'calon_ahli_arsiparis' => 'required|integer',
            'ahli_arsiparis' => 'required|integer',
            'jumlah_arsiparis' => 'required|integer',
            'calon_terampil_perencana' => 'required|integer',
            'terampil_perencana' => 'required|integer',
            'calon_ahli_perencana' => 'required|integer',
            'ahli_perencana' => 'required|integer',
            'jumlah_perencana' => 'required|integer',
            'calon_terampil_pengadaan' => 'required|integer',
            'terampil_pengadaan' => 'required|integer',
            'calon_ahli_pengadaan' => 'required|integer',
            'ahli_pengadaan' => 'required|integer',
            'jumlah_pengadaan' => 'required|integer',
            'total' => 'required|integer',
            'keterangan' => 'nullable|string',
        ]);

        // Simpan nilai semester bersama dengan data
        $data['semester'] = $semester;

        if ($model::create($data)) {
            // Data berhasil disimpan, arahkan pengguna ke indeks semester yang sesuai
            return redirect()->route('fungsional.index.semester', ['semester' => $semester])->with('success', 'Data berhasil ditambahkan.');
        } else {
            // Gagal menyimpan data, kembalikan pengguna ke halaman "create" dengan data input sebelumnya
            return redirect()->route('fungsional.create', ['semester' => $semester])->withInput()->withErrors(['Gagal menyimpan data.']);
        }
    }

    public function edit($semester, $id)
    {
        $model = $this->modelMapping[$semester] ?? null;

        if (!$model) {
            return redirect()->route('fungsional_sex.index', ['semester' => $semester])->with('error', 'Temester tidak valid.');
        }

        $data = $model::findOrFail($id);

        return view('admin.fungsional.edit', compact('semester', 'data'));
    }

    public function update(Request $request, $semester, $id)
    {
        $semester = $request->input('semester', 1);

        $model = $this->modelMapping[$semester] ?? null;

        if (!$model) {
            return redirect()->route('fungsional.index', ['semester' => $semester])->with('error', 'semester tidak valid.');
        }

        $data = $request->validate([
            'calon_terampil_peh' => 'required|integer',
            'terampil_peh' => 'required|integer',
            'calon_ahli_peh' => 'required|integer',
            'ahli_peh' => 'required|integer',
            'jumlah_peh' => 'required|integer',
            'calon_terampil_polhut' => 'required|integer',
            'terampil_polhut' => 'required|integer',
            'calon_ahli_polhut' => 'required|integer',
            'ahli_polhut' => 'required|integer',
            'jumlah_polhut' => 'required|integer',
            'calon_terampil_penyuluh' => 'required|integer',
            'terampil_penyuluh' => 'required|integer',
            'calon_ahli_penyuluh' => 'required|integer',
            'ahli_penyuluh' => 'required|integer',
            'jumlah_penyuluh' => 'required|integer',
            'calon_terampil_pranata' => 'required|integer',
            'terampil_pranata' => 'required|integer',
            'calon_ahli_pranata' => 'required|integer',
            'ahli_pranata' => 'required|integer',
            'jumlah_pranata' => 'required|integer',
            'calon_terampil_statis' => 'required|integer',
            'terampil_statis' => 'required|integer',
            'calon_ahli_statis' => 'required|integer',
            'ahli_statis' => 'required|integer',
            'jumlah_statis' => 'required|integer',
            'calon_terampil_analisis' => 'required|integer',
            'terampil_analisis' => 'required|integer',
            'calon_ahli_analisis' => 'required|integer',
            'ahli_analisis' => 'required|integer',
            'jumlah_analisis' => 'required|integer',
            'calon_terampil_arsiparis' => 'required|integer',
            'terampil_arsiparis' => 'required|integer',
            'calon_ahli_arsiparis' => 'required|integer',
            'ahli_arsiparis' => 'required|integer',
            'jumlah_arsiparis' => 'required|integer',
            'calon_terampil_perencana' => 'required|integer',
            'terampil_perencana' => 'required|integer',
            'calon_ahli_perencana' => 'required|integer',
            'ahli_perencana' => 'required|integer',
            'jumlah_perencana' => 'required|integer',
            'calon_terampil_pengadaan' => 'required|integer',
            'terampil_pengadaan' => 'required|integer',
            'calon_ahli_pengadaan' => 'required|integer',
            'ahli_pengadaan' => 'required|integer',
            'jumlah_pengadaan' => 'required|integer',
            'total' => 'required|integer',
            'keterangan' => 'nullable|string',
        ]);

        // Temukan data yang akan diperbarui berdasarkan ID
        $dataToUpdate = $model::findOrFail($id);

        // Perbarui data dengan data yang valid
        $dataToUpdate->update($data);

        // Arahkan pengguna kembali ke indeks semester yang sesuai
        return redirect()->route('fungsional.index', ['semester' => $semester])->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($semester, $id)
    {
        $model = $this->modelMapping[$semester] ?? fungsional1::class;

        // Temukan data yang akan dihapus berdasarkan ID
        $dataToDelete = $model::findOrFail($id);

        // Hapus data
        $dataToDelete->delete();

        return redirect()->route('fungsional.index', ['semester' => $semester])->with('success', 'Data berhasil dihapus.');
    }
}
