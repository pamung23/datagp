<?php

namespace App\Exports;

use App\Models\DesaBinaan;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DesaBinaanExport implements FromCollection, WithHeadings, WithStyles, WithMapping
{
    use Exportable;

    protected $selectedYear;

    public function __construct($selectedYear)
    {
        $this->selectedYear = $selectedYear;
    }

    public function collection()
    {
        // Ambil data dengan nomor urut berturut-turut
        $data = DesaBinaan::whereYear('created_at', $this->selectedYear)->get();

        $data->map(function ($item, $key) {
            $item->nomor_urut = $key + 1;
            return $item;
        });

        return $data;
    }

    public function headings(): array
    {
        return [
            ['Tabel: Desa Binaan di Daerah Penyangga Kawasan Konservasi'],
            ['Tahun ' . $this->selectedYear],
            [],
            [
                'No',
                'Register Kawasan Konservasi',
                'Desa Binaan di Daerah Penyangga Kawasan Konservasi',
                '',
                'Nama Kelompok',
                'Keterangan',
            ],
            [
                '', // Kolom No (Kosong)
                '', // Kolom Register Kawasan Konservasi (Kosong)
                'Kelurahan/Desa (ID Desa)',
                '', // Kolom Keterangan (Kosong)
            ],
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Tentukan lebar kolom berdasarkan panjang teks terpanjang dalam setiap kolom
        $columnWidths = [
            'A' => 10,  // Kolom No
            'B' => 25, // Kolom Register Kawasan Konservasi
            'C' => 25, // Kolom Nama Zona/Blok Pemanfaatan
            'D' => 25, // Kolom Luas Zona/Blok Pemanfaatan (Ha)
            'E' => 30, // Kolom Desain Tapak
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
                'alignment' => ['horizontal' => 'center'], // Mengatur teks di baris kedua ke kiri
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
            $row->no_register_kawasan,
            $row->desa ? $row->desa->desa : '', // Menghindari kesalahan jika relasi desa tidak tersedia
            '',
            $row->nama_kelompok,
            $row->keterangan,
        ];
    }
}
