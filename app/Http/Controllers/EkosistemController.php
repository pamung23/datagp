<?php

namespace App\Http\Controllers;

use App\Models\Ekosistem1;
use App\Models\Ekosistem2;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EkosistemExport;
use Illuminate\Http\Request;

class EkosistemController extends Controller
{
    protected $modelMapping = [
        1 => Ekosistem1::class,
        2 => Ekosistem2::class,

    ];

    public function index(Request $request)
    {
        $semester = $request->input('semester', 1);
        $year = $request->input('year'); // Get the selected year from the request

        $model = $this->modelMapping[$semester] ?? Ekosistem1::class;

        // Fetch data based on the selected year (if provided)
        $query = $model::query();

        if ($year) {
            $query->whereYear('created_at', $year);
        }

        $ekosistem = $query->get();

        // Fetch the unique years from the selected model
        $uniqueYears = $model::selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        return view('admin.ekosistem.index', compact('ekosistem', 'semester', 'uniqueYears', 'year'));
    }

    public function exportToExcel(Request $request)
    {
        $semester = $request->query('semester', null);
        $year = $request->query('year', null);

        if ($year && $semester) {
            return Excel::download(new EkosistemExport($semester, $year), 'ekosistem_semester_' . $semester . '_tahun_' . $year . '.xlsx');
        } elseif ($semester) {
            return Excel::download(new EkosistemExport($semester, null), 'ekosistem_semester_' . $semester . '.xlsx');
        } else {
            // Redirect to a default page if neither year nor semester is selected
            return redirect()->route('ekosistem.index'); // Replace with your desired default route
        }
    }



    public function create($semester)
    {
        $model = $this->modelMapping[$semester] ?? null;
        if (!$model) {
            return redirect()->route('ekosistem.index.semester', ['semester' => $semester])->with('error', 'semester tidak valid.');
        }
        // $semester = ekosistem1s::all(); // Sesuaikan dengan model dan tabel semester Anda

        return view('admin.ekosistem.create', compact('semester', 'model'));
    }
    public function store(Request $request)
    {
        $semester = $request->input('semester', null);

        $ekosmodel = $this->modelMapping[$semester] ?? null;

        if (!$ekosmodel) {
            return redirect()->route('ekosistem.index.semester', ['semester' => $semester])->with('error', 'semester tidak valid.');
        }

        $data = $request->validate([
            'tipe.*' => 'required|string|max:255',
            'luas.*' => 'required|numeric|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $ekosistem = $ekosmodel::create($data);
        // Handle array data and save them if needed
        if ($request->has('array_data')) {
            $arrayData = $request->input('array_data');
            $ekosistem->arrayData()->createMany($arrayData);
        }
        return redirect()->route('ekosistem.index')->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit($semester, $id)
    {
        $model = $this->modelMapping[$semester] ?? null;

        if (!$model) {
            return redirect()->route('ekosistem.index.semester', ['semester' => $semester])->with('error', 'semester tidak valid.');
        }

        $data = $model::find($id);
        $dataSebaran = $data->tipe; // Sesuaikan ini dengan nama kolom yang menyimpan relasi prasarana

        return view('admin.ekosistem.edit', compact('semester', 'model', 'dataSebaran', 'data'));
    }

    public function update(Request $request, $semester, $id)
    {

        $model = $this->modelMapping[$semester] ?? null;

        if (!$model) {
            return redirect()->route('ekosistem.index.semester', ['semester' => $semester])->with('error', 'semester tidak valid.');
        }
        $data = $model::findOrFail($id);

        $validatedData = $request->validate([
            'tipe.*' => 'required|string|max:255',
            'luas.*' => 'required|numeric|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $data->update($validatedData);

        // Update JSON fields
        $tipe = $request->input('tipe', []);
        $luas = $request->input('luas', []);

        $data->update([
            'tipe' => $tipe,
            'luas' => $luas,
        ]);
        return redirect()->route('ekosistem.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($semester, $id)
    {
        $model = $this->modelMapping[$semester] ?? ekosistem1s::class;

        // Temukan data yang akan dihapus berdasarkan ID
        $dataToDelete = $model::findOrFail($id);

        // Hapus data
        $dataToDelete->delete();

        return redirect()->route('ekosistem.index', ['semester' => $semester])->with('success', 'Data berhasil dihapus.');
    }
}
