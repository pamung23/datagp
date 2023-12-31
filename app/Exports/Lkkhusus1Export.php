<?php

namespace App\Exports;

use App\Models\Lkkhusus1;
use App\Models\lkkhusus2;
use App\Models\lkkhusus3;
use App\Models\lkkhusus4;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class Lkkhusus1Export implements FromCollection, WithHeadings, WithStyles, WithMapping
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
            1 => Lkkhusus1::class,
            2 => Lkkhusus2::class,
            3 => Lkkhusus3::class,
            4 => Lkkhusus4::class,
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
                'Tabel : Lembaga Konservasi Khusus',

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
                'Bentuk Lembaga Konservasi',
                'Nama Lembaga Konservasi',
                'Alamat Lembaga Konservasi',
                'Provinsi',
                '',
                'Lokasi Geografis

                (Desimal degree)',
                'Luas Areal (Ha)',
                '',
                'Izin Lembaga Konservasi',
                '',
                'Koleksi pada Lembaga Konservasi',
                '',
                'Jumlah Koleksi (individu)',
                '',
                '',
                'Keterangan',
            ],
            [
                '',
                '',
                '',
                '',
                '',
                '',
                '',
                'Latitude (Y)',
                'Longitude (X)',
                '',
                'Nomor',
                'Tanggal',
                'Masa Berlaku (Tahun)',
                'Nama Ilmiah',
                'Jantan',
                'Betina',
                'Belum diketahui',
                'Jumlah',
                '',
                '',
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
            $row->bentuk_lk, // Sesuaikan dengan nama kolom yang sesuai dengan data yang akan diekspor
            $row->nama_lk, // Sesuaikan dengan nama kolom yang sesuai dengan data yang akan diekspor
            $row->alamat_lk,
            $row->provinsi, // Sesuaikan dengan nama kolom yang sesuai dengan data yang akan diekspor
            $row->latitude,
            $row->longitude,
            $row->luas_areal_hektar,
            $row->nomor,
            $row->tanggal,
            $row->masa_berlaku_tahun,
            $row->nama_ilmiah,
            $row->jantan,
            $row->betina,
            $row->belum_diketahui,
            $row->jumlah,
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
            'N' => 40,
            'O' => 25,
            'P' => 25,
            'Q' => 25,
            'R' => 25,
            'S' => 25, // Kolom S seharusnya huruf besar 'S', bukan 's'
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
            // Adjusted to columns B to S (from B to the last column)
            $sheet->getStyle('B' . $row . ':S' . $row)->applyFromArray($style);
        }

        // Get the highest row number with data in column B
        $highestRow = $sheet->getHighestDataRow('B');

        // Apply center alignment to all rows from B7 to the highest row in column S
        $sheet->getStyle('B7:S' . $highestRow)->getAlignment()->setHorizontal('center');
        $sheet->getStyle('B7:S' . $highestRow)->getAlignment()->setVertical('center');

        // Return the styles (if needed)
        return $styles;
    }
}
