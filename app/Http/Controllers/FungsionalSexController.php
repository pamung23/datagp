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
        $year = $request->input('year'); // Get the selected year from the request

        $model = $this->modelMapping[$semester] ?? fungsional_sex1::class;

        // Fetch data based on the selected year (if provided)
        $query = $model::query();

        if ($year) {
            $query->whereYear('created_at', $year);
        }

        $fungsional_sex = $query->get();

        // Fetch the unique years from the selected model
        $uniqueYears = $model::selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        return view('admin.fungsionalsex.index', compact('fungsional_sex', 'semester', 'uniqueYears', 'year'));
    }

    public function exportToExcel(Request $request)
    {
        $semester = $request->query('semester', null);
        $year = $request->query('year', null);

        if ($year && $semester) {
            return Excel::download(new FungsionalSexExport($semester, $year), 'fungsionalsex_semester_' . $semester . '_tahun_' . $year . '.xlsx');
        } elseif ($semester) {
            return Excel::download(new FungsionalSexExport($semester, null), 'fungsionalsex_semester_' . $semester . '.xlsx');
        } else {
            // Redirect to a default page if neither year nor semester is selected
            return redirect()->route('fungsionalsex.index'); // Replace with your desired default route
        }
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
