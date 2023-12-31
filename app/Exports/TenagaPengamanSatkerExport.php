<?php

namespace App\Exports;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use App\Models\TenagaPengamananHutanPerSatuanKerja1;
use App\Models\TenagaPengamananHutanPerSatuanKerja2;
use App\Models\TenagaPengamananHutanPerSatuanKerja3;
use App\Models\TenagaPengamananHutanPerSatuanKerja4;

class TenagaPengamanSatkerExport implements FromCollection, WithHeadings, WithStyles, WithMapping
{
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
            1 => TenagaPengamananHutanPerSatuanKerja1::class,
            2 => TenagaPengamananHutanPerSatuanKerja2::class,
            3 => TenagaPengamananHutanPerSatuanKerja3::class,
            4 => TenagaPengamananHutanPerSatuanKerja4::class,
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
                'Tabel : Tenaga Pengamanan Hutan Per Satuan Kerja',

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
                'Satuan Kerja (Satker ID)',
                '',
                '',
                'Tenaga Pengamanan Hutan',
                '',
                'Keterangan',
            ],
            [
                '',
                '',
                '',
                'Polhut (Orang)',
                'PPNS (Orang)',
                'TPHL (Orang)',
                'MMP (Orang)',
                '',
            ],
        ];
    }


    public function map($row): array
    {
        $this->currentIndex++;
        return [
            '',
            $this->currentIndex,
            $row->satker_id,
            $row->polhut,
            $row->ppns,
            $row->tphl,
            $row->mmp,
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
            'D' => 20,  // Anggota (Orang)
            'E' => 20,  // Jenis Kegiatan
            'F' => 20,  // Jumlah Dana (Rp)
            'G' => 20,  // Sumber Dana
            'H' => 20,  // Hasil dan Manfaat
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
        ];


        // Apply the defined styles to the cells
        foreach ($styles as $row => $style) {
            // Adjusted to columns B to J
            $sheet->getStyle('B' . $row . ':H' . $row)->applyFromArray($style);
        }

        // Get the highest row number with data in column B
        $highestRow = $sheet->getHighestDataRow('B');

        // Apply center alignment to all rows from B7 to the highest row in column H
        $sheet->getStyle('B7:H' . $highestRow)->getAlignment()->setHorizontal('center');
        $sheet->getStyle('B7:H' . $highestRow)->getAlignment()->setVertical('center');
        return $styles;
    }
}
