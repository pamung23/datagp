<?php

namespace App\Exports;

use App\Models\Ekosistem1;
use App\Models\Ekosistem2;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EkosistemExport implements FromCollection, WithHeadings, WithStyles, WithMapping
{
    use Exportable;

    protected $triwulan;
    protected $year;

    public function __construct($triwulan, $year)
    {
        $this->triwulan = $triwulan;
        $this->year = $year;
    }

    protected function getModelForTriwulan($triwulan)
    {
        // Buat peta pemetaan model untuk triwulan tertentu
        $modelMapping = [
            1 => Ekosistem1::class,
            2 => Ekosistem2::class,
        ];

        return $modelMapping[$triwulan] ?? null;
    }

    public function collection()
    {
        // Ambil nama kelas model yang sesuai berdasarkan triwulan
        $modelClass = $this->getModelForTriwulan($this->triwulan);

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
                'Tabel : Potensi Pemanfaatan Karbon di Kawasan Konservasi',

            ],
            [],
            [
                'Tahun : ' . $this->year,
            ],
            [
                'Periode (Triwulan) : Triwulan ' . $this->triwulan,
            ],
            [
                '',
                'No.',
                'Register Kawasan Konservasi',
                'Ekosistem Kawasan Konservasi',
                '',
                'Keterangan',
            ],
            [
                '',
                '',
                '',
                'Tipe Ekosistem',
                'Luas (Ha)',
            ],
        ];
    }

    public function map($row): array
    {
        $tipeValues = '';
        $luasValues = '';

        // Proses tipe dan luas agar setiap nilai turun ke baris baru
        foreach ($row->tipe as $index => $tipe) {
            $nomorUrut = $index + 1; // Nomor urut untuk setiap nilai
            $tipeValues .= "$nomorUrut. $tipe\n"; // Menambahkan nomor urut ke nilai tipe
        }

        foreach ($row->luas as $index => $luas) {
            $luasValues .= "$luas\n"; // Setiap nilai luas turun ke baris baru
        }

        return [
            '',
            $row->nomor_urut,
            $row->no_register_kawasan,
            $tipeValues,
            $luasValues,
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
            $sheet->getStyle('B' . $row . ':F' . $row)->applyFromArray($style);
        }

        // Get the highest row number with data in column B
        $highestRow = $sheet->getHighestDataRow('B');

        // Apply center alignment to all rows from B7 to the highest row in column S
        $sheet->getStyle('B6:F' . $highestRow)->getAlignment()->setHorizontal('center');
        $sheet->getStyle('B6:F' . $highestRow)->getAlignment()->setVertical('center');

        // Return the styles (if needed)
        return $styles;
    }
}
