<?php

namespace App\Http\Controllers;

use App\Exports\PerubahanFungsikkExport;
use Illuminate\Http\Request;
use App\Models\perubahan_fungsikk1;
use App\Models\perubahan_fungsikk2;

class PerubahanFungsiKKController extends Controller
{
    protected $modelMapping = [
        1 => perubahan_fungsikk1::class,
        2 => perubahan_fungsikk2::class,

    ];

    public function index(Request $request)
    {
        $semester = $request->input('semester', 1);
        $year = $request->input('year'); // Get the selected year from the request

        $model = $this->modelMapping[$semester] ?? perubahan_fungsikk1::class;

        // Fetch data based on the selected year (if provided)
        $query = $model::query();

        if ($year) {
            $query->whereYear('created_at', $year);
        }

        $perubahan_fungsikk = $query->get();

        // Fetch the unique years from the selected model
        $uniqueYears = $model::selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        return view('admin.perubahanfungsikk.index', compact('perubahan_fungsikk', 'semester', 'uniqueYears', 'year'));
    }

    public function exportToExcel(Request $request)
    {
        $semester = $request->get('semester');
        $year = $request->get('year');

        if ($semester === 'all') {
            $fileName = 'Perubahan Fungsi dan Perubahan Peruntukan Kawasan Konservasi ALL semester ' . $year . '.xlsx';
        } elseif (in_array($semester, [1, 2, 3, 4])) {
            $fileName = 'Perubahan Fungsi dan Perubahan Peruntukan Kawasan Konservasi semester ' . $semester . ' ' . $year . '.xlsx';
        } else {
            return redirect()->back()->with('error', 'Invalid Semester selected for export.');
        }

        return (new PerubahanFungsikkExport($semester, $year))->download($fileName);
    }



    public function create($semester)
    {
        $model = $this->modelMapping[$semester] ?? null;
        if (!$model) {
            return redirect()->route('perubahanfungsikk.index.semester', ['semester' => $semester])->with('error', 'semester tidak valid.');
        }
        // $semester = perubahan_fungsikk1::all(); // Sesuaikan dengan model dan tabel semester Anda

        return view('admin.perubahanfungsikk.create', compact('semester', 'model'));
    }
    public function store(Request $request)
    {
        $semester = $request->input('semester', null);

        $model = $this->modelMapping[$semester] ?? null;

        if (!$model) {
            return redirect()->route('perubahanfungsikk.index.semester', ['semester' => $semester])->with('error', 'semester tidak valid.');
        }

        $data = $request->validate([
            'nomor1' => 'required|string|max:255',
            'tanggal1' => 'required|date|max:255',
            'luas1' => 'required|string|max:255',
            'nomor2' => 'required|string|max:255',
            'tanggal2' => 'required|date|max:255',
            'luas2' => 'required|string|max:255',
            'fungsi' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
            'luas3' => 'required|string|max:255',
            'keterangan' => 'nullable',
        ]);

        // Simpan nilai semester bersama dengan data
        $data['semester'] = $semester;

        if ($model::create($data)) {
            // Data berhasil disimpan, arahkan pengguna ke indeks semester yang sesuai
            return redirect()->route('perubahanfungsikk.index.semester', ['semester' => $semester])->with('success', 'Data berhasil ditambahkan.');
        } else {
            // Gagal menyimpan data, kembalikan pengguna ke halaman "create" dengan data input sebelumnya
            return redirect()->route('perubahanfungsikk.create', ['semester' => $semester])->withInput()->withErrors(['Gagal menyimpan data.']);
        }
    }

    public function edit($semester, $id)
    {
        $model = $this->modelMapping[$semester] ?? null;

        if (!$model) {
            return redirect()->route('perubahan_fungsikk.index', ['semester' => $semester])->with('error', 'Temester tidak valid.');
        }

        $data = $model::findOrFail($id);

        return view('admin.perubahanfungsikk.edit', compact('semester', 'data'));
    }

    public function update(Request $request, $semester, $id)
    {
        $semester = $request->input('semester', 1);

        $model = $this->modelMapping[$semester] ?? null;

        if (!$model) {
            return redirect()->route('perubahanfungsikk.index', ['semester' => $semester])->with('error', 'semester tidak valid.');
        }

        $data = $request->validate([
            'nomor1' => 'required|string|max:255',
            'tanggal1' => 'required|date|max:255',
            'luas1' => 'required|string|max:255',
            'nomor2' => 'required|string|max:255',
            'tanggal2' => 'required|date|max:255',
            'luas2' => 'required|string|max:255',
            'fungsi' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
            'luas3' => 'required|string|max:255',
            'keterangan' => 'nullable',
        ]);

        // Temukan data yang akan diperbarui berdasarkan ID
        $dataToUpdate = $model::findOrFail($id);

        // Perbarui data dengan data yang valid
        $dataToUpdate->update($data);

        // Arahkan pengguna kembali ke indeks semester yang sesuai
        return redirect()->route('perubahanfungsikk.index', ['semester' => $semester])->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($semester, $id)
    {
        $model = $this->modelMapping[$semester] ?? perubahan_fungsikk1::class;

        // Temukan data yang akan dihapus berdasarkan ID
        $dataToDelete = $model::findOrFail($id);

        // Hapus data
        $dataToDelete->delete();

        return redirect()->route('perubahanfungsikk.index', ['semester' => $semester])->with('success', 'Data berhasil dihapus.');
    }
}
