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
        $year = $request->input('year'); // Get the selected year from the request

        $model = $this->modelMapping[$semester] ?? fungsional1::class;

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

        return view('admin.fungsional.index', compact('fungsional', 'semester', 'uniqueYears', 'year'));
    }

    public function exportToExcel(Request $request)
    {
        $semester = $request->query('semester', null);
        $year = $request->query('year', null);

        if ($year && $semester) {
            return Excel::download(new FungsionalExport($semester, $year), 'fungsional_semester_' . $semester . '_tahun_' . $year . '.xlsx');
        } elseif ($semester) {
            return Excel::download(new FungsionalExport($semester, null), 'fungsional_semester_' . $semester . '.xlsx');
        } else {
            // Redirect to a default page if neither year nor semester is selected
            return redirect()->route('fungsionalsex.index'); // Replace with your desired default route
        }
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
            'peh' => 'required|integer',
            'jumlah_peh' => 'required|integer',
            'polhut' => 'required|integer',
            'jumlah_polhut' => 'required|integer',
            'penyuluh' => 'required|integer',
            'jumlah_penyuluh' => 'required|integer',
            'pranata' => 'required|integer',
            'jumlah_pranata' => 'required|integer',
            'statis' => 'required|integer',
            'jumlah_statis' => 'required|integer',
            'analisis' => 'required|integer',
            'jumlah_analisis' => 'required|integer',
            'arsiparis' => 'required|integer',
            'jumlah_arsiparis' => 'required|integer',
            'perencanana' => 'required|integer',
            'jumlah_perencanana' => 'required|integer',
            'pengadaan' => 'required|integer',
            'jumlah_pengadaan' => 'required|integer',
            'total' => 'nullable|integer',
            'keterangan' => 'nullable',
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
            'peh' => 'required|integer',
            'jumlah_peh' => 'required|integer',
            'polhut' => 'required|integer',
            'jumlah_polhut' => 'required|integer',
            'penyuluh' => 'required|integer',
            'jumlah_penyuluh' => 'required|integer',
            'pranata' => 'required|integer',
            'jumlah_pranata' => 'required|integer',
            'statis' => 'required|integer',
            'jumlah_statis' => 'required|integer',
            'analisis' => 'required|integer',
            'jumlah_analisis' => 'required|integer',
            'arsiparis' => 'required|integer',
            'jumlah_arsiparis' => 'required|integer',
            'perencanana' => 'required|integer',
            'jumlah_perencanana' => 'required|integer',
            'pengadaan' => 'required|integer',
            'jumlah_pengadaan' => 'required|integer',
            'total' => 'nullable|integer',
            'keterangan' => 'nullable',
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
        $model = $this->modelMapping[$semester] ?? fungsional_sex1::class;

        // Temukan data yang akan dihapus berdasarkan ID
        $dataToDelete = $model::findOrFail($id);

        // Hapus data
        $dataToDelete->delete();

        return redirect()->route('fungsional.index', ['semester' => $semester])->with('success', 'Data berhasil dihapus.');
    }
}
