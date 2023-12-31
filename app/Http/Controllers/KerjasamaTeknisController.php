<?php

namespace App\Http\Controllers;

use App\Exports\KerjasamaTeknisExport;
use App\Models\fungsional_pendidikan1;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\kerjasama_teknis1;
use App\Models\kerjasama_teknis2;
use Maatwebsite\Excel\Facades\Excel;

class KerjasamaTeknisController extends Controller
{
    function bulanIndonesia($bulan)
    {
        $bulanIndo = [
            'January' => 'Januari',
            'February' => 'Februari',
            'March' => 'Maret',
            'April' => 'April',
            'May' => 'Mei',
            'June' => 'Juni',
            'July' => 'Juli',
            'August' => 'Agustus',
            'September' => 'September',
            'October' => 'Oktober',
            'November' => 'November',
            'December' => 'Desember'
        ];

        return $bulanIndo[$bulan];
    }
    protected $modelMapping = [
        1 => kerjasama_teknis1::class,
        2 => kerjasama_teknis2::class,

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

        // Function to convert English month to Indonesian
        function getMonthInBahasa($englishMonth)
        {
            $months = [
                'January' => 'Januari',
                'February' => 'Februari',
                'March' => 'Maret',
                'April' => 'April',
                'May' => 'Mei',
                'June' => 'Juni',
                'July' => 'Juli',
                'August' => 'Agustus',
                'September' => 'September',
                'October' => 'Oktober',
                'November' => 'November',
                'December' => 'Desember',
            ];

            return $months[$englishMonth];
        }
        $fungsional = $fungsional->map(function ($item) {
            $item->tanggal_mou_pks = $item->tanggal_mou_pks ? Carbon::parse($item->tanggal_mou_pks)->translatedFormat('d F Y') : '';
            $item->tanggal_awal_berlaku = $item->tanggal_awal_berlaku ? Carbon::parse($item->tanggal_awal_berlaku)->translatedFormat('d F Y') : '';
            $item->tanggal_akhir_berlaku = $item->tanggal_akhir_berlaku ? Carbon::parse($item->tanggal_akhir_berlaku)->translatedFormat('d F Y') : '';
            return $item;
        });


        return view('admin.kerjasamateknis.index', compact('fungsional', 'semester', 'uniqueYears', 'year'));
    }

    public function exportToExcel(Request $request)
    {
        $semester = $request->query('semester', null);
        $year = $request->query('year', null);

        if ($year && $semester) {
            return Excel::download(new KerjasamaTeknisExport($semester, $year), 'kerjasamateknis_semester_' . $semester . '_tahun_' . $year . '.xlsx');
        } elseif ($semester) {
            return Excel::download(new KerjasamaTeknisExport($semester, null), 'kerjasamateknis_semester_' . $semester . '.xlsx');
        } else {
            // Redirect to a default page if neither year nor semester is selected
            return redirect()->route('kerjasamateknis.index'); // Replace with your desired default route
        }
    }



    public function create($semester)
    {
        $model = $this->modelMapping[$semester] ?? null;
        if (!$model) {
            return redirect()->route('kerjasamateknis.index.semester', ['semester' => $semester])->with('error', 'semester tidak valid.');
        }
        // $semester = fungsional1::all(); // Sesuaikan dengan model dan tabel semester Anda

        return view('admin.kerjasamateknis.create', compact('semester', 'model'));
    }
    public function store(Request $request)
    {
        $semester = $request->input('semester', null);

        $model = $this->modelMapping[$semester] ?? null;

        if (!$model) {
            return redirect()->route('kerjasamateknis.index.semester', ['semester' => $semester])->with('error', 'semester tidak valid.');
        }

        $data = $request->validate([
            'mitra_kerja' => 'required',
            'tipe_mitra' => 'required',
            'jenis_kerja_sama' => 'required',
            'judul_kerja_sama' => 'required',
            'ruang_lingkup_kerja_sama' => 'required',
            'no_mou_pks' => 'required',
            'tanggal_mou_pks' => 'required|date', // Mengharuskan format tanggal
            'persetujuan_kerja_sama' => 'required',
            'tanggal_awal_berlaku' => 'required|date', // Mengharuskan format tanggal
            'tanggal_akhir_berlaku' => 'required|date', // Mengharuskan format tanggal
            'lokasi_kerja_konservasi' => 'required',
            'lokasi_kerja_provinsi' => 'required',
            'luas_areal_kerja_sama' => 'required',
            'komitmen_pendanaan' => 'required',
            'ikp_ikk_berkaitan' => 'required',
            'status_kerja_sama' => 'required',
            'keterangan' => 'nullable',
        ]);

        // Simpan nilai semester bersama dengan data
        $data['semester'] = $semester;

        if ($model::create($data)) {
            // Data berhasil disimpan, arahkan pengguna ke indeks semester yang sesuai
            return redirect()->route('kerjasamateknis.index.semester', ['semester' => $semester])->with('success', 'Data berhasil ditambahkan.');
        } else {
            // Gagal menyimpan data, kembalikan pengguna ke halaman "create" dengan data input sebelumnya
            return redirect()->route('kerjasamateknis.create', ['semester' => $semester])->withInput()->withErrors(['Gagal menyimpan data.']);
        }
    }

    public function edit($semester, $id)
    {
        $model = $this->modelMapping[$semester] ?? null;

        if (!$model) {
            return redirect()->route('fungsional.index', ['semester' => $semester])->with('error', 'Temester tidak valid.');
        }

        $data = $model::findOrFail($id);

        return view('admin.kerjasamateknis.edit', compact('semester', 'data'));
    }

    public function update(Request $request, $semester, $id)
    {
        $semester = $request->input('semester', 1);

        $model = $this->modelMapping[$semester] ?? null;

        if (!$model) {
            return redirect()->route('kerjasamateknis.index', ['semester' => $semester])->with('error', 'semester tidak valid.');
        }

        $data = $request->validate([
            'mitra_kerja' => 'required',
            'tipe_mitra' => 'required',
            'jenis_kerja_sama' => 'required',
            'judul_kerja_sama' => 'required',
            'ruang_lingkup_kerja_sama' => 'required',
            'no_mou_pks' => 'required',
            'tanggal_mou_pks' => 'required|date', // Mengharuskan format tanggal
            'persetujuan_kerja_sama' => 'required',
            'tanggal_awal_berlaku' => 'required|date', // Mengharuskan format tanggal
            'tanggal_akhir_berlaku' => 'required|date', // Mengharuskan format tanggal
            'lokasi_kerja_konservasi' => 'required',
            'lokasi_kerja_provinsi' => 'required',
            'luas_areal_kerja_sama' => 'required',
            'komitmen_pendanaan' => 'required',
            'ikp_ikk_berkaitan' => 'required',
            'status_kerja_sama' => 'required',
            'keterangan' => 'nullable',
        ]);

        // Temukan data yang akan diperbarui berdasarkan ID
        $dataToUpdate = $model::findOrFail($id);

        // Perbarui data dengan data yang valid
        $dataToUpdate->update($data);

        // Arahkan pengguna kembali ke indeks semester yang sesuai
        return redirect()->route('kerjasamateknis.index', ['semester' => $semester])->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($semester, $id)
    {
        $model = $this->modelMapping[$semester] ?? kerjasama_teknis1::class;

        // Temukan data yang akan dihapus berdasarkan ID
        $dataToDelete = $model::findOrFail($id);

        // Hapus data
        $dataToDelete->delete();

        return redirect()->route('kerjasamateknis.index', ['semester' => $semester])->with('success', 'Data berhasil dihapus.');
    }
}
