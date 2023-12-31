<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PemeliharaanBatasExport;
use App\Models\pemeliharaan_batas1;
use App\Models\pemeliharaan_batas2;


class PemeliharaanBatasController extends Controller
{
    protected $modelMapping = [
        1 => pemeliharaan_batas1::class,
        2 => pemeliharaan_batas2::class,

    ];

    public function index(Request $request)
    {
        $semester = $request->input('semester', 1);
        $year = $request->input('year'); // Dapatkan tahun yang dipilih dari permintaan

        $model = $this->modelMapping[$semester] ?? pemeliharaan_batas1::class;

        // Ambil data berdasarkan tahun yang dipilih (jika disediakan)
        $query = $model::query();

        if ($year) {
            $query->whereYear('created_at', $year);
        }

        $pemeliharaanbatas = $query->get();

        // Ambil tahun unik dari model yang dipilih
        $uniqueYears = $model::selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        return view('admin.pemeliharaanbatas.index', compact('pemeliharaanbatas', 'semester', 'uniqueYears', 'year'));
    }


    public function exportToExcel(Request $request)
    {
        $semester = $request->query('semester', null);
        $year = $request->query('year', null);

        if ($year && $semester) {
            return Excel::download(new PemeliharaanBatasExport($semester, $year), 'pemeliharaanbatas_semester_' . $semester . '_tahun_' . $year . '.xlsx');
        } elseif ($semester) {
            return Excel::download(new PemeliharaanBatasExport($semester, null), 'pemeliharaanbatas_semester_' . $semester . '.xlsx');
        } else {
            // Redirect to 'pemeliharaanbatas.index' route if neither year nor semester is selected
            return redirect()->route('pemeliharaanbatas.index');
        }
    }

    public function create($semester)
    {
        $model = $this->modelMapping[$semester] ?? null;
        if (!$model) {
            return redirect()->route('pemeliharaanbatas.index.semester', ['semester' => $semester])->with('error', 'semester tidak valid.');
        }
        //  $semester = pemeliharaanbatas1::all(); // Sesuaikan dengan model dan tabel semester Anda

        return view('admin.pemeliharaanbatas.create', compact('semester', 'model'));
    }
    public function store(Request $request)
    {
        $semester = $request->input('semester', null);

        $model = $this->modelMapping[$semester] ?? null;

        if (!$model) {
            return redirect()->route('pemeliharaanbatas.index.semester', ['semester' => $semester])->with('error', 'Semester tidak valid.');
        }

        $data = $request->validate([
            'p_batas' => 'required|integer|max:255',
            'tahun' => 'required|date|max:255',
            'panjang' => 'required|integer|max:255',
            'jmlh_batas' => 'required|integer|max:255',
            'nomor' => 'required|integer|max:255',
            'tanggal' => 'required|date|max:255',
            'keterangan' => 'nullable',
        ]);

        // Simpan nilai Semester bersama dengan data
        $data['semester'] = $semester;

        if ($model::create($data)) {
            // Data berhasil disimpan, arahkan pengguna ke indeks semester yang sesuai
            return redirect()->route('pemeliharaanbatas.index.semester', ['semester' => $semester])->with('success', 'Data berhasil ditambahkan.');
        } else {
            // Gagal menyimpan data, kembalikan pengguna ke halaman "create" dengan data input sebelumnya
            return redirect()->route('pemeliharaanbatas.create', ['semester' => $semester])->withInput()->withErrors(['Gagal menyimpan data.']);
        }
    }

    public function edit($semester, $id)
    {
        $model = $this->modelMapping[$semester] ?? null;

        if (!$model) {
            return redirect()->route('pemeliharaanbatas.index', ['semester' => $semester])->with('error', 'Temester tidak valid.');
        }

        $data = $model::findOrFail($id);

        return view('admin.pemeliharaanbatas.edit', compact('semester', 'data'));
    }

    public function update(Request $request, $semester, $id)
    {
        $semester = $request->input('semester', 1);

        $model = $this->modelMapping[$semester] ?? null;

        if (!$model) {
            return redirect()->route('pemeliharaanbatas.index', ['semester' => $semester])->with('error', 'Semester tidak valid.');
        }

        $data = $request->validate([
            'p_batas' => 'required|integer|max:255',
            'tahun' => 'required|date|max:255',
            'panjang' => 'required|integer|max:255',
            'jmlh_batas' => 'required|integer|max:255',
            'nomor' => 'required|integer|max:255',
            'tanggal' => 'required|date|max:255',
            'keterangan' => 'nullable',
        ]);

        // Temukan data yang akan diperbarui berdasarkan ID
        $dataToUpdate = $model::findOrFail($id);

        // Perbarui data dengan data yang valid
        $dataToUpdate->update($data);

        // Arahkan pengguna kembali ke indeks semester yang sesuai
        return redirect()->route('pemeliharaanbatas.index', ['semester' => $semester])->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($semester, $id)
    {
        $model = $this->modelMapping[$semester] ?? pemeliharaan_batas1::class;

        // Temukan data yang akan dihapus berdasarkan ID
        $dataToDelete = $model::findOrFail($id);

        // Hapus data
        $dataToDelete->delete();

        return redirect()->route('pemeliharaanbatas.index', ['semester' => $semester])->with('success', 'Data berhasil dihapus.');
    }
}
