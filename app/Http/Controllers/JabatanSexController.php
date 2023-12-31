<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\JabatanSexExport;
use App\Models\jabatan_sex1;
use App\Models\jabatan_sex2;

class JabatanSexController extends Controller
{
    protected $modelMapping = [
        1 => jabatan_sex1::class,
        2 => jabatan_sex2::class,

    ];

    public function index(Request $request)
    {
        $semester = $request->input('semester', 1);
        $year = $request->input('year'); // Get the selected year from the request

        $model = $this->modelMapping[$semester] ?? jabatan_sex1::class;

        // Fetch data based on the selected year (if provided)
        $query = $model::query();

        if ($year) {
            $query->whereYear('created_at', $year);
        }

        $jabatan_sex = $query->get();

        // Fetch the unique years from the selected model
        $uniqueYears = $model::selectRaw('YEAR(created_at) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        return view('admin.jabatansex.index', compact('jabatan_sex', 'semester', 'uniqueYears', 'year'));
    }

    public function exportToExcel(Request $request)
    {
        $semester = $request->query('semester', null);
        $year = $request->query('year', null);

        if ($year && $semester) {
            return Excel::download(new JabatanSexExport($semester, $year), 'jabatansex_semester_' . $semester . '_tahun_' . $year . '.xlsx');
        } elseif ($semester) {
            return Excel::download(new JabatanSexExport($semester, null), 'jabatansex_semester_' . $semester . '.xlsx');
        } else {
            // Redirect to a default page if neither year nor semester is selected
            return redirect()->route('jabatansex.index'); // Replace with your desired default route
        }
    }



    public function create($semester)
    {
        $model = $this->modelMapping[$semester] ?? null;
        if (!$model) {
            return redirect()->route('jabatansex.index.semester', ['semester' => $semester])->with('error', 'semester tidak valid.');
        }
        // $semester = jabatan_sex1::all(); // Sesuaikan dengan model dan tabel semester Anda

        return view('admin.jabatansex.create', compact('semester', 'model'));
    }
    public function store(Request $request)
    {
        $semester = $request->input('semester', null);

        $model = $this->modelMapping[$semester] ?? null;

        if (!$model) {
            return redirect()->route('jabatansex.index.semester', ['semester' => $semester])->with('error', 'semester tidak valid.');
        }

        $data = $request->validate([
            'laki_ia'=> 'required|integer|max:255',
            'perempuan_ia'=> 'required|integer|max:255',
            'laki_ib'=> 'required|integer|max:255',
            'perempuan_ib'=> 'required|integer|max:255',
            'laki_iia'=> 'required|integer|max:255',
            'perempuan_iia'=> 'required|integer|max:255',
            'laki_iib'=> 'required|integer|max:255',
            'perempuan_iib'=> 'required|integer|max:255',
            'laki_iiia'=> 'required|integer|max:255',
            'perempuan_iiia'=> 'required|integer|max:255',
            'laki_iiib'=> 'required|integer|max:255',
            'perempuan_iiib'=> 'required|integer|max:255',
            'laki_iiic'=> 'required|integer|max:255',
            'perempuan_iiic'=> 'required|integer|max:255',
            'laki_iiid'=> 'required|integer|max:255',
            'perempuan_iiid'=> 'required|integer|max:255',
            'laki_iva'=> 'required|integer|max:255',
            'perempuan_iva'=> 'required|integer|max:255',
            'laki_ivb'=> 'required|integer|max:255',
            'perempuan_ivb'=> 'required|integer|max:255',
            'laki_umum'=> 'required|integer|max:255',
            'perempuan_umum'=> 'required|integer|max:255',
            'laki_tertentu'=> 'required|integer|max:255',
            'perempuan_tertentu'=> 'required|integer|max:255',
            'laki_jumlah'=> 'required|integer|max:255',
            'perempuan_jumlah'=> 'required|integer|max:255',
            'total'=> 'required|integer|max:255',
            'keterangan'=> 'nullable',
        ]);

        // Simpan nilai semester bersama dengan data
        $data['semester'] = $semester;

        if ($model::create($data)) {
            // Data berhasil disimpan, arahkan pengguna ke indeks semester yang sesuai
            return redirect()->route('jabatansex.index.semester', ['semester' => $semester])->with('success', 'Data berhasil ditambahkan.');
        } else {
            // Gagal menyimpan data, kembalikan pengguna ke halaman "create" dengan data input sebelumnya
            return redirect()->route('jabatansex.create', ['semester' => $semester])->withInput()->withErrors(['Gagal menyimpan data.']);
        }
    }

    public function edit($semester, $id)
    {
        $model = $this->modelMapping[$semester] ?? null;

        if (!$model) {
            return redirect()->route('jabatan_sex.index', ['semester' => $semester])->with('error', 'Temester tidak valid.');
        }

        $data = $model::findOrFail($id);

        return view('admin.jabatansex.edit', compact('semester', 'data'));
    }

    public function update(Request $request, $semester, $id)
    {
        $semester = $request->input('semester', 1);

        $model = $this->modelMapping[$semester] ?? null;

        if (!$model) {
            return redirect()->route('jabatansex.index', ['semester' => $semester])->with('error', 'semester tidak valid.');
        }

        $data = $request->validate([
        'laki_ia'=> 'required|integer|max:255',
        'perempuan_ia'=> 'required|integer|max:255',
        'laki_ib'=> 'required|integer|max:255',
        'perempuan_ib'=> 'required|integer|max:255',
        'laki_iia'=> 'required|integer|max:255',
        'perempuan_iia'=> 'required|integer|max:255',
        'laki_iib'=> 'required|integer|max:255',
        'perempuan_iib'=> 'required|integer|max:255',
        'laki_iiia'=> 'required|integer|max:255',
        'perempuan_iiia'=> 'required|integer|max:255',
        'laki_iiib'=> 'required|integer|max:255',
        'perempuan_iiib'=> 'required|integer|max:255',
        'laki_iiic'=> 'required|integer|max:255',
        'perempuan_iiic'=> 'required|integer|max:255',
        'laki_iiid'=> 'required|integer|max:255',
        'perempuan_iiid'=> 'required|integer|max:255',
        'laki_iva'=> 'required|integer|max:255',
        'perempuan_iva'=> 'required|integer|max:255',
        'laki_ivb'=> 'required|integer|max:255',
        'perempuan_ivb'=> 'required|integer|max:255',
        'laki_umum'=> 'required|integer|max:255',
        'perempuan_umum'=> 'required|integer|max:255',
        'laki_tertentu'=> 'required|integer|max:255',
        'perempuan_tertentu'=> 'required|integer|max:255',
        'laki_jumlah'=> 'required|integer|max:255',
        'perempuan_jumlah'=> 'required|integer|max:255',
        'total'=> 'required|integer|max:255',
        'keterangan'=> 'nullable',
        ]);

        // Temukan data yang akan diperbarui berdasarkan ID
        $dataToUpdate = $model::findOrFail($id);

        // Perbarui data dengan data yang valid
        $dataToUpdate->update($data);

        // Arahkan pengguna kembali ke indeks semester yang sesuai
        return redirect()->route('jabatansex.index', ['semester' => $semester])->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($semester, $id)
    {
        $model = $this->modelMapping[$semester] ?? jabatan_sex1::class;

        // Temukan data yang akan dihapus berdasarkan ID
        $dataToDelete = $model::findOrFail($id);

        // Hapus data
        $dataToDelete->delete();

        return redirect()->route('jabatansex.index', ['semester' => $semester])->with('success', 'Data berhasil dihapus.');
    }
}
