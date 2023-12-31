<?php

namespace App\Exports;

use App\Models\fungsional1;
use App\Models\fungsional2;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class FungsionalExport implements FromCollection, WithHeadings, WithStyles, WithMapping
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
            1 => fungsional1::class,
            2 => fungsional2::class,
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
                'Tabel :  Sebaran Pejabat Fungsional Tertentu Menurut Fungsi dan Jenjang Jabatan',

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
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                'Jenis dan Jenjang Jabatan Fungsional Tertentu',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                'Jumlah (Orang)',
                'Keterangan',

            ],
            [
                '',
                '',
                '',
                'PEH',
                '',
                'Polisi Kehutanan',
                '',
                'Penyuluh Kehutanan',
                '',
                'Pranata Komputer',
                '',
                'Statistisi',
                '',
                'Analis Kepegawaian',
                '',
                'Arsiparis',
                '',
                'Perencana',
                '',
                'Pengadaan Barjas',
                '',
                '',
                '',
            ],
            [
                '',
                '',
                '',
                'Jenjang Jabatan',
                'Jumlah (Orang)',
                'Jenjang Jabatan',
                'Jumlah (Orang)',
                'Jenjang Jabatan',
                'Jumlah (Orang)',
                'Jenjang Jabatan',
                'Jumlah (Orang)',
                'Jenjang Jabatan',
                'Jumlah (Orang)',
                'Jenjang Jabatan',
                'Jumlah (Orang)',
                'Jenjang Jabatan',
                'Jumlah (Orang)',
                'Jenjang Jabatan',
                'Jumlah (Orang)',
                'Jenjang Jabatan',
                'Jumlah (Orang)',
                '',
                '',
            ],
        ];
    }

    public function map($row): array
    {

        return [
            '',
            $row->nomor_urut,
            $row->satker_id,
            $row->peh, // Sesuaikan dengan nama kolom yang sesuai dengan data yang akan diekspor
            $row->jumlah_peh, // Sesuaikan dengan nama kolom yang sesuai dengan data yang akan diekspor
            $row->polhut, // Sesuaikan dengan nama kolom yang sesuai dengan data yang akan diekspor
            $row->jumlah_polhut,
            $row->penyuluh,
            $row->jumlah_penyuluh,
            $row->pranata,
            $row->jumlah_pranata,
            $row->statis,
            $row->jumlah_statis,
            $row->analisis,
            $row->jumlah_analisis,
            $row->arsiparis,
            $row->jumlah_arsiparis,
            $row->perencanana,
            $row->jumlah_perencanana,
            $row->pengadaan,
            $row->jumlah_pengadaan,
            $row->total,
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
            'C' => 15,
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
            'U' => 30,
            'V' => 30,
            'W' => 30,
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
            6 => [
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
            7 => [
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
        ];

        // Apply the defined styles to the cells
        foreach ($styles as $row => $style) {
            // Adjusted to columns B to S (from B to the last column)
            $sheet->getStyle('B' . $row . ':W' . $row)->applyFromArray($style);
        }

        // Get the highest row number with data in column B
        $highestRow = $sheet->getHighestDataRow('B');

        // Apply center alignment to all rows from B7 to the highest row in column S
        $sheet->getStyle('B6:W' . $highestRow)->getAlignment()->setHorizontal('center');
        $sheet->getStyle('B6:W' . $highestRow)->getAlignment()->setVertical('center');

        // Return the styles (if needed)
        return $styles;
    }
}
