<?php

namespace App\Exports;

use App\Models\fungsional1;
use App\Models\fungsional2;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
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
            1 => fungsional1::class,
            2 => fungsional2::class,
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
                'Jumlah (Orang)',
                'Keterangan',

            ],
            [
                '',
                '',
                '',
                '',
                '',
                'PEH',
                '',
                '',
                '',
                '',
                'Polisi Kehutanan',
                '',
                '',
                '',
                '',
                'Penyuluh Kehutanan',
                '',
                '',
                '',
                '',
                'Pranata Komputer',
                '',
                '',
                '',
                '',
                'Statistisi',
                '',
                '',
                '',
                '',
                'Analis Kepegawaian',
                '',
                '',
                '',
                '',
                'Arsiparis',
                '',
                '',
                '',
                '',
                'Perencana',
                '',
                '',
                '',
                '',
                'Pengadaan Barjas',
                '',
                '',
                '',
                '',
            ],
            [
                '',
                '',
                '',
                'Calon Terampil PEH',
                'Terampil PEH',
                'Calon Ahli PEH',
                'Ahli PEH',
                'Jumlah PEH',
                'Calon Terampil Polhut',
                'Terampil Polhut',
                'Calon Ahli Polhut',
                'Ahli Polhut',
                'Jumlah Polhut',
                'Calon Terampil Penyuluh',
                'Terampil Penyuluh',
                'Calon Ahli Penyuluh',
                'Ahli Penyuluh',
                'Jumlah Penyuluh',
                'Calon Terampil Pranata Komputer',
                'Terampil Pranata Komputer',
                'Calon Ahli Pranata Komputer',
                'Ahli Pranata Komputer',
                'Jumlah Pranata Komputer',
                'Calon Terampil Statistisi',
                'Terampil Statistisi',
                'Calon Ahli Statistisi',
                'Ahli Statistisi',
                'Jumlah Statistisi',
                'Calon Terampil Analis Kepegawaian',
                'Terampil Analis Kepegawaian',
                'Calon Ahli Analis Kepegawaian',
                'Ahli Analis Kepegawaian',
                'Jumlah Analis Kepegawaian',
                'Calon Terampil Arsiparis',
                'Terampil Arsiparis',
                'Calon Ahli Arsiparis',
                'Ahli Arsiparis',
                'Jumlah Arsiparis',
                'Calon Terampil Perencana',
                'Terampil Perencana',
                'Calon Ahli Perencana',
                'Ahli Perencana',
                'Jumlah Perencana',
                'Calon Terampil Pengadaan',
                'Terampil Pengadaan',
                'Calon Ahli Pengadaan',
                'Ahli Pengadaan',
                'Jumlah Pengadaan',
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
            $row->calon_terampil_peh,
            $row->terampil_peh,
            $row->calon_ahli_peh,
            $row->ahli_peh,
            $row->jumlah_peh,
            $row->calon_terampil_polhut,
            $row->terampil_polhut,
            $row->calon_ahli_polhut,
            $row->ahli_polhut,
            $row->jumlah_polhut,
            $row->calon_terampil_penyuluh,
            $row->terampil_penyuluh,
            $row->calon_ahli_penyuluh,
            $row->ahli_penyuluh,
            $row->jumlah_penyuluh,
            $row->calon_terampil_pranata,
            $row->terampil_pranata,
            $row->calon_ahli_pranata,
            $row->ahli_pranata,
            $row->jumlah_pranata,
            $row->calon_terampil_statis,
            $row->terampil_statis,
            $row->calon_ahli_statis,
            $row->ahli_statis,
            $row->jumlah_statis,
            $row->calon_terampil_analisis,
            $row->terampil_analisis,
            $row->calon_ahli_analisis,
            $row->ahli_analisis,
            $row->jumlah_analisis,
            $row->calon_terampil_arsiparis,
            $row->terampil_arsiparis,
            $row->calon_ahli_arsiparis,
            $row->ahli_arsiparis,
            $row->jumlah_arsiparis,
            $row->calon_terampil_perencana,
            $row->terampil_perencana,
            $row->calon_ahli_perencana,
            $row->ahli_perencana,
            $row->jumlah_perencana,
            $row->calon_terampil_pengadaan,
            $row->terampil_pengadaan,
            $row->calon_ahli_pengadaan,
            $row->ahli_pengadaan,
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
            'X' => 30,
            'Y' => 30,
            'Z' => 30,
            'AA' => 5,
            'AB' => 5,
            'AC' => 15,
            'AD' => 30,
            'AE' => 30,
            'AF' => 30,
            'AG' => 30,
            'AH' => 30,
            'AI' => 30,
            'AJ' => 30,
            'AK' => 30,
            'AL' => 30,
            'AM' => 30,
            'AN' => 30,
            'AO' => 30,
            'AP' => 30,
            'AQ' => 30,
            'AR' => 30,
            'AS' => 30,
            'AT' => 30,
            'AU' => 30,
            'AV' => 30,
            'AW' => 30,
            'AX' => 30,
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
            $sheet->getStyle('B' . $row . ':AX' . $row)->applyFromArray($style);
        }

        // Get the highest row number with data in column B
        $highestRow = $sheet->getHighestDataRow('B');

        // Apply center alignment to all rows from B7 to the highest row in column S
        $sheet->getStyle('B6:AX' . $highestRow)->getAlignment()->setHorizontal('center');
        $sheet->getStyle('B6:AX' . $highestRow)->getAlignment()->setVertical('center');

        // Return the styles (if needed)
        return $styles;
    }
}
