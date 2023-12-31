<?php

namespace App\Exports;

use App\Models\RencanaRealisasi;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RencanaRealisasiExport implements FromCollection, WithHeadings, WithStyles, WithMapping
{
    use Exportable;

    protected $selectedYear;

    public function __construct($selectedYear)
    {
        $this->selectedYear = $selectedYear;
    }

    public function collection()
    {
        // Gantilah ini dengan query sesuai dengan data yang ingin Anda ekspor
        $data = RencanaRealisasi::whereYear('created_at', $this->selectedYear)->get();
        $data->each(function ($item, $key) {
            $item->nomor_urut = $key + 1;
        });

        return $data;
    }

    public function headings(): array
    {
        return [
            ['Tabel: Rencana Realisasi Ekosistem'],
            ['Tahun ' . $this->selectedYear],
            [],
            [
                'No',
                'Kawasan Konservasi',
                'Rencana Pemanfaatan',
                'Luas Rencana Pemanfaatan (Ha)',
                '', // Kolom Desain Tapak (Kosong)
                '',
                'Keterangan',
            ],
            [
                '', // Kolom No (Kosong)
                '', // Kolom Kawasan Konservasi (Kosong)
                '', // Kolom Rencana Pemanfaatan (Kosong)
                'Tahun Dokumen RPE', // Sub-heading Desain Tapak
                'Metode PE', // Kolom Ruang Publik (Ha) (Kosong)
                'Target PE (Ha)', // Kolom Ruang Usaha (Ha) (Kosong)
                '', // Kolom Keterangan (Kosong)
            ],
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Sesuaikan lebar kolom berdasarkan panjang teks terpanjang dalam setiap kolom
        $columnWidths = [
            'A' => 10,  // Kolom No
            'B' => 25, // Kolom Kawasan Konservasi
            'C' => 25, // Kolom Rencana Pemanfaatan
            'D' => 25, // Kolom Luas Rencana Pemanfaatan (Ha)
            'E' => 30, // Kolom Desain Tapak
            'F' => 15, // Kolom Ruang Publik (Ha)
            'G' => 15, // Kolom Ruang Usaha (Ha)
            'H' => 25, // Kolom Keterangan
        ];

        // Atur lebar kolom sesuai dengan panjang teks terpanjang
        foreach ($columnWidths as $column => $width) {
            $sheet->getColumnDimension($column)->setWidth($width);
        }

        // Terapkan pengaturan gaya
        $styles = [
            1 => [
                'font' => ['bold' => true, 'size' => 16],
                'alignment' => ['horizontal' => 'center'],
            ],
            2 => [
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => 'left'], // Mengatur teks di baris kedua ke kiri
            ],
            5 => [
                'font' => ['bold' => true],
            ],
            8 => [
                'borders' => ['bottom' => ['borderStyle' => 'thin']],
            ],
        ];

        // Atur seluruh baris ke kiri
        for ($i = 6; $i <= 10; $i++) {
            $styles[$i] = ['alignment' => ['horizontal' => 'left']];
        }

        return $styles;
    }

    public function map($row): array
    {
        return [
            $row->nomor_urut,
            $row->kawasan_konservasi,
            $row->rencana_pemanfaatan,
            $row->luas_rencana_pemanfaatan,
            '', // Kolom Desain Tapak (Kosong)
            $row->tahun_dokumen_rpe,
            $row->metode_pe,
            $row->target_pe,
            $row->keterangan,
        ];
    }
}
