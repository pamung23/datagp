<?php

namespace App\Exports;

use App\Models\kerjasama_teknis1;
use App\Models\kerjasama_teknis2;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class KerjasamaTeknisExport implements FromCollection, WithHeadings, WithStyles, WithMapping
{
    use Exportable;

    protected $semester;
    protected $year;

    public function __construct($semester, $year)
    {
        $this->semester = $semester;
        $this->year = $year;
    }

    protected function getModelForsemester($semester)
    {
        // Buat peta pemetaan model untuk semester tertentu
        $modelMapping = [
            1 => kerjasama_teknis1::class,
            2 => kerjasama_teknis2::class,
        ];

        return $modelMapping[$semester] ?? null;
    }


    public function collection()
    {
        // Ambil nama kelas model yang sesuai berdasarkan semester
        $modelClass = $this->getModelForsemester($this->semester);

        if (!$modelClass) {
            return collect(); // Return empty collection jika model tidak ditemukan
        }

        // Buat instance model berdasarkan kelas
        $model = new $modelClass();

        // Query dan ambil data sesuai dengan model dan tahun yang dipilih
        $query = $model->query();

        if ($this->year) {
            $query->whereYear('created_at', $this->year);
        }

        $data = $query->get();

        // Tambahkan nomor urut pada setiap baris
        $data->each(function ($item, $key) {
            $item->nomor_urut = $key + 1;
        });

        // Ubah data menjadi koleksi
        $collection = collect($data);

        // Debugging: Log data to check if it's retrieved correctly
        Log::info('Data retrieved:', $collection->toArray());

        return $collection;
    }

    public function headings(): array
    {
        return [
            [
                'Tabel : Kerjasama Penyelenggaraan KSA dan KPA',

            ],
            [],
            [
                'Tahun : ' . $this->year,
            ],
            [
                'Periode (Semester) : Semester ' . $this->semester,
            ],
            [
                '',
                'No.',
                'Satuan Kerja (Satker ID)',
                'Mitra Kerjasama',
                'Tipe Kerjasama',
                'Jenis Kerjasama',
                'Judul Kerjasama',
                'Ruang Lingkup Kerjasama',
                'Nomor MoU/PKS',
                'Tanggal MoU/PKS',
                'Persetujuan Kerja Sama',
                'Tanggal Awal Berlaku',
                'Tanggal Akhir Berlaku',
                'Lokasi Kerja Sama (Kawasan Konservasi)',
                'Lokasi Kerja Sama (Provinsi)',
                'Luas Areal Kerja Sama',
                'Komitmen Pendanaan',
                'IKP/IKK yang Berkaitan dengan MoU/PKS',
                'Status Kerja Sama',
                'Keterangan',
            ],
        ];
    }
    public function map($row): array
    {
        $tanggal_mou_pks = Carbon::parse($row->tanggal_mou_pks)->translatedFormat('d F Y');
        $tanggal_awal_berlaku = Carbon::parse($row->tanggal_awal_berlaku)->translatedFormat('d F Y');
        $tanggal_akhir_berlaku = Carbon::parse($row->tanggal_akhir_berlaku)->translatedFormat('d F Y');

        return [

            '',
            $row->nomor_urut,
            $row->satker_id,
            $row->mitra_kerja,
            $row->tipe_mitra,
            $row->jenis_kerja_sama,
            $row->judul_kerja_sama,
            $row->ruang_lingkup_kerja_sama,
            $row->no_mou_pks,
            $tanggal_mou_pks,
            $row->persetujuan_kerja_sama,
            $tanggal_awal_berlaku,
            $tanggal_akhir_berlaku,
            $row->lokasi_kerja_konservasi,
            $row->lokasi_kerja_provinsi,
            $row->luas_areal_kerja_sama,
            $row->komitmen_pendanaan,
            $row->ikp_ikk_berkaitan,
            $row->status_kerja_sama,
            $row->keterangan,
        ];
    }

    protected function limitTextLength($text, $maxLength)
    {
        // Periksa panjang teks
        if (strlen($text) > $maxLength) {
            // Potong teks jika panjangnya lebih dari batasan
            $text = substr($text, 0, $maxLength);
        }

        return $text;
    }


    public function styles(Worksheet $sheet)
    {
        // Define column widths based on your desired sizes
        $columnWidths = [
            'A' => 5,
            'B' => 5,
            'C' => 30,
            'D' => 30,
            'E' => 30,
            'F' => 30,
            'G' => 30,
            'H' => 30,
            'I' => 30,
            'J' => 30,
            'K' => 30,
            'L' => 30,
            'M' => 30,
            'N' => 30,
            'O' => 30,
            'P' => 30,
            'Q' => 30,
            'R' => 30,
            'S' => 30,
            'T' => 30,
        ];

        // Set column widths according to the defined values
        foreach ($columnWidths as $column => $width) {
            $sheet->getColumnDimension($column)->setWidth($width);
        }

        // Define styles for each row
        $styles = [
            1 => [
                'font' => ['bold' => true, 'size' => 14],
                'alignment' => ['horizontal' => 'left', 'vertical' => 'center'],
            ],
            3 => [
                'font' => ['size' => 12],
                'alignment' => ['horizontal' => 'left', 'vertical' => 'center'],
            ],
            4 => [
                'font' => ['size' => 12],
                'alignment' => ['horizontal' => 'left', 'vertical' => 'center'],
            ],
            5 => [
                'font' => ['bold' => true, 'size' => 12],
                'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
                'borders' => [
                    'bottom' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    ],
                    'top' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    ],
                    'left' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    ],
                    'right' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
                    ],
                ],
            ],
            // 6 => [
            //     'font' => ['bold' => true, 'size' => 12],
            //     'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
            //     'borders' => [
            //         'bottom' => [
            //             'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
            //         ],
            //         'top' => [
            //             'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
            //         ],
            //         'left' => [
            //             'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
            //         ],
            //         'right' => [
            //             'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK,
            //         ],
            //     ],
            // ],
        ];

        // Apply the defined styles to the cells
        foreach ($styles as $row => $style) {
            // Adjusted to columns B to S (from B to the last column)
            $sheet->getStyle('B' . $row . ':T' . $row)->applyFromArray($style);
        }

        // Get the highest row number with data in column B
        $highestRow = $sheet->getHighestDataRow('B');

        // Apply center alignment to all rows from B7 to the highest row in column S
        $sheet->getStyle('B6:T' . $highestRow)->getAlignment()->setHorizontal('center');
        $sheet->getStyle('B6:T' . $highestRow)->getAlignment()->setVertical('center');

        // Return the styles (if needed)
        return $styles;
    }
}
