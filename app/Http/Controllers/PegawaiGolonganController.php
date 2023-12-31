<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PegawaiGolonganExport;
use App\Models\pegawai_golongan1;
use App\Models\pegawai_golongan2;

class PegawaiGolonganController extends Controller
{
    protected $modelMapping = [
        1 => pegawai_golongan1::class,
        2 => pegawai_golongan2::class,

    ];

    public function index(Request $request)
    {
        $semester = $request->input('semester', 1);
        $year = $request->input('year'); // Get the selected year from the request

        $model = $this->modelMapping[$semester] ?? pegawai_golongan1::class;

        // Fetch data based on the selected year (if provided)
        $query = $model::query();

        if ($year) {
            $query->whereYear('created_at', $year);
        }

        $pegawai_golongan = $query->get();

        // Fetch the unique years from the selected model
        $uniqueYears = $model::selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        return view('admin.pegawaigolongan.index', compact('pegawai_golongan', 'semester', 'uniqueYears', 'year'));
    }

    public function exportToExcel(Request $request)
    {
        $semester = $request->query('semester', null);
        $year = $request->query('year', null);

        if ($year && $semester) {
            return Excel::download(new PegawaiGolonganExport($semester, $year), 'pegawaigolongan_semester_' . $semester . '_tahun_' . $year . '.xlsx');
        } elseif ($semester) {
            return Excel::download(new PegawaiGolonganExport($semester, null), 'pegawaigolongan_semester_' . $semester . '.xlsx');
        } else {
            // Redirect to a default page if neither year nor semester is selected
            return redirect()->route('pegawaigolongan.index'); // Replace with your desired default route
        }
    }



    public function create($semester)
    {
        $model = $this->modelMapping[$semester] ?? null;
        if (!$model) {
            return redirect()->route('pegawaigolongan.index.semester', ['semester' => $semester])->with('error', 'semester tidak valid.');
        }
        // $semester = Pegawai_golongan1::all(); // Sesuaikan dengan model dan tabel semester Anda

        return view('admin.pegawaigolongan.create', compact('semester', 'model'));
    }
    public function store(Request $request)
    {
        $semester = $request->input('semester', null);

        $model = $this->modelMapping[$semester] ?? null;

        if (!$model) {
            return redirect()->route('pegawaigolongan.index.semester', ['semester' => $semester])->with('error', 'semester tidak valid.');
        }

        $data = $request->validate([
            'laki_iv' => 'required|integer|max:255',
            'perempuan_iv' => 'required|integer|max:255',
            'laki_iii' => 'required|integer|max:255',
            'perempuan_iii' => 'required|integer|max:255',
            'laki_ii' => 'required|integer|max:255',
            'perempuan_ii' => 'required|integer|max:255',
            'laki_i' => 'required|integer|max:255',
            'perempuan_i' => 'required|integer|max:255',
            'laki_jumlah' => 'required|integer|max:255',
            'perempuan_jumlah' => 'required|integer|max:255',
            'total' => 'required|integer|max:255',
            'keterangan' => 'nullable',
        ]);

        // Simpan nilai semester bersama dengan data
        $data['semester'] = $semester;

        if ($model::create($data)) {
            // Data berhasil disimpan, arahkan pengguna ke indeks semester yang sesuai
            return redirect()->route('pegawaigolongan.index.semester', ['semester' => $semester])->with('success', 'Data berhasil ditambahkan.');
        } else {
            // Gagal menyimpan data, kembalikan pengguna ke halaman "create" dengan data input sebelumnya
            return redirect()->route('pegawaigolongan.create', ['semester' => $semester])->withInput()->withErrors(['Gagal menyimpan data.']);
        }
    }

    public function edit($semester, $id)
    {
        $model = $this->modelMapping[$semester] ?? null;

        if (!$model) {
            return redirect()->route('pegawai_golongan.index', ['semester' => $semester])->with('error', 'Temester tidak valid.');
        }

        $data = $model::findOrFail($id);

        return view('admin.pegawaigolongan.edit', compact('semester', 'data'));
    }

    public function update(Request $request, $semester, $id)
    {
        $semester = $request->input('semester', 1);

        $model = $this->modelMapping[$semester] ?? null;

        if (!$model) {
            return redirect()->route('pegawaigolongan.index', ['semester' => $semester])->with('error', 'semester tidak valid.');
        }

        $data = $request->validate([
            'laki_iv' => 'required|integer|max:255',
            'perempuan_iv' => 'required|integer|max:255',
            'laki_iii' => 'required|integer|max:255',
            'perempuan_iii' => 'required|integer|max:255',
            'laki_ii' => 'required|integer|max:255',
            'perempuan_ii' => 'required|integer|max:255',
            'laki_i' => 'required|integer|max:255',
            'perempuan_i' => 'required|integer|max:255',
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
        return redirect()->route('pegawaigolongan.index', ['semester' => $semester])->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($semester, $id)
    {
        $model = $this->modelMapping[$semester] ?? pegawai_golongan1::class;

        // Temukan data yang akan dihapus berdasarkan ID
        $dataToDelete = $model::findOrFail($id);

        // Hapus data
        $dataToDelete->delete();

        return redirect()->route('pegawaigolongan.index', ['semester' => $semester])->with('success', 'Data berhasil dihapus.');
    }
}
