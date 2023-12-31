<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\HonorerExport;
use App\Models\honorer1;
use App\Models\honorer2;

class HonorerController extends Controller
{
    protected $modelMapping = [
        1 => honorer1::class,
        2 => honorer2::class,

    ];

    public function index(Request $request)
    {
        $semester = $request->input('semester', 1);
        $year = $request->input('year'); // Get the selected year from the request

        $model = $this->modelMapping[$semester] ?? honorer1::class;

        // Fetch data based on the selected year (if provided)
        $query = $model::query();

        if ($year) {
            $query->whereYear('created_at', $year);
        }

        $honorer = $query->get();

        // Fetch the unique years from the selected model
        $uniqueYears = $model::selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        return view('admin.honorer.index', compact('honorer', 'semester', 'uniqueYears', 'year'));
    }

    public function exportToExcel(Request $request)
    {
        $semester = $request->query('semester', null);
        $year = $request->query('year', null);

        if ($year && $semester) {
            return Excel::download(new HonorerExport($semester, $year), 'honorer_semester_' . $semester . '_tahun_' . $year . '.xlsx');
        } elseif ($semester) {
            return Excel::download(new HonorerExport($semester, null), 'honorer_semester_' . $semester . '.xlsx');
        } else {
            // Redirect to a default page if neither year nor semester is selected
            return redirect()->route('honorer.index'); // Replace with your desired default route
        }
    }



    public function create($semester)
    {
        $model = $this->modelMapping[$semester] ?? null;
        if (!$model) {
            return redirect()->route('honorer.index.semester', ['semester' => $semester])->with('error', 'semester tidak valid.');
        }
        // $semester = honorer1::all(); // Sesuaikan dengan model dan tabel semester Anda

        return view('admin.honorer.create', compact('semester', 'model'));
    }
    public function store(Request $request)
    {
        $semester = $request->input('semester', null);

        $model = $this->modelMapping[$semester] ?? null;

        if (!$model) {
            return redirect()->route('honorer.index.semester', ['semester' => $semester])->with('error', 'semester tidak valid.');
        }

        $data = $request->validate([
            'laki_sarjana' => 'required|integer|max:255',
            'perempuan_sarjana' => 'required|integer|max:255',
            'laki_sarjana_muda' => 'required|integer|max:255',
            'perempuan_sarjana_muda' => 'required|integer|max:255',
            'laki_slta' => 'required|integer|max:255',
            'perempuan_slta' => 'required|integer|max:255',
            'laki_sltp' => 'required|integer|max:255',
            'perempuan_sltp' => 'required|integer|max:255',
            'laki_sd' => 'required|integer|max:255',
            'perempuan_sd' => 'required|integer|max:255',
            'laki_jumlah' => 'required|integer|max:255',
            'perempuan_jumlah' => 'required|integer|max:255',
            'total' => 'required|integer|max:255',
            'keterangan' => 'nullable',
        ]);

        // Simpan nilai semester bersama dengan data
        $data['semester'] = $semester;

        if ($model::create($data)) {
            // Data berhasil disimpan, arahkan pengguna ke indeks semester yang sesuai
            return redirect()->route('honorer.index.semester', ['semester' => $semester])->with('success', 'Data berhasil ditambahkan.');
        } else {
            // Gagal menyimpan data, kembalikan pengguna ke halaman "create" dengan data input sebelumnya
            return redirect()->route('honorer.create', ['semester' => $semester])->withInput()->withErrors(['Gagal menyimpan data.']);
        }
    }

    public function edit($semester, $id)
    {
        $model = $this->modelMapping[$semester] ?? null;

        if (!$model) {
            return redirect()->route('honorer.index', ['semester' => $semester])->with('error', 'Temester tidak valid.');
        }

        $data = $model::findOrFail($id);

        return view('admin.honorer.edit', compact('semester', 'data'));
    }

    public function update(Request $request, $semester, $id)
    {
        $semester = $request->input('semester', 1);

        $model = $this->modelMapping[$semester] ?? null;

        if (!$model) {
            return redirect()->route('honorer.index', ['semester' => $semester])->with('error', 'semester tidak valid.');
        }

        $data = $request->validate([
            'laki_sarjana' => 'required|integer|max:255',
            'perempuan_sarjana' => 'required|integer|max:255',
            'laki_sarjana_muda' => 'required|integer|max:255',
            'perempuan_sarjana_muda' => 'required|integer|max:255',
            'laki_slta' => 'required|integer|max:255',
            'perempuan_slta' => 'required|integer|max:255',
            'laki_sltp' => 'required|integer|max:255',
            'perempuan_sltp' => 'required|integer|max:255',
            'laki_sd' => 'required|integer|max:255',
            'perempuan_sd' => 'required|integer|max:255',
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
        return redirect()->route('honorer.index', ['semester' => $semester])->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($semester, $id)
    {
        $model = $this->modelMapping[$semester] ?? honorer1::class;

        // Temukan data yang akan dihapus berdasarkan ID
        $dataToDelete = $model::findOrFail($id);

        // Hapus data
        $dataToDelete->delete();

        return redirect()->route('honorer.index', ['semester' => $semester])->with('success', 'Data berhasil dihapus.');
    }
}
