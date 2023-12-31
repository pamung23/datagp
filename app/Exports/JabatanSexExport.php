<?php

namespace App\Exports;

use App\Models\jabatan_sex1;
use App\Models\jabatan_sex2;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class JabatanSexExport implements FromCollection, WithHeadings, WithStyles, WithMapping
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
            1 => jabatan_sex1::class,
            2 => jabatan_sex2::class,
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
                'Tabel : Sebaran PNS/CPNS Menurut Jabatan dan Jenis Kelamin',

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
                'Jenis Jabatan',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                'Jumlah',
                '',
                'Keterangan',
                '',
                '',

            ],
            [
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                'Struktural',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                'Fungsional Umum',
                '',
                'Fungsional Tertentu',
                '',
                '',
                '',

            ],
            [
                '',
                '',
                '',
                'I-A',
                '',
                'I-B',
                '',
                'II-A',
                '',
                'II-B',
                '',
                'III-A',
                '',
                'III-B',
                '',
                'III-C',
                '',
                'III-D',
                '',
                'IV-A',
                '',
                'IV-B',
                '',
                '',
                '',
                '',
                '',
                '',
                '',
            ],
            [
                '',
                '',
                '',
                'L (Orang)',
                'P (Orang)',
                'L (Orang)',
                'P (Orang)',
                'L (Orang)',
                'P (Orang)',
                'L (Orang)',
                'P (Orang)',
                'L (Orang)',
                'P (Orang)',
                'L (Orang)',
                'P (Orang)',
                'L (Orang)',
                'P (Orang)',
                'L (Orang)',
                'P (Orang)',
                'L (Orang)',
                'P (Orang)',
                'L (Orang)',
                'P (Orang)',
                'L (Orang)',
                'P (Orang)',
                'L (Orang)',
                'P (Orang)',
                'L (Orang)',
                'P (Orang)',
                'Total',
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
            $row->laki_ia, // Sesuaikan dengan nama kolom yang sesuai dengan data yang akan diekspor
            $row->perempuan_ia, // Sesuaikan dengan nama kolom yang sesuai dengan data yang akan diekspor
            $row->laki_ib, // Sesuaikan dengan nama kolom yang sesuai dengan data yang akan diekspor
            $row->perempuan_ib,
            $row->laki_iia,
            $row->perempuan_iia,
            $row->laki_iib,
            $row->perempuan_iib,
            $row->laki_iiia,
            $row->perempuan_iiia,
            $row->laki_iiib,
            $row->perempuan_iiib,
            $row->laki_iiic,
            $row->perempuan_iiic,
            $row->laki_iiid,
            $row->perempuan_iiid,
            $row->laki_iva,
            $row->perempuan_iva,
            $row->laki_ivb,
            $row->perempuan_ivb,
            $row->laki_umum,
            $row->perempuan_umum,
            $row->laki_tertentu,
            $row->perempuan_tertentu,
            $row->laki_jumlah,
            $row->perempuan_jumlah,
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
            'C' => 30,
            'D' => 30,
            'E' => 30,
            'F' => 30,
            'G' => 30,
            'H' => 20,
            'I' => 20,
            'J' => 25,
            'K' => 25,
            'L' => 25,
            'M' => 25,
            'N' => 25,
            'O' => 25,
            'P' => 25,
            'Q' => 25,
            'R' => 25,
            'S' => 25,
            'T' => 25,
            'U' => 25,
            'V' => 25,
            'W' => 25,
            'X' => 25,
            'Y' => 25,
            'Z' => 25,
            'AA' => 25,
            'AB' => 25,
            'AC' => 25,
            'AD' => 25,
            'AE' => 25,
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
            8 => [
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
            $sheet->getStyle('B' . $row . ':AE' . $row)->applyFromArray($style);
        }

        // Get the highest row number with data in column B
        $highestRow = $sheet->getHighestDataRow('B');

        // Apply center alignment to all rows from B7 to the highest row in column U
        $sheet->getStyle('B7:AE' . $highestRow)->getAlignment()->setHorizontal('center');
        $sheet->getStyle('B7:AE' . $highestRow)->getAlignment()->setVertical('center');

        // Return the styles (if needed)
        return $styles;
    }
}
