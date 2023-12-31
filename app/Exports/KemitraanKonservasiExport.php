<?php

namespace App\Exports;

use App\Models\KemitraanKonservasi;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class KemitraanKonservasiExport implements FromCollection, WithHeadings, WithStyles, WithMapping
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
        $data = KemitraanKonservasi::whereYear('created_at', $this->selectedYear)->get();
        $data->each(function ($item, $key) {
            $item->nomor_urut = $key + 1;
        });

        return $data;
    }

    public function headings(): array
    {
        return [
            ['Tabel: Kemitraan Konservasi'],
            ['Tahun ' . $this->selectedYear],
            [],
            ['No', 'Register Kawasan Konservasi', '', '', '', '', 'Kemitraan Konservasi', '', '', '', '', '', 'Keterangan'],
            ['', '', 'Kelurahan/Desa', 'Nama Kelompok', 'Anggota (Orang)', 'Luas PKS (Ha)', 'Zona/Blok', 'Bentuk Kemitraan Konservasi', 'Perkiraan Nilai Ekonomi per Tahun (Rp)', ''],
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Tentukan lebar kolom berdasarkan panjang teks terpanjang dalam setiap kolom
        $columnWidths = [
            'A' => 5,  // Kolom No
            'B' => 25, // Kolom Register Kawasan Konservasi
            'C' => 25, // Kolom Kelurahan/Desa
            'D' => 20, // Kolom Nama Kelompok
            'E' => 20, // Kolom Anggota (Orang)
            'F' => 15, // Kolom Luas PKS (Ha)
            'G' => 15, // Kolom Zona/Blok
            'H' => 30, // Kolom Bentuk Kemitraan Konservasi
            'I' => 25, // Kolom Perkiraan Nilai Ekonomi per Tahun (Rp)
            'J' => 25, // Kolom Keterangan
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
            4 => [
                'font' => ['bold' => true],
                'borders' => ['bottom' => ['borderStyle' => 'thin']],
                'alignment' => ['horizontal' => 'left'], // Mengatur teks di baris keempat ke kiri
            ],
        ];

        // Atur seluruh baris ke kiri
        for ($i = 5; $i <= 10; $i++) {
            $styles[$i] = ['alignment' => ['horizontal' => 'left']];
        }

        return $styles;
    }



    public function map($row): array
    {
        return [
            $row->nomor_urut,
            $row->nomor_register,
            $row->desa_id,
            $row->nama_kelompok,
            $row->jumlah_anggota,
            $row->luas_pks,
            $row->zona_blok,
            $row->bentuk_kemitraan,
            $row->nilai_ekonomi_per_tahun,
            $row->keterangan,
        ];
    }
}
