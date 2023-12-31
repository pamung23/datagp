<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PengambilanHasilHutan;

class PengambilanHasilHutanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $data = [
            [
                'resort' => 'Pasirhantap',
                'bulan' => 'Januari',
                'latitude' => '-6.801145',
                'longitude' => '106.824873',
                'nama' => 'Bambu gombong'
            ],
            [
                'resort' => 'Pasirhantap',
                'bulan' => 'Januari',
                'latitude' => '-6.794154',
                'longitude' => '106.825948',
                'nama' => 'Getah damar'
            ],
            [
                'resort' => 'Pasirhantap',
                'bulan' => 'Januari',
                'latitude' => '-6.804456',
                'longitude' => '106.808292',
                'nama' => 'Bambu'
            ],
            [
                'resort' => 'Pasirhantap',
                'bulan' => 'Januari',
                'latitude' => '-6.805808',
                'longitude' => '106.80839',
                'nama' => 'Bambu'
            ],
            [
                'resort' => 'Pasirhantap',
                'bulan' => 'Februari',
                'latitude' => '-6.810459',
                'longitude' => '106.830422',
                'nama' => 'Kayu bakar'
            ],
            [
                'resort' => 'Pasirhantap',
                'bulan' => 'Februari',
                'latitude' => '-6.81029',
                'longitude' => '106.828194',
                'nama' => 'Kayu bakar'
            ],
            [
                'resort' => 'Pasirhantap',
                'bulan' => 'Februari',
                'latitude' => '-6.796852',
                'longitude' => '106.83126',
                'nama' => 'Pengambilan getah damar di luar Zona Tradisional'
            ],
            [
                'resort' => 'Tegallega',
                'bulan' => 'Maret',
                'latitude' => '-6.823',
                'longitude' => '107.0430162',
                'nama' => 'Kayu bakar'
            ],
            [
                'resort' => 'Cimungkad',
                'bulan' => 'Januari',
                'latitude' => '-6.836317',
                'longitude' => '106.907069',
                'nama' => 'Kayu Bakar'
            ],
            [
                'resort' => 'Cimungkad',
                'bulan' => 'Januari',
                'latitude' => '-6.839684',
                'longitude' => '106.906305',
                'nama' => 'Kayu Bakar'
            ],
            [
                'resort' => 'Cimungkad',
                'bulan' => 'Januari',
                'latitude' => '-6.834531',
                'longitude' => '106.910208',
                'nama' => 'Kayu Bakar'
            ],
            [
                'resort' => 'Cimungkad',
                'bulan' => 'Januari',
                'latitude' => '-6.840234',
                'longitude' => '106.904328',
                'nama' => 'Kayu Bakar'
            ],
            [
                'resort' => 'Cimungkad',
                'bulan' => 'Januari',
                'latitude' => '-6.823314',
                'longitude' => '106.907169',
                'nama' => 'Kayu Bakar'
            ],
            [
                'resort' => 'Cimungkad',
                'bulan' => 'Januari',
                'latitude' => '-6.826863',
                'longitude' => '106.908572',
                'nama' => 'Kayu Bakar'
            ],
            [
                'resort' => 'Cimungkad',
                'bulan' => 'Februari',
                'latitude' => '-6.840551',
                'longitude' => '106.905214',
                'nama' => 'Kayu Bakar'
            ],
            [
                'resort' => 'Cimungkad',
                'bulan' => 'Februari',
                'latitude' => '-6.823777',
                'longitude' => '106.906784',
                'nama' => 'Kayu Bakar'
            ],
            [
                'resort' => 'Cimungkad',
                'bulan' => 'Februari',
                'latitude' => '-6.831539',
                'longitude' => '106.877996',
                'nama' => 'Kayu Bakar'
            ],
            [
                'resort' => 'Cimungkad',
                'bulan' => 'Februari',
                'latitude' => '-6.821775',
                'longitude' => '106.897954',
                'nama' => 'Kayu Bakar'
            ],
            [
                'resort' => 'Cimungkad',
                'bulan' => 'Maret',
                'latitude' => '-6.840345',
                'longitude' => '106.904077',
                'nama' => 'Kayu Bakar'
            ],
            [
                'resort' => 'Cimungkad',
                'bulan' => 'Maret',
                'latitude' => '-6.837795',
                'longitude' => '106.87354',
                'nama' => 'Kayu Bakar'
            ],
            [
                'resort' => 'Cimungkad',
                'bulan' => 'April',
                'latitude' => '-6.826897',
                'longitude' => '106.908676',
                'nama' => 'Kayu Bakar'
            ],
            [
                'resort' => 'Cimungkad',
                'bulan' => 'April',
                'latitude' => '-6.822072',
                'longitude' => '106.899432',
                'nama' => 'Kayu Bakar'
            ],
            [
                'resort' => 'Pasirhantap',
                'bulan' => 'Mei',
                'latitude' => '-6.810703',
                'longitude' => '106.827314',
                'nama' => 'Kayu bakar'
            ],
            [
                'resort' => 'Cimungkad',
                'bulan' => 'Mei',
                'latitude' => '-6.832185',
                'longitude' => '106.913665',
                'nama' => 'kayu bakar'
            ],
            [
                'resort' => 'Mandalawangi',
                'bulan' => 'Nopember',
                'latitude' => '-6.735271',
                'longitude' => '107.005147',
                'nama' => 'Tidak ada'
            ],
        ];

        // Loop melalui data dan masukkan ke dalam database
        foreach ($data as $item) {
            PengambilanHasilHutan::create($item);
        }
    }
}
