<?php

namespace App\Exports;

use App\Models\Zonasi1;
use App\Models\Zonasi2;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ZonasiExport implements FromCollection, WithHeadings, WithStyles, WithMapping
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

    protected function getModelForsemester($semester)
    {
        // Buat peta pemetaan model untuk semester tertentu
        $modelMapping = [
            1 => Zonasi1::class,
            2 => Zonasi2::class,
        ];

        return $modelMapping[$semester] ?? null;
    }

    protected function formatTanggal($date)
    {
        // Array nama-nama bulan dalam bahasa Indonesia
        $bulan = [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
            '06' => 'Juni',
            '07' => 'Juli',
            '08' => 'Agustus',
            '09' => 'September',
            '10' => 'Oktober',
            '11' => 'November',
            '12' => 'Desember'
        ];
        // Pisahkan tanggal, bulan, dan tahun
        $parts = explode('-', $date);
        $tahun = $parts[0];
        $bulanIndonesia = $bulan[$parts[1]];
        $tanggal = $parts[2];

        // Gabungkan dalam format Indonesia
        return $tanggal . ' ' . $bulanIndonesia . ' ' . $tahun;
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
                'Tabel : Potensi Pemanfaatan Karbon di Kawasan Konservasi',

            ],
            [],
            [
                'Tahun : ' . $this->year,
            ],
            [
                'Periode (semester) : semester ' . $this->semester,
            ],
            [
                '',
                'No.',
                'Register Kawasan Konservasi',
                'SK Penetapan Zonasi/Blok',
                '',
                '',
                '',
                '',
                '',
                '',
                'Zonasi/Blok (Ha)',
                '',
                '',
                '',
                '',
                '',
                '',
                'Keterangan',
            ],
            [
                '',
                '',
                '',
                'Nomor',
                'Tanggal',
                'Inti',
                'Rimba',
                'Pemanfaatan',
                'Perlindungan',
                'Perlindungan Bahari',
                'Rehabilitasi',
                'Tradisional',
                'Religi, Budaya dan Sejarah',
                'Khusus',
                'Koleksi Tumbuhan/Satwa',
                'Lainnya',
                'Total Luas (Ha)',
                '',
            ],
        ];
    }

    public function map($row): array
    {
        $tanggal = $this->formatTanggal($row->tanggal);
        $this->currentIndex++;
        return [
            '',
            $this->currentIndex,
            $row->no_register_kawasan,
            $row->nomor,
            $tanggal,
            $row->inti != 0 ? number_format($row->inti, 2, ',', '.') : '0',
            $row->rimba != 0 ? number_format($row->rimba, 2, ',', '.') : '0',
            $row->pemanfaatan != 0 ? number_format($row->pemanfaatan, 2, ',', '.') : '0',
            $row->perlindungan != 0 ? number_format($row->perlindungan, 2, ',', '.') : '0',
            $row->perlindungan_bahari != 0 ? number_format($row->perlindungan_bahari, 2, ',', '.') : '0',
            $row->rehabilitasi != 0 ? number_format($row->rehabilitasi, 2, ',', '.') : '0',
            $row->tradisional != 0 ? number_format($row->tradisional, 2, ',', '.') : '0',
            $row->religi != 0 ? number_format($row->religi, 2, ',', '.') : '0',
            $row->khusus != 0 ? number_format($row->khusus, 2, ',', '.') : '0',
            $row->koleksi != 0 ? number_format($row->koleksi, 2, ',', '.') : '0',
            $row->lainnya != 0 ? number_format($row->lainnya, 2, ',', '.') : '0',
            $row->total != 0 ? number_format($row->total, 2, ',', '.') : '0',
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
            $sheet->getStyle('B' . $row . ':R' . $row)->applyFromArray($style);
        }

        // Get the highest row number with data in column B
        $highestRow = $sheet->getHighestDataRow('B');

        // Apply center alignment to all rows from B7 to the highest row in column S
        $sheet->getStyle('B6:R' . $highestRow)->getAlignment()->setHorizontal('center');
        $sheet->getStyle('B6:R' . $highestRow)->getAlignment()->setVertical('center');

        // Return the styles (if needed)
        return $styles;
    }
}
