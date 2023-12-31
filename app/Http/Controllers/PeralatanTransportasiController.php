<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PeralatanTransportasiExport;
use App\Models\peralatan_transportasi1;
use App\Models\peralatan_transportasi2;

class PeralatanTransportasiController extends Controller
{
    protected $modelMapping = [
        1 => peralatan_transportasi1::class,
        2 => peralatan_transportasi2::class,

    ];

    public function index(Request $request)
    {
        $semester = $request->input('semester', 1);
        $year = $request->input('year'); // Get the selected year from the request

        $model = $this->modelMapping[$semester] ?? peralatan_transportasi1::class;

        // Fetch data based on the selected year (if provided)
        $query = $model::query();

        if ($year) {
            $query->whereYear('created_at', $year);
        }

        $peralatan_transportasi = $query->get();

        // Fetch the unique years from the selected model
        $uniqueYears = $model::selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        return view('admin.peralatantransportasi.index', compact('peralatan_transportasi', 'semester', 'uniqueYears', 'year'));
    }

    public function exportToExcel(Request $request)
    {
        $semester = $request->query('semester', null);
        $year = $request->query('year', null);

        if ($year && $semester) {
            return Excel::download(new PeralatanTransportasiExport($semester, $year), 'peralatantransportasi_semester_' . $semester . '_tahun_' . $year . '.xlsx');
        } elseif ($semester) {
            return Excel::download(new PeralatanTransportasiExport($semester, null), 'peralatantransportasi_semester_' . $semester . '.xlsx');
        } else {
            // Redirect to a default page if neither year nor semester is selected
            return redirect()->route('peralatantransportasi.index'); // Replace with your desired default route
        }
    }



    public function create($semester)
    {
        $model = $this->modelMapping[$semester] ?? null;
        if (!$model) {
            return redirect()->route('peralatantransportasi.index.semester', ['semester' => $semester])->with('error', 'semester tidak valid.');
        }
        // $semester = peralatan_transportasi1::all(); // Sesuaikan dengan model dan tabel semester Anda

        return view('admin.peralatantransportasi.create', compact('semester', 'model'));
    }
    public function store(Request $request)
    {
        $semester = $request->input('semester', null);

        $model = $this->modelMapping[$semester] ?? null;

        if (!$model) {
            return redirect()->route('peralatantransportasi.index.semester', ['semester' => $semester])->with('error', 'semester tidak valid.');
        }

        $data = $request->validate([
            'daops' => 'required|string|max:255',
            'baik1' => 'required|integer|max:255',
            'rusak1' => 'required|integer|max:255',
            'baik2' => 'required|integer|max:255',
            'rusak2' => 'required|integer|max:255',
            'baik3' => 'required|integer|max:255',
            'rusak3' => 'required|integer|max:255',
            'baik4' => 'required|integer|max:255',
            'rusak4' => 'required|integer|max:255',
            'baik5' => 'required|integer|max:255',
            'rusak5' => 'required|integer|max:255',
            'lain1' => 'required|integer|max:255',
            'baik6' => 'required|integer|max:255',
            'rusak6' => 'required|integer|max:255',
            'baik7' => 'required|integer|max:255',
            'rusak7' => 'required|integer|max:255',
            'baik8' => 'required|integer|max:255',
            'rusak8' => 'required|integer|max:255',
            'lain2' => 'required|integer|max:255',
            'keterangan' => 'nullable',
        ]);

        // Simpan nilai semester bersama dengan data
        $data['semester'] = $semester;

        if ($model::create($data)) {
            // Data berhasil disimpan, arahkan pengguna ke indeks semester yang sesuai
            return redirect()->route('peralatantransportasi.index.semester', ['semester' => $semester])->with('success', 'Data berhasil ditambahkan.');
        } else {
            // Gagal menyimpan data, kembalikan pengguna ke halaman "create" dengan data input sebelumnya
            return redirect()->route('peralatantransportasi.create', ['semester' => $semester])->withInput()->withErrors(['Gagal menyimpan data.']);
        }
    }

    public function edit($semester, $id)
    {
        $model = $this->modelMapping[$semester] ?? null;

        if (!$model) {
            return redirect()->route('peralatan_transportasi.index', ['semester' => $semester])->with('error', 'Temester tidak valid.');
        }

        $data = $model::findOrFail($id);

        return view('admin.peralatantransportasi.edit', compact('semester', 'data'));
    }

    public function update(Request $request, $semester, $id)
    {
        $semester = $request->input('semester', 1);

        $model = $this->modelMapping[$semester] ?? null;

        if (!$model) {
            return redirect()->route('peralatantransportasi.index', ['semester' => $semester])->with('error', 'semester tidak valid.');
        }

        $data = $request->validate([
            'daops' => 'required|string|max:255',
            'baik1' => 'required|integer|max:255',
            'rusak1' => 'required|integer|max:255',
            'baik2' => 'required|integer|max:255',
            'rusak2' => 'required|integer|max:255',
            'baik3' => 'required|integer|max:255',
            'rusak3' => 'required|integer|max:255',
            'baik4' => 'required|integer|max:255',
            'rusak4' => 'required|integer|max:255',
            'baik5' => 'required|integer|max:255',
            'rusak5' => 'required|integer|max:255',
            'lain1' => 'required|integer|max:255',
            'baik6' => 'required|integer|max:255',
            'rusak6' => 'required|integer|max:255',
            'baik7' => 'required|integer|max:255',
            'rusak7' => 'required|integer|max:255',
            'baik8' => 'required|integer|max:255',
            'rusak8' => 'required|integer|max:255',
            'lain2' => 'required|integer|max:255',
            'keterangan' => 'nullable',
        ]);

        // Temukan data yang akan diperbarui berdasarkan ID
        $dataToUpdate = $model::findOrFail($id);

        // Perbarui data dengan data yang valid
        $dataToUpdate->update($data);

        // Arahkan pengguna kembali ke indeks semester yang sesuai
        return redirect()->route('peralatantransportasi.index', ['semester' => $semester])->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($semester, $id)
    {
        $model = $this->modelMapping[$semester] ?? peralatan_transportasi1::class;

        // Temukan data yang akan dihapus berdasarkan ID
        $dataToDelete = $model::findOrFail($id);

        // Hapus data
        $dataToDelete->delete();

        return redirect()->route('peralatantransportasi.index', ['semester' => $semester])->with('success', 'Data berhasil dihapus.');
    }
}
