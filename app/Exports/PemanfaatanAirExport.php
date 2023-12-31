<?php

namespace App\Exports;

use App\Models\PemanfaatanAir1;
use App\Models\PemanfaatanAir2;
use App\Models\PemanfaatanAir3;
use App\Models\PemanfaatanAir4;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PemanfaatanAirExport implements FromCollection, WithHeadings, WithStyles, WithMapping
{
    use Exportable;
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
            1 => PemanfaatanAir1::class,
            2 => PemanfaatanAir2::class,
            3 => PemanfaatanAir3::class,
            4 => PemanfaatanAir4::class,
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
                'Tabel : Pemanfaatan Massa Air di Kawasan Konservasi',

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
                'Nama Sumber Air',
                '',
                'Izin Pemanfaatan Massa Air',
                '',
                'Pemegang Izin',
                '',
                'Pemanfaatan Air',
                '',
                'Debit yang dimanfaatkan (M3/Detik)',
                'Jumlah Tenaga Kerja (Orang)',
                'Nilai Investasi
                (Rp)',
                'Keterangan',
            ],
            [
                '',
                '',
                '',
                '',
                'Jenis Izin',
                'Nomor',
                'Tanggal',
                'Nama',
                'Alamat Desa (ID Desa)',
                'Jumlah yang dilayani (KK)',
                'Lokasi Desa (ID Desa)',
                '',
                '',
                '',
                '',
            ],
        ];
    }


    public function map($row): array
    {
        $formattedDate = $this->formatTanggal($row->tanggal_izin);
        $kabupaten = optional($row->desa->kecamatan->kabupaten)->nama ?? '';
        $kecamatan = optional($row->desa->kecamatan)->nama ?? '';
        $desa = optional($row->desa)->nama ?? '';
        $location = 'Kabupaten' . $kabupaten . ', ' . 'Kecamatan' . $kecamatan . ', ' . 'Desa' . $desa;
        $this->currentIndex++;
        return [
            '',
            $this->currentIndex,
            $row->no_register_kawasan,
            $row->nama_sumber_air,
            $row->jenis_izin,
            $row->nomor_izin,
            $formattedDate,
            $row->nama,
            $location, // Concatenated location field
            $row->jumlah_dilayani_kk,
            $location,
            $row->debit,
            $row->jumlah_tenaga_kerja,
            $row->nilai_investasi,
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
            $sheet->getStyle('B' . $row . ':O' . $row)->applyFromArray($style);
        }

        // Get the highest row number with data in column B
        $highestRow = $sheet->getHighestDataRow('B');

        // Apply center alignment to all rows from B7 to the highest row in column S
        $sheet->getStyle('B7:O' . $highestRow)->getAlignment()->setHorizontal('center');
        $sheet->getStyle('B7:O' . $highestRow)->getAlignment()->setVertical('center');

        // Return the styles (if needed)
        return $styles;
    }
}
