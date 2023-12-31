<?php

namespace App\Exports;

use App\Models\penanganan_jenis1;
use App\Models\penanganan_jenis2;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PenangananJenisExport implements FromCollection, WithHeadings, WithStyles, WithMapping
{
    use Exportable;

    protected $semester;
    protected $year;

    public function __construct($semester, $year)
    {
        $this->semester = $semester;
        $this->year = $year;
    }

    protected function getModelForSemester($semester)
    {
        // Buat peta pemetaan model untuk semester$semester tertentu
        $modelMapping = [
            1 => penanganan_jenis1::class,
            2 => penanganan_jenis2::class,
        ];

        return $modelMapping[$semester] ?? null;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Ambil nama kelas model yang sesuai berdasarkan semester
        $modelClass = $this->getModelForSemester($this->semester);

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
                'Tabel : Penanganan Jenis Asing Invasif (IAS) di Kawasan Konservasi',

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
                'Register Kawasan Konservasi',
                'Jenis Invasif',
                'Luas (Ha)',
                'Koordinat Geografis (Decimal Degrees)',
                '',
                'Penanganan yang sudah dilakukan',
                'Rencana Penanganan',
                'Kemitraan yang dilakukan',
                'Keterangan',
                '',
                '',

            ],
            [
                '',
                '',
                '',
                'Nama Ilmiah',
                '',
                'Latitude',
                'Longitude',
                '',
                '',
                '',
                '',
                '',
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
            $row->no_register_kawasan,
            $row->ilmiah, // Sesuaikan dengan nama kolom yang sesuai dengan data yang akan diekspor
            $row->luas, // Sesuaikan dengan nama kolom yang sesuai dengan data yang akan diekspor
            $row->latitude, // Sesuaikan dengan nama kolom yang sesuai dengan data yang akan diekspor
            $row->longitude,
            $row->penanganan,
            $row->rencana,
            $row->kemitraan,
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
            'H' => 20,
            'I' => 20,
            'J' => 25,
            'K' => 25,
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
            // Adjusted to columns B to U (from B to the last column)
            $sheet->getStyle('B' . $row . ':K' . $row)->applyFromArray($style);
        }

        // Get the highest row number with data in column B
        $highestRow = $sheet->getHighestDataRow('B');

        // Apply center alignment to all rows from B7 to the highest row in column U
        $sheet->getStyle('B6:K' . $highestRow)->getAlignment()->setHorizontal('center');
        $sheet->getStyle('B6:K' . $highestRow)->getAlignment()->setVertical('center');

        // Return the styles (if needed)
        return $styles;
    }
}
