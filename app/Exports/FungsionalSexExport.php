<?php

namespace App\Exports;

use App\Models\fungsional_sex1;
use App\Models\fungsional_sex2;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class FungsionalSexExport implements FromCollection, WithHeadings, WithStyles, WithMapping
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
            1 => fungsional_sex1::class,
            2 => fungsional_sex2::class,
        ];

        return $modelMapping[$semester] ?? null;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
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
                'Tabel : Sebaran Pejabat Fungsional Tertentu Menurut Fungsi dan Jenis Kelamin',

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
                'Jenis Jabatan Fungsional Tertentu',
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
                'PEH',
                '',
                'Polhut',
                '',
                'Penyuluh',
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
        $this->currentIndex++;
        return [
            '',
            $this->currentIndex,
            $row->satker_id,
            $row->laki_peh, // Sesuaikan dengan nama kolom yang sesuai dengan data yang akan diekspor
            $row->perempuan_peh, // Sesuaikan dengan nama kolom yang sesuai dengan data yang akan diekspor
            $row->laki_polhut, // Sesuaikan dengan nama kolom yang sesuai dengan data yang akan diekspor
            $row->perempuan_polhut,
            $row->laki_penyuluh,
            $row->perempuan_penyuluh,
            $row->laki_pranata,
            $row->perempuan_pranata,
            $row->laki_statistisi,
            $row->perempuan_statistisi,
            $row->laki_analis,
            $row->perempuan_analis,
            $row->laki_arsiparis,
            $row->perempuan_arsiparis,
            $row->laki_perencana,
            $row->perempuan_perencana,
            $row->laki_pengadaan,
            $row->perempuan_pengadaan,
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
            // Adjusted to columns B to U (from B to the last column)
            $sheet->getStyle('B' . $row . ':Y' . $row)->applyFromArray($style);
        }

        // Get the highest row number with data in column B
        $highestRow = $sheet->getHighestDataRow('B');

        // Apply center alignment to all rows from B7 to the highest row in column U
        $sheet->getStyle('B7:Y' . $highestRow)->getAlignment()->setHorizontal('center');
        $sheet->getStyle('B7:Y' . $highestRow)->getAlignment()->setVertical('center');

        // Return the styles (if needed)
        return $styles;
    }
}
