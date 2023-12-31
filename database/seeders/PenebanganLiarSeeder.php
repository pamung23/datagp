<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PenebanganLiar;

class PenebanganLiarSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'resort' => 'Gunung Putri',
                'bulan' => 'Januari',
                'latitude' => -6.767094,
                'longitude' => 106.997127,
                'nama' => 'Pohon rasamala'
            ],
            [
                'resort' => 'Bodogol',
                'bulan' => 'Februari',
                'latitude' => -6.778442,
                'longitude' => 106.833592,
                'nama' => 'Kayu bulat'
            ],
            [
                'resort' => 'Gunung Putri',
                'bulan' => 'Maret',
                'latitude' => -6.76884,
                'longitude' => 107.013818,
                'nama' => 'Kayu bulat'
            ],
            [
                'resort' => 'Cimungkad',
                'bulan' => 'Januari',
                'latitude' => -6.841149,
                'longitude' => 106.906808,
                'nama' => 'Tunggak pohon'
            ],
            [
                'resort' => 'Cimungkad',
                'bulan' => 'Januari',
                'latitude' => -6.830006,
                'longitude' => 106.87414,
                'nama' => 'Tunggak pohon'
            ],
            [
                'resort' => 'Cimungkad',
                'bulan' => 'Februari',
                'latitude' => -6.82938,
                'longitude' => 106.886856,
                'nama' => 'Batang tiang kayu'
            ],
            [
                'resort' => 'Cimungkad',
                'bulan' => 'Februari',
                'latitude' => -6.836229,
                'longitude' => 106.911892,
                'nama' => 'Tunggak pohon'
            ],
            [
                'resort' => 'Cimungkad',
                'bulan' => 'Februari',
                'latitude' => -6.823631,
                'longitude' => 106.898512,
                'nama' => 'Tunggak pohon'
            ],
            [
                'resort' => 'Cimungkad',
                'bulan' => 'Februari',
                'latitude' => -6.812704,
                'longitude' => 106.90565,
                'nama' => 'Tunggak pohon'
            ],
            [
                'resort' => 'Cimungkad',
                'bulan' => 'Maret',
                'latitude' => -6.841071,
                'longitude' => 106.907206,
                'nama' => 'Tunggak pohon'
            ],
            [
                'resort' => 'Cimungkad',
                'bulan' => 'Maret',
                'latitude' => -6.84284,
                'longitude' => 106.905148,
                'nama' => 'Tunggak pohon'
            ],
            [
                'resort' => 'Cimungkad',
                'bulan' => 'Maret',
                'latitude' => -6.819184,
                'longitude' => 106.907711,
                'nama' => 'Sisa batang tiang kayu'
            ],
            [
                'resort' => 'Cimungkad',
                'bulan' => 'April',
                'latitude' => -6.819717,
                'longitude' => 106.906913,
                'nama' => 'Tunggak pohon'
            ],
            [
                'resort' => 'Pasirhantap',
                'bulan' => 'April',
                'latitude' => -6.810552,
                'longitude' => 106.827197,
                'nama' => 'Tunggak pohon suren diameter 18 cm'
            ],
            [
                'resort' => 'Cimungkad',
                'bulan' => 'Mei',
                'latitude' => -6.830885,
                'longitude' => 106.911411,
                'nama' => 'Batang tiang (pohon) dan tunggak'
            ],
            [
                'resort' => 'Pasirhantap',
                'bulan' => 'Juni',
                'latitude' => -6.812818,
                'longitude' => 106.829795,
                'nama' => 'Bambu'
            ],
            [
                'resort' => 'Pasirhantap',
                'bulan' => 'Juni',
                'latitude' => -6.814463,
                'longitude' => 106.829477,
                'nama' => 'Pohon suren'
            ],
            [
                'resort' => 'Cisarua',
                'bulan' => 'Januari',
                'latitude' => -6.742175817,
                'longitude' => 106.9289379,
                'nama' => 'Tidak ada'
            ],
            [
                'resort' => 'Cimungkad',
                'bulan' => 'Juni',
                'latitude' => -6.838144,
                'longitude' => 106.90512,
                'nama' => 'Tunggak pohon'
            ],
            [
                'resort' => 'Pasirhantap',
                'bulan' => 'Juli',
                'latitude' => -6.811346,
                'longitude' => 106.827021,
                'nama' => 'Pohon meranti'
            ],
            [
                'resort' => 'Pasirhantap',
                'bulan' => 'Juli',
                'latitude' => -6.813799,
                'longitude' => 106.826188,
                'nama' => 'Suren'
            ],
            [
                'resort' => 'Cimungkad',
                'bulan' => 'Juli',
                'latitude' => -6.84587,
                'longitude' => 106.865853,
                'nama' => 'Tunggak pohon'
            ],
            [
                'resort' => 'Cimungkad',
                'bulan' => 'Agustus',
                'latitude' => -6.83887,
                'longitude' => 106.904613,
                'nama' => 'Kayu Kaliandra'
            ],
            [
                'resort' => 'Cimungkad',
                'bulan' => 'September',
                'latitude' => -6.836555,
                'longitude' => 106.90801,
                'nama' => 'Kaliandra'
            ],
            [
                'resort' => 'Mandalawangi',
                'bulan' => 'September',
                'latitude' => -6.735271,
                'longitude' => 107.005641,
                'nama' => 'Tidak ada'
            ],
            [
                'resort' => 'Tegallega',
                'bulan' => 'September',
                'latitude' => -6.84000613,
                'longitude' => 107.0266531,
                'nama' => 'Dokumentasi'
            ],
            [
                'resort' => 'Cisarua',
                'bulan' => 'September',
                'latitude' => -6.697665,
                'longitude' => 106.917478,
                'nama' => 'Tidak ada'
            ],
            [
                'resort' => 'Cimungkad',
                'bulan' => 'Oktober',
                'latitude' => -6.821867,
                'longitude' => 106.913487,
                'nama' => 'Pengambilan bambu'
            ],
            [
                'resort' => 'Mandalawangi',
                'bulan' => 'Oktober',
                'latitude' => -6.735271,
                'longitude' => 107.005845,
                'nama' => 'Tidak ada'
            ],
            [
                'resort' => 'Bodogol',
                'bulan' => 'Oktober',
                'latitude' => -6.770194,
                'longitude' => 106.840538,
                'nama' => 'Jenis pohon Afrika'
            ],
            [
                'resort' => 'Selabintana',
                'bulan' => 'Nopember',
                'latitude' => -6.841462,
                'longitude' => 106.9358,
                'nama' => 'Kaliandra'
            ],
            [
                'resort' => 'Mandalawangi',
                'bulan' => 'Nopember',
                'latitude' => -6.735271,
                'longitude' => 107.005147,
                'nama' => 'Tidak ada'
            ],
            [
                'resort' => 'Cimungkad',
                'bulan' => 'Nopember',
                'latitude' => -6.821877,
                'longitude' => 106.89816,
                'nama' => 'Tunggak kayu'
            ],
            [
                'resort' => 'Selabintana',
                'bulan' => 'Desember',
                'latitude' => -6.836393,
                'longitude' => 106.961805,
                'nama' => 'Tunggak'
            ],
        ];

        // Loop data dan masukkan ke dalam database menggunakan model PenebanganLiar
        foreach ($data as $item) {
            PenebanganLiar::create($item);
        }
    }
}
