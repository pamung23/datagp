<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Zonasi1;
use App\Models\Zonasi2;
use Illuminate\Http\Request;
use App\Exports\ZonasiExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class ZonasiController extends Controller
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
        1 => Zonasi1::class,
        2 => Zonasi2::class,

    ];

    public function index(Request $request)
    {
        $semester = $request->input('semester', 1);
        $year = $request->input('year'); // Get the selected year from the request

        $model = $this->modelMapping[$semester] ?? Zonasi1::class;

        // Fetch data based on the selected year (if provided)
        $query = $model::query();

        if ($year) {
            $query->whereYear('created_at', $year);
        }

        $zonasi = $query->get();

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

        $zonasi = $zonasi->map(function ($item) {
            $item->tanggal = $item->tanggal ? Carbon::parse($item->tanggal)->translatedFormat('d F Y') : '';
            return $item;
        });

        return view('admin.zonasi.index', compact('zonasi', 'semester', 'uniqueYears', 'year'));
    }

    public function exportToExcel(Request $request)
    {
        $semester = $request->get('semester');
        $year = $request->get('year');

        if ($semester === 'all') {
            $fileName = 'Penataan Kawasan Konservasi ALL semester ' . $year . '.xlsx';
        } elseif (in_array($semester, [1, 2, 3, 4])) {
            $fileName = 'Penataan Kawasan Konservasi semester ' . $semester . ' ' . $year . '.xlsx';
        } else {
            return redirect()->back()->with('error', 'Invalid Semester selected for export.');
        }

        return (new ZonasiExport($semester, $year))->download($fileName);
    }



    public function create($semester)
    {
        $model = $this->modelMapping[$semester] ?? null;
        if (!$model) {
            return redirect()->route('zonasi.index.semester', ['semester' => $semester])->with('error', 'semester tidak valid.');
        }
        // $semester = zonasi1s::all(); // Sesuaikan dengan model dan tabel semester Anda

        return view('admin.zonasi.create', compact('semester', 'model'));
    }


    public function store(Request $request)
    {
        $semester = $request->input('semester', null);
        $model = $this->modelMapping[$semester] ?? null;

        if (!$model) {
            return redirect()->route('zonasi.index.semester', ['semester' => $semester])->with('error', 'semester tidak valid.');
        }

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
            'nomor' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'inti' => 'required|numeric',
            'rimba' => 'required|numeric',
            'pemanfaatan' => 'required|numeric',
            'perlindungan' => 'required|numeric',
            'perlindungan_bahari' => 'required|numeric',
            'rehabilitasi' => 'required|numeric',
            'tradisional' => 'required|numeric',
            'religi' => 'required|numeric',
            'khusus' => 'required|numeric',
            'koleksi' => 'required|numeric',
            'lainnya' => 'required|numeric',
            'total' => 'nullable|numeric',
            'keterangan' => 'nullable|string',
        ])->validate();

        $validatedData['semester'] = $semester;

        // Simpan data yang sudah diubah formatnya ke dalam database
        if ($model::create($validatedData)) {
            return redirect()->route('zonasi.index.semester', ['semester' => $semester])->with('success', 'Data berhasil ditambahkan.');
        } else {
            return redirect()->route('zonasi.create', ['semester' => $semester])->withInput()->withErrors(['Gagal menyimpan data.']);
        }
    }


    public function edit($semester, $id)
    {
        $model = $this->modelMapping[$semester] ?? null;

        if (!$model) {
            return redirect()->route('zonasi.index.semester', ['semester' => $semester])->with('error', 'semester tidak valid.');
        }

        $data = $model::find($id);
        $dataSebaran = $data->tipe; // Sesuaikan ini dengan nama kolom yang menyimpan relasi prasarana

        return view('admin.zonasi.edit', compact('semester', 'model', 'dataSebaran', 'data'));
    }

    public function update(Request $request, $semester, $id)
    {

        $model = $this->modelMapping[$semester] ?? null;

        if (!$model) {
            return redirect()->route('zonasi.index.semester', ['semester' => $semester])->with('error', 'semester tidak valid.');
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
            'nomor' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'inti' => 'required|numeric',
            'rimba' => 'required|numeric',
            'pemanfaatan' => 'required|numeric',
            'perlindungan' => 'required|numeric',
            'perlindungan_bahari' => 'required|numeric',
            'rehabilitasi' => 'required|numeric',
            'tradisional' => 'required|numeric',
            'religi' => 'required|numeric',
            'khusus' => 'required|numeric',
            'koleksi' => 'required|numeric',
            'lainnya' => 'required|numeric',
            'total' => 'nullable|numeric',
            'keterangan' => 'nullable|string',
        ])->validate();


        $data->update($validatedData);

        return redirect()->route('zonasi.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($semester, $id)
    {
        $model = $this->modelMapping[$semester] ?? zonasi1::class;

        // Temukan data yang akan dihapus berdasarkan ID
        $dataToDelete = $model::findOrFail($id);

        // Hapus data
        $dataToDelete->delete();

        return redirect()->route('zonasi.index', ['semester' => $semester])->with('success', 'Data berhasil dihapus.');
    }
}
