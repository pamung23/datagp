<?php

namespace App\Http\Controllers;

use App\Exports\KerjasamaExport;
use App\Models\kerjasama1;
use App\Models\kerjasama2;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class KerjasamaController extends Controller
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
        1 => kerjasama1::class,
        2 => kerjasama2::class,

    ];

    public function index(Request $request)
    {
        $semester = $request->input('semester', 1);
        $year = $request->input('year');
        $modelsToQuery = [];

        // Ambil level pengguna saat ini
        $userLevel = auth()->user()->level;

        // Inisialisasi array level yang diizinkan mengakses semua triwulan
        $levelsAllowedForAllsemester = ['Admin', 'Balai'];

        if (in_array($userLevel, $levelsAllowedForAllsemester)) {
            // Jika level pengguna adalah 'Admin' atau 'Balai', perbolehkan akses ke semua triwulan
            foreach ($this->modelMapping as $model) {
                $modelsToQuery[] = new $model;
            }
        } elseif (in_array($userLevel, ['Wilayah Cianjur', 'Wilayah Sukabumi', 'Wilayah Bogor'])) {
            // Jika level pengguna adalah 'Wilayah Cianjur', 'Wilayah Sukabumi', atau 'Wilayah Bogor',
            // batasi akses hanya ke triwulan yang dipilih dan resort yang sesuai
            $model = $this->modelMapping[$semester] ?? kerjasama1::class;
            $modelsToQuery[] = new $model;
        }

        $kerjasama = collect();

        foreach ($modelsToQuery as $model) {
            $query = $model::query()->with('user.resort');

            if ($year) {
                $query->whereYear('created_at', $year);
            }

            // Jika level pengguna adalah 'Wilayah Cianjur', 'Wilayah Sukabumi', atau 'Wilayah Bogor',
            // tambahkan kondisi untuk membatasi berdasarkan resort
            if (in_array($userLevel, ['Wilayah Cianjur', 'Wilayah Sukabumi', 'Wilayah Bogor'])) {
                $query->whereHas('user.resort', function ($subquery) use ($userLevel) {
                    $subquery->where('nama', auth()->user()->resort->nama);
                });
            }

            $kerjasama = $kerjasama->merge($query->get());
        }

        $uniqueYears = collect();

        foreach ($modelsToQuery as $model) {
            $years = $model::selectRaw('YEAR(created_at) as year')
                ->distinct()
                ->orderBy('year', 'desc')
                ->pluck('year');

            $uniqueYears = $uniqueYears->merge($years);
        }

        // Filter out duplicates and sort the unique years
        $uniqueYears = $uniqueYears->unique()->sort()->reverse();
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
        $kerjasama = $kerjasama->map(function ($item) {
            $item->tanggal_mou = $item->tanggal_mou ? Carbon::parse($item->tanggal_mou)->translatedFormat('d F Y') : '';
            $item->tanggal_awal_berlaku = $item->tanggal_awal_berlaku ? Carbon::parse($item->tanggal_awal_berlaku)->translatedFormat('d F Y') : '';
            $item->tanggal_akhir_berlaku = $item->tanggal_akhir_berlaku ? Carbon::parse($item->tanggal_akhir_berlaku)->translatedFormat('d F Y') : '';
            return $item;
        });

        return view('admin.kerjasama.index', compact('kerjasama', 'semester', 'uniqueYears', 'year'));
    }


    public function exportToExcel(Request $request)
    {
        $semester = $request->query('semester', null);
        $year = $request->query('year', null);

        if ($year && $semester) {
            return Excel::download(new KerjasamaExport($semester, $year), 'kerjasama_semester_' . $semester . '_tahun_' . $year . '.xlsx');
        } elseif ($semester) {
            return Excel::download(new KerjasamaExport($semester, null), 'kerjasama_semester_' . $semester . '.xlsx');
        } else {
            // Redirect to a default page if neither year nor semester is selected
            return redirect()->route('kerjasama.index'); // Replace with your desired default route
        }
    }



    public function create($semester)
    {
        $model = $this->modelMapping[$semester] ?? null;
        if (!$model) {
            return redirect()->route('kerjasama.index.semester', ['semester' => $semester])->with('error', 'semester tidak valid.');
        }
        // $semester = kerjasama1s::all(); // Sesuaikan dengan model dan tabel semester Anda

        return view('admin.kerjasama.create', compact('semester', 'model'));
    }


    public function store(Request $request)
    {
        $semester = $request->input('semester', null);

        $model = $this->modelMapping[$semester] ?? null;

        if (!$model) {
            return redirect()->route('kerjasama.index.semester', ['semester' => $semester])->with('error', 'Semester tidak valid.');
        }
        $data = $request->validate([
            'tipe_kerjasama' => 'required|in:Penguatan Fungsi,Pembangunan Strategis',
            'mitra_kerjasama' => 'required|string|max:150',
            'judul_kerjasama' => 'required|string|max:255',
            'ruang_lingkup_kerjasama' => 'required|string',
            'nomor_mou' => 'required|string|max:50',
            'tanggal_mou' => 'required|date',
            'tanggal_awal_berlaku' => 'required|date',
            'tanggal_akhir_berlaku' => 'required|date|after:tanggal_awal_berlaku',
            'keterangan' => 'nullable|string',
        ]);
        // Simpan nilai Semester bersama dengan data
        $data['semester'] = $semester;

        if ($model::create($data)) {
            // Data berhasil disimpan, arahkan pengguna ke indeks semester yang sesuai
            return redirect()->route('kerjasama.index.semester', ['semester' => $semester])->with('success', 'Data berhasil ditambahkan.');
        } else {
            // Gagal menyimpan data, kembalikan pengguna ke halaman "create" dengan data input sebelumnya
            return redirect()->route('kerjasama.create', ['semester' => $semester])->withInput()->withErrors(['Gagal menyimpan data.']);
        }
    }

    public function edit($semester, $id)
    {
        $model = $this->modelMapping[$semester] ?? null;

        if (!$model) {
            return redirect()->route('kerjasama.index.semester', ['semester' => $semester])->with('error', 'semester tidak valid.');
        }

        $data = $model::find($id);
        $dataSebaran = $data->tipe; // Sesuaikan ini dengan nama kolom yang menyimpan relasi prasarana

        return view('admin.kerjasama.edit', compact('semester', 'model', 'dataSebaran', 'data'));
    }

    public function update(Request $request, $semester, $id)
    {

        $model = $this->modelMapping[$semester] ?? null;

        if (!$model) {
            return redirect()->route('kerjasama.index.semester', ['semester' => $semester])->with('error', 'semester tidak valid.');
        }
        $data = $model::findOrFail($id);
        $input = $request->all();
        // Konversi koma menjadi titik pada data numerik
        $numericFields = [
            'inti', 'rimba', 'pemanfaatan', 'perlindungan', 'perlindungan_bahari',
            'rehabilitasi', 'tradisional', 'religi', 'khusus', 'koleksi', 'lainnya', 'total'
        ];

        foreach ($numericFields as $field) {
            if (isset($input[$field])) {
                $input[$field] = str_replace(',', '.', $input[$field]);
            }
        }

        // Validasi setelah transformasi nilai input
        $validatedData = validator($input, [
            'tipe_kerjasama' => 'required|in:Penguatan Fungsi,Pembangunan Strategis',
            'mitra_kerjasama' => 'required|string|max:150',
            'judul_kerjasama' => 'required|string|max:255',
            'ruang_lingkup_kerjasama' => 'required|string',
            'nomor_mou' => 'required|string|max:50',
            'tanggal_mou' => 'required|date',
            'tanggal_awal_berlaku' => 'required|date',
            'tanggal_akhir_berlaku' => 'required|date|after:tanggal_awal_berlaku',
            'keterangan' => 'nullable|string',
        ])->validate();


        $data->update($validatedData);

        return redirect()->route('kerjasama.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($semester, $id)
    {
        $model = $this->modelMapping[$semester] ?? kerjasama1::class;

        // Temukan data yang akan dihapus berdasarkan ID
        $dataToDelete = $model::findOrFail($id);

        // Hapus data
        $dataToDelete->delete();

        return redirect()->route('kerjasama.index', ['semester' => $semester])->with('success', 'Data berhasil dihapus.');
    }
}
