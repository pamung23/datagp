<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SaranaPengamatanExport;
use App\Models\sarana_pengamatan1;
use App\Models\sarana_pengamatan2;

class SaranaPengamatanController extends Controller
{
    protected $modelMapping = [
        1 => sarana_pengamatan1::class,
        2 => sarana_pengamatan2::class,

    ];

    public function index(Request $request)
    {
        $semester = $request->input('semester', 1);
        $year = $request->input('year'); // Get the selected year from the request

        $model = $this->modelMapping[$semester] ?? sarana_pengamatan1::class;

        // Fetch data based on the selected year (if provided)
        $query = $model::query();

        if ($year) {
            $query->whereYear('created_at', $year);
        }

        $sarana_pengamatan = $query->get();

        // Fetch the unique years from the selected model
        $uniqueYears = $model::selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        return view('admin.saranapengamatan.index', compact('sarana_pengamatan', 'semester', 'uniqueYears', 'year'));
    }

    public function exportToExcel(Request $request)
    {
        $semester = $request->query('semester', null);
        $year = $request->query('year', null);

        if ($year && $semester) {
            return Excel::download(new SaranaPengamatanExport($semester, $year), 'saranapengamatan_semester_' . $semester . '_tahun_' . $year . '.xlsx');
        } elseif ($semester) {
            return Excel::download(new SaranaPengamatanExport($semester, null), 'saranapengamatan_semester_' . $semester . '.xlsx');
        } else {
            // Redirect to a default page if neither year nor semester is selected
            return redirect()->route('saranapengamatan.index'); // Replace with your desired default route
        }
    }



    public function create($semester)
    {
        $model = $this->modelMapping[$semester] ?? null;
        if (!$model) {
            return redirect()->route('saranapengamatan.index.semester', ['semester' => $semester])->with('error', 'semester tidak valid.');
        }
        // $semester = sarana_pengamatan1::all(); // Sesuaikan dengan model dan tabel semester Anda

        return view('admin.saranapengamatan.create', compact('semester', 'model'));
    }
    public function store(Request $request)
    {
        $semester = $request->input('semester', null);

        $model = $this->modelMapping[$semester] ?? null;

        if (!$model) {
            return redirect()->route('saranapengamatan.index.semester', ['semester' => $semester])->with('error', 'semester tidak valid.');
        }

        $data = $request->validate([
            'genggam' => 'required|integer|max:255',
            'laras_panjang' => 'required|integer|max:255',
            'senjata_bius' => 'required|integer|max:255',
            'lain1' => 'required|integer|max:255',
            'mobil' => 'required|integer|max:255',
            'spd_motor' => 'required|integer|max:255',
            'speed_boat' => 'required|integer|max:255',
            'perahu' => 'required|integer|max:255',
            'pesawat' => 'required|integer|max:255',
            'lain2' => 'required|integer|max:255',
            'rick' => 'required|integer|max:255',
            'ht' => 'required|integer|max:255',
            'ssb' => 'required|integer|max:255',
            'lain3' => 'required|integer|max:255',
            'keterangan' => 'nullable',
        ]);

        // Simpan nilai semester bersama dengan data
        $data['semester'] = $semester;

        if ($model::create($data)) {
            // Data berhasil disimpan, arahkan pengguna ke indeks semester yang sesuai
            return redirect()->route('saranapengamatan.index.semester', ['semester' => $semester])->with('success', 'Data berhasil ditambahkan.');
        } else {
            // Gagal menyimpan data, kembalikan pengguna ke halaman "create" dengan data input sebelumnya
            return redirect()->route('saranapengamatan.create', ['semester' => $semester])->withInput()->withErrors(['Gagal menyimpan data.']);
        }
    }

    public function edit($semester, $id)
    {
        $model = $this->modelMapping[$semester] ?? null;

        if (!$model) {
            return redirect()->route('sarana_pengamatan.index', ['semester' => $semester])->with('error', 'Temester tidak valid.');
        }

        $data = $model::findOrFail($id);

        return view('admin.saranapengamatan.edit', compact('semester', 'data'));
    }

    public function update(Request $request, $semester, $id)
    {
        $semester = $request->input('semester', 1);

        $model = $this->modelMapping[$semester] ?? null;

        if (!$model) {
            return redirect()->route('saranapengamatan.index', ['semester' => $semester])->with('error', 'semester tidak valid.');
        }

        $data = $request->validate([
            'genggam' => 'required|integer|max:255',
            'laras_panjang' => 'required|integer|max:255',
            'senjata_bius' => 'required|integer|max:255',
            'lain1' => 'required|integer|max:255',
            'mobil' => 'required|integer|max:255',
            'spd_motor' => 'required|integer|max:255',
            'speed_boat' => 'required|integer|max:255',
            'perahu' => 'required|integer|max:255',
            'pesawat' => 'required|integer|max:255',
            'lain2' => 'required|integer|max:255',
            'rick' => 'required|integer|max:255',
            'ht' => 'required|integer|max:255',
            'ssb' => 'required|integer|max:255',
            'lain3' => 'required|integer|max:255',
            'keterangan' => 'nullable',
        ]);

        // Temukan data yang akan diperbarui berdasarkan ID
        $dataToUpdate = $model::findOrFail($id);

        // Perbarui data dengan data yang valid
        $dataToUpdate->update($data);

        // Arahkan pengguna kembali ke indeks semester yang sesuai
        return redirect()->route('saranapengamatan.index', ['semester' => $semester])->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($semester, $id)
    {
        $model = $this->modelMapping[$semester] ?? sarana_pengamatan1::class;

        // Temukan data yang akan dihapus berdasarkan ID
        $dataToDelete = $model::findOrFail($id);

        // Hapus data
        $dataToDelete->delete();

        return redirect()->route('saranapengamatan.index', ['semester' => $semester])->with('success', 'Data berhasil dihapus.');
    }
}
