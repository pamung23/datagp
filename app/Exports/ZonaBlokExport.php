<?php

namespace App\Exports;

use App\Models\ZonaBlok;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ZonaBlokExport implements FromCollection, WithHeadings, WithStyles, WithMapping
{
    use Exportable;

    protected $selectedYear;

    public function __construct($selectedYear)
    {
        $this->selectedYear = $selectedYear;
    }

    public function collection()
    {
        // Retrieve data with sequential numbers
        $data = ZonaBlok::whereYear('created_at', $this->selectedYear)->get();

        $data->map(function ($item, $key) {
            $item->nomor_urut = $key + 1;
            return $item;
        });

        return $data;
    }

    public function headings(): array
    {
        return [
            ['Tabel: Zona dan Blok Tradisional Kawasan Konservasi'],
            ['Tahun ' . $this->selectedYear],
            [],
            [
                'No',
                'Register Kawasan Konservasi',
                'Zona dan Blok Tradisional Kawasan Konservasi',
                '',
                '',
                'Keterangan',
            ],
            [
                '', // Kolom No (Kosong)
                '', // Kolom Register Kawasan Konservasi (Kosong)
                '',
                'Kelurahan/Desa (ID Desa)',
                'Luas Zona Tradisional (Ha)', // Kolom Keterangan (Kosong)
                '',
            ],
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Define column widths based on the longest text in each column
        $columnWidths = [
            'A' => 10,  // Column No
            'B' => 25, // Column Register Kawasan Konservasi
            'C' => 25, // Column Nama Zona/Blok Pemanfaatan
            'D' => 25, // Column Luas Zona/Blok Pemanfaatan (Ha)
            'E' => 30, // Column Desain Tapak
            'H' => 25, // Column Keterangan
        ];

        // Set column widths according to the defined values
        foreach ($columnWidths as $column => $width) {
            $sheet->getColumnDimension($column)->setWidth($width);
        }

        // Apply styles
        $styles = [
            1 => [
                'font' => ['bold' => true, 'size' => 16],
                'alignment' => ['horizontal' => 'center'],
            ],
            2 => [
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => 'center'], // Set text in the second row to left-align
            ],
            5 => [
                'font' => ['bold' => true],
            ],
            8 => [
                'borders' => ['bottom' => ['borderStyle' => 'thin']],
            ],
        ];

        // Set all rows to left-align
        for ($i = 6; $i <= 10; $i++) {
            $styles[$i] = ['alignment' => ['horizontal' => 'left']];
        }

        return $styles;
    }

    public function map($row): array
    {
        return [
            $row->nomor_urut,
            $row->no_register_kawasan,
            ($row->desa)->desa, // Use optional() to prevent errors if the desa relation is not available
            $row->luas_ha,
            $row->nama_kelompok,
            $row->keterangan,
        ];
    }
}
