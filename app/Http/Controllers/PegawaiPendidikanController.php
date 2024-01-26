<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PegawaiPendidikanExport;
use App\Models\pegawai_pendidikan1;
use App\Models\pegawai_pendidikan2;

class PegawaiPendidikanController extends Controller
{
    protected $modelMapping = [
        1 => pegawai_pendidikan1::class,
        2 => pegawai_pendidikan2::class,

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
            $model = $this->modelMapping[$semester] ?? pegawai_pendidikan1::class;
            $modelsToQuery[] = new $model;
        }

        $pegawai_pendidikan = collect();

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

            $pegawai_pendidikan = $pegawai_pendidikan->merge($query->get());
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

        return view('admin.pegawaipendidikan.index', compact('pegawai_pendidikan', 'semester', 'uniqueYears', 'year'));
    }

    public function exportToExcel(Request $request)
    {
        $semester = $request->get('semester');
        $year = $request->get('year');

        // Replace "/" and "\" with an underscore "_"
        $replaceCharacter = '_';

        if ($semester === 'all') {
            $fileName = 'Sebaran PNS_CPNS Menurut Tingkat Pendidikan dan Jenis Kelamin ALL semester ' . $year . '.xlsx';
        } elseif (in_array($semester, [1, 2])) {
            $fileName = 'Sebaran PNS_CPNS Menurut Tingkat Pendidikan dan Jenis Kelamin semester ' . $semester . ' ' . $year . '.xlsx';
        } else {
            return redirect()->back()->with('error', 'Invalid Semester selected for export.');
        }

        // Replace "/" and "\" with the specified character
        $fileName = str_replace(['/', '\\'], $replaceCharacter, $fileName);

        return (new PegawaiPendidikanExport($semester, $year))->download($fileName);
    }


    public function create($semester)
    {
        $model = $this->modelMapping[$semester] ?? null;
        if (!$model) {
            return redirect()->route('pegawaipendidikan.index.semester', ['semester' => $semester])->with('error', 'semester tidak valid.');
        }
        // $semester = Pegawai_Pendidikan1::all(); // Sesuaikan dengan model dan tabel semester Anda

        return view('admin.pegawaipendidikan.create', compact('semester', 'model'));
    }
    public function store(Request $request)
    {
        $semester = $request->input('semester', null);

        $model = $this->modelMapping[$semester] ?? null;

        if (!$model) {
            return redirect()->route('pegawaipendidikan.index.semester', ['semester' => $semester])->with('error', 'semester tidak valid.');
        }

        $data = $request->validate([
            'laki_doktor' => 'required|integer',
            'perempuan_doktor' => 'required|integer',
            'laki_master' => 'required|integer',
            'perempuan_master' => 'required|integer',
            'laki_sarjana' => 'required|integer',
            'perempuan_sarjana' => 'required|integer',
            'laki_sarjana_muda' => 'required|integer',
            'perempuan_sarjana_muda' => 'required|integer',
            'laki_slta' => 'required|integer',
            'perempuan_slta' => 'required|integer',
            'laki_sltp' => 'required|integer',
            'perempuan_sltp' => 'required|integer',
            'laki_sd' => 'required|integer',
            'perempuan_sd' => 'required|integer',
            'laki_jumlah' => 'required|integer',
            'perempuan_jumlah' => 'required|integer',
            'total' => 'required|integer',
            'keterangan' => 'nullable',
        ]);

        // Simpan nilai semester bersama dengan data
        $data['semester'] = $semester;

        if ($model::create($data)) {
            // Data berhasil disimpan, arahkan pengguna ke indeks semester yang sesuai
            return redirect()->route('pegawaipendidikan.index.semester', ['semester' => $semester])->with('success', 'Data berhasil ditambahkan.');
        } else {
            // Gagal menyimpan data, kembalikan pengguna ke halaman "create" dengan data input sebelumnya
            return redirect()->route('pegawaipendidikan.create', ['semester' => $semester])->withInput()->withErrors(['Gagal menyimpan data.']);
        }
    }

    public function edit($semester, $id)
    {
        $model = $this->modelMapping[$semester] ?? null;

        if (!$model) {
            return redirect()->route('pegawai_pendidikan.index', ['semester' => $semester])->with('error', 'Temester tidak valid.');
        }

        $data = $model::findOrFail($id);

        return view('admin.pegawaipendidikan.edit', compact('semester', 'data'));
    }

    public function update(Request $request, $semester, $id)
    {
        $semester = $request->input('semester', 1);

        $model = $this->modelMapping[$semester] ?? null;

        if (!$model) {
            return redirect()->route('pegawaipendidikan.index', ['semester' => $semester])->with('error', 'semester tidak valid.');
        }

        $data = $request->validate([
            'laki_doktor' => 'required|integer',
            'perempuan_doktor' => 'required|integer',
            'laki_master' => 'required|integer',
            'perempuan_master' => 'required|integer',
            'laki_sarjana' => 'required|integer',
            'perempuan_sarjana' => 'required|integer',
            'laki_sarjana_muda' => 'required|integer',
            'perempuan_sarjana_muda' => 'required|integer',
            'laki_slta' => 'required|integer',
            'perempuan_slta' => 'required|integer',
            'laki_sltp' => 'required|integer',
            'perempuan_sltp' => 'required|integer',
            'laki_sd' => 'required|integer',
            'perempuan_sd' => 'required|integer',
            'laki_jumlah' => 'required|integer',
            'perempuan_jumlah' => 'required|integer',
            'total' => 'required|integer',
            'keterangan' => 'nullable',
        ]);

        // Temukan data yang akan diperbarui berdasarkan ID
        $dataToUpdate = $model::findOrFail($id);

        // Perbarui data dengan data yang valid
        $dataToUpdate->update($data);

        // Arahkan pengguna kembali ke indeks semester yang sesuai
        return redirect()->route('pegawaipendidikan.index', ['semester' => $semester])->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($semester, $id)
    {
        $model = $this->modelMapping[$semester] ?? pegawai_pendidikan1::class;

        // Temukan data yang akan dihapus berdasarkan ID
        $dataToDelete = $model::findOrFail($id);

        // Hapus data
        $dataToDelete->delete();

        return redirect()->route('pegawaipendidikan.index', ['semester' => $semester])->with('success', 'Data berhasil dihapus.');
    }
}
