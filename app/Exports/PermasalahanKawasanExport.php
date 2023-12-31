<?php

namespace App\Exports;

use Illuminate\Support\Facades\Log;
use App\Models\PermasalahanKawasan1;
use App\Models\PermasalahanKawasan2;
use App\Models\PermasalahanKawasan3;
use App\Models\PermasalahanKawasan4;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;


class PermasalahanKawasanExport implements FromCollection, WithHeadings, WithStyles, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    use Exportable;

    protected $triwulan;
    protected $year;
    private $currentIndex = 0;
    public function __construct($triwulan, $year)
    {
        $this->triwulan = $triwulan;
        $this->year = $year;
    }

    protected function getModelForTriwulan($triwulan)
    {
        $modelMapping = [
            1 => PermasalahanKawasan1::class,
            2 => PermasalahanKawasan2::class,
            3 => PermasalahanKawasan3::class,
            4 => PermasalahanKawasan4::class,
        ];

        return $modelMapping[$triwulan] ?? null;
    }

    public function collection()
    {
        $user = Auth::user();

        if ($this->triwulan === 'all') {
            $data = collect();

            for ($i = 1; $i <= 4; $i++) {
                $modelClass = $this->getModelForTriwulan($i);

                if (!$modelClass) {
                    continue;
                }

                $model = new $modelClass();

                $query = $model->query();

                if ($this->year) {
                    $query->whereYear('created_at', $this->year);
                }

                // Filter berdasarkan resort pengguna untuk level 'Wilayah'
                if (in_array($user->level, ['Wilayah Cianjur', 'Wilayah Sukabumi', 'Wilayah Bogor'])) {
                    $query->whereHas('user.resort', function ($subquery) use ($user) {
                        $subquery->where('id', $user->resort_id);
                    });
                }

                $triwulanData = $query->get();

                $triwulanData->each(function ($item) use ($i) {
                    $item->triwulan = $i;
                });

                $data = $data->merge($triwulanData);
            }

            return $data;
        } else {
            $modelClass = $this->getModelForTriwulan($this->triwulan);

            if (!$modelClass) {
                return collect();
            }

            $model = new $modelClass();

            $query = $model->query();

            if ($this->year) {
                $query->whereYear('created_at', $this->year);
            }

            // Filter berdasarkan resort pengguna untuk level 'Wilayah'
            if (in_array($user->level, ['Wilayah Cianjur', 'Wilayah Sukabumi', 'Wilayah Bogor'])) {
                $query->whereHas('user.resort', function ($subquery) use ($user) {
                    $subquery->where('id', $user->resort_id);
                });
            }

            $triwulanData = $query->get();

            $triwulanData->each(function ($item) {
                $item->triwulan = $this->triwulan;
            });

            return $triwulanData;
        }
    }
    public function headings(): array
    {
        return [
            [
                'Tabel : Permasalahan Kawasan Konservasi',

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
                'Jenis Permasalahan',
                'Uraian Permasalahan',
                'Progres Penyelesaian',
                'Keterangan',
            ],
        ];
    }


    public function map($row): array
    {
        $this->currentIndex++;
        return [
            '',
            $this->currentIndex,
            $row->no_register_kawasan,
            $row->jenis_permasalahan,
            $row->uraian_permasalahan,
            $row->progres_penyelesaian,
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
            'A' => 5,   // No. Urut
            'B' => 5,  // Register Kawasan Konservasi
            'C' => 30,  // Nama Kelompok
            'D' => 30,  // Anggota (Orang)
            'E' => 30,  // Jenis Kegiatan
            'F' => 30,  // Jumlah Dana (Rp)
            'G' => 30,  // Sumber Dana

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

        $startRow = 6;

        // Tentukan berapa banyak baris yang ingin memiliki pembungkus teks
        $numRows = 6; // Ini akan mencakup baris 6 hingga 11

        // Buat array untuk menyimpan baris yang memerlukan pembungkus teks
        $rowsWithWrappedText = [];

        // Isi array dengan rentang baris yang diinginkan
        for ($i = $startRow; $i < $startRow + $numRows; $i++) {
            $rowsWithWrappedText[] = $i;
        }

        // Loop melalui baris-baris yang memerlukan pembungkus teks
        foreach ($rowsWithWrappedText as $rowNumber) {
            $sheet->getStyle('B' . $rowNumber . ':G' . $rowNumber)->getAlignment()->setWrapText(true);
        }


        // Apply the defined styles to the cells
        foreach ($styles as $row => $style) {
            // Adjusted to columns B to J
            $sheet->getStyle('B' . $row . ':G' . $row)->applyFromArray($style);
        }

        // Get the highest row number with data in column B
        $highestRow = $sheet->getHighestDataRow('B');

        // Apply center alignment to all rows from B7 to the highest row in column G
        $sheet->getStyle('B6:G' . $highestRow)->getAlignment()->setHorizontal('center');
        $sheet->getStyle('B6:G' . $highestRow)->getAlignment()->setVertical('center');
        return $styles;
    }
}
