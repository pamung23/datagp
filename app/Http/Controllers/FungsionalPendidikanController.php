<?php

namespace App\Http\Controllers;

use App\Exports\FungsionalPendidikanExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\fungsional_pendidikan1;
use App\Models\fungsional_pendidikan2;

class FungsionalPendidikanController extends Controller
{
    protected $modelMapping = [
        1 => fungsional_pendidikan1::class,
        2 => fungsional_pendidikan2::class,

    ];

    public function index(Request $request)
    {
        $semester = $request->input('semester', 1);
        $year = $request->input('year'); // Get the selected year from the request

        $model = $this->modelMapping[$semester] ?? fungsional_pendidikan1::class;

        // Fetch data based on the selected year (if provided)
        $query = $model::query();

        if ($year) {
            $query->whereYear('created_at', $year);
        }

        $fungsional = $query->get();

        // Fetch the unique years from the selected model
        $uniqueYears = $model::selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        return view('admin.fungsionalpendidikan.index', compact('fungsional', 'semester', 'uniqueYears', 'year'));
    }

    public function exportToExcel(Request $request)
    {
        $semester = $request->query('semester', null);
        $year = $request->query('year', null);

        if ($year && $semester) {
            return Excel::download(new FungsionalPendidikanExport($semester, $year), 'fungsionalpendidikan_semester_' . $semester . '_tahun_' . $year . '.xlsx');
        } elseif ($semester) {
            return Excel::download(new FungsionalPendidikanExport($semester, null), 'fungsionalpendidikan_semester_' . $semester . '.xlsx');
        } else {
            // Redirect to a default page if neither year nor semester is selected
            return redirect()->route('fungsionalpendidikan.index'); // Replace with your desired default route
        }
    }



    public function create($semester)
    {
        $model = $this->modelMapping[$semester] ?? null;
        if (!$model) {
            return redirect()->route('fungsionalpendidikan.index.semester', ['semester' => $semester])->with('error', 'semester tidak valid.');
        }
        // $semester = fungsional1::all(); // Sesuaikan dengan model dan tabel semester Anda

        return view('admin.fungsionalpendidikan.create', compact('semester', 'model'));
    }
    public function store(Request $request)
    {
        $semester = $request->input('semester', null);

        $model = $this->modelMapping[$semester] ?? null;

        if (!$model) {
            return redirect()->route('fungsionalpendidikan.index.semester', ['semester' => $semester])->with('error', 'semester tidak valid.');
        }

        $data = $request->validate([
            'jenis_jabatan_fungsional' => 'required|string',
            'l_s3' => 'required|numeric',
            'p_s3' => 'required|numeric',
            'l_s2' => 'required|numeric',
            'p_s2' => 'required|numeric',
            'l_s1' => 'required|numeric',
            'p_s1' => 'required|numeric',
            'l_d3' => 'required|numeric',
            'p_d3' => 'required|numeric',
            'l_slta' => 'required|numeric',
            'p_slta' => 'required|numeric',
            'l_sltp' => 'required|numeric',
            'p_sltp' => 'required|numeric',
            'l_sd' => 'required|numeric',
            'p_sd' => 'required|numeric',
            'l_jumlah' => 'required|numeric',
            'p_jumlah' => 'required|numeric',
            'total' => 'required|numeric',
            'keterangan' => 'nullable',
        ]);

        // Simpan nilai semester bersama dengan data
        $data['semester'] = $semester;

        if ($model::create($data)) {
            // Data berhasil disimpan, arahkan pengguna ke indeks semester yang sesuai
            return redirect()->route('fungsionalpendidikan.index.semester', ['semester' => $semester])->with('success', 'Data berhasil ditambahkan.');
        } else {
            // Gagal menyimpan data, kembalikan pengguna ke halaman "create" dengan data input sebelumnya
            return redirect()->route('fungsionalpendidikan.create', ['semester' => $semester])->withInput()->withErrors(['Gagal menyimpan data.']);
        }
    }

    public function edit($semester, $id)
    {
        $model = $this->modelMapping[$semester] ?? null;

        if (!$model) {
            return redirect()->route('fungsional.index', ['semester' => $semester])->with('error', 'Temester tidak valid.');
        }

        $data = $model::findOrFail($id);

        return view('admin.fungsionalpendidikan.edit', compact('semester', 'data'));
    }

    public function update(Request $request, $semester, $id)
    {
        $semester = $request->input('semester', 1);

        $model = $this->modelMapping[$semester] ?? null;

        if (!$model) {
            return redirect()->route('fungsionalpendidikan.index', ['semester' => $semester])->with('error', 'semester tidak valid.');
        }

        $data = $request->validate([
            'jenis_jabatan_fungsional' => 'required|string',
            'l_s3' => 'required|numeric',
            'p_s3' => 'required|numeric',
            'l_s2' => 'required|numeric',
            'p_s2' => 'required|numeric',
            'l_s1' => 'required|numeric',
            'p_s1' => 'required|numeric',
            'l_d3' => 'required|numeric',
            'p_d3' => 'required|numeric',
            'l_slta' => 'required|numeric',
            'p_slta' => 'required|numeric',
            'l_sltp' => 'required|numeric',
            'p_sltp' => 'required|numeric',
            'l_sd' => 'required|numeric',
            'p_sd' => 'required|numeric',
            'l_jumlah' => 'required|numeric',
            'p_jumlah' => 'required|numeric',
            'total' => 'required|numeric',
            'keterangan' => 'nullable',
        ]);

        // Temukan data yang akan diperbarui berdasarkan ID
        $dataToUpdate = $model::findOrFail($id);

        // Perbarui data dengan data yang valid
        $dataToUpdate->update($data);

        // Arahkan pengguna kembali ke indeks semester yang sesuai
        return redirect()->route('fungsionalpendidikan.index', ['semester' => $semester])->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($semester, $id)
    {
        $model = $this->modelMapping[$semester] ?? fungsional1::class;

        // Temukan data yang akan dihapus berdasarkan ID
        $dataToDelete = $model::findOrFail($id);

        // Hapus data
        $dataToDelete->delete();

        return redirect()->route('fungsionalpendidikan.index', ['semester' => $semester])->with('success', 'Data berhasil dihapus.');
    }
}
