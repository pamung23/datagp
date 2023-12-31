<?php

namespace App\Exports;

use App\Models\kawasan_konservasi1;
use App\Models\kawasan_konservasi2;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class KawasanKonservasiExport implements FromCollection, WithHeadings, WithStyles, WithMapping
{
    use Exportable;

    protected $semester;
    protected $year;
    private $currentIndex = 0;
    public function __construct($semester, $year)
    {
        $this->semester = $semester;
        $this->year = $year;
    }

    protected function getModelForSemester($semester)
    {
        // Buat peta pemetaan model untuk semester$semester tertentu
        $modelMapping = [
            1 => kawasan_konservasi1::class,
            2 => kawasan_konservasi2::class,
        ];

        return $modelMapping[$semester] ?? null;
    }

    public function collection()
    {
        $user = Auth::user();

        if ($this->semester === 'all') {
            $data = collect();

            for ($i = 1; $i <= 4; $i++) {
                $modelClass = $this->getModelForSemester($i);

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

                $semesterData = $query->get();

                $semesterData->each(function ($item) use ($i) {
                    $item->semester = $i;
                });

                $data = $data->merge($semesterData);
            }

            return $data;
        } else {
            $modelClass = $this->getModelForSemester($this->semester);

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

            $semesterData = $query->get();

            $semesterData->each(function ($item) {
                $item->semester = $this->semester;
            });

            return $semesterData;
        }
    }

    public function headings(): array
    {
        return [
            [
                'Tabel : Kawasan Konservasi yang Mendapat Penetapan Status Internasional sebagai Cagar Biosfer',

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
                'Nama Cagar Biosfer',
                'Tahun Penetapan',
                '',
                'Kawasan Konservasi di Dalam Cagar Biosfer',
                '',
                'Keterangan',

            ],
            [
                '',
                '',
                '',
                '',
                '',
                'Area Inti',
                'Zona Penyangga',
                'Area Transisi',
                '',

            ],
            [
                '',
                '',
                '',
                '',
                '',
                'Register Kawasan Konservasi',
                'Register Kawasan Konservasi',
                'Register Kawasan Konservasi',
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
            $row->nama_cagar_biosfer, // Sesuaikan dengan nama kolom yang sesuai dengan data yang akan diekspor
            $row->tahun_penetapan, // Sesuaikan dengan nama kolom yang sesuai dengan data yang akan diekspor
            $row->area_inti, // Sesuaikan dengan nama kolom yang sesuai dengan data yang akan diekspor
            $row->zona_penyangga,
            $row->zona_penyangga,
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
            'C' => 25,
            'D' => 25,
            'E' => 25,
            'F' => 30,
            'G' => 30,
            'H' => 30,
            'I' => 25,
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
            ],     7 => [
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
            // Adjusted to columns B to I (from B to the last column)
            $sheet->getStyle('B' . $row . ':E' . $row . ':F' . $row . ':H' .  $row . ':I' . $row)->applyFromArray($style);
        }

        // Get the highest row number with data in column B
        $highestRow = $sheet->getHighestDataRow('B');

        // Apply center alignment to all rows from B7 to the highest row in column S
        $sheet->getStyle('B7:I' . $highestRow)->getAlignment()->setHorizontal('center');
        $sheet->getStyle('B7:I' . $highestRow)->getAlignment()->setVertical('center');
        $sheet->getStyle('B6:I' . $highestRow)->getAlignment()->setVertical('center');

        // Return the styles (if needed)
        return $styles;
    }
}
