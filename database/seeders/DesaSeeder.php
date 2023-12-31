<?php

namespace Database\Seeders;

use App\Models\Desa;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DesaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    { {
            $desa = [
                //agrabintana
                ['nama' => 'Sinarlaut', 'kecamatan_id' => 1],
                ['nama' => 'Bojongkaso', 'kecamatan_id' => 1],
                ['nama' => 'Sukamanah', 'kecamatan_id' => 1],
                ['nama' => 'Wanangsari', 'kecamatan_id' => 1],
                ['nama' => 'Karangsari', 'kecamatan_id' => 1],
                ['nama' => 'Neglasari', 'kecamatan_id' => 1],
                ['nama' => 'Mulyasari', 'kecamatan_id' => 1],
                ['nama' => 'Bunisari', 'kecamatan_id' => 1],
                ['nama' => 'Mekarsari', 'kecamatan_id' => 1],
                ['nama' => 'Tanjungsari', 'kecamatan_id' => 1],
                ['nama' => 'Wangunjaya', 'kecamatan_id' => 1],

                //leles
                ['nama' => 'Pusakasar', 'kecamatan_id' => 2],
                ['nama' => 'Nagasari', 'kecamatan_id' => 2],
                ['nama' => 'Sukajaya', 'kecamatan_id' => 2],
                ['nama' => 'Sukamulya', 'kecamatan_id' => 2],
                ['nama' => 'Cempaka Mulya', 'kecamatan_id' => 2],
                ['nama' => 'Purabaya', 'kecamatan_id' => 2],
                ['nama' => 'Sukasirna', 'kecamatan_id' => 2],
                ['nama' => 'Walahir', 'kecamatan_id' => 2],
                ['nama' => 'Puncakwangi', 'kecamatan_id' => 2],
                ['nama' => 'Sirnasari', 'kecamatan_id' => 2],
                ['nama' => 'Karyamukti', 'kecamatan_id' => 2],
                ['nama' => 'Mandalawangi', 'kecamatan_id' => 2],
                ['nama' => 'Sindangsari', 'kecamatan_id' => 2],

                //sindangbarang
                ['nama' => 'Hegarsari', 'kecamatan_id' => 3],
                ['nama' => 'Jatisari', 'kecamatan_id' => 3],
                ['nama' => 'Kertasari', 'kecamatan_id' => 3],
                ['nama' => 'Sirnagalih', 'kecamatan_id' => 3],
                ['nama' => 'Saganten', 'kecamatan_id' => 3],
                ['nama' => 'Jayagiri', 'kecamatan_id' => 3],
                ['nama' => 'Muaracikadu', 'kecamatan_id' => 3],
                ['nama' => 'Girimukti', 'kecamatan_id' => 3],
                ['nama' => 'Mekarlaksana', 'kecamatan_id' => 3],
                ['nama' => 'Kertamukti', 'kecamatan_id' => 3],

                //Cidaun
                ['nama' => 'Karyabakti', 'kecamatan_id' => 4],
                ['nama' => 'Sukapura', 'kecamatan_id' => 4],
                ['nama' => 'Cisalak', 'kecamatan_id' => 4],
                ['nama' => 'Jayapura', 'kecamatan_id' => 4],
                ['nama' => 'Kertajadi', 'kecamatan_id' => 4],
                ['nama' => 'Cidamar', 'kecamatan_id' => 4],
                ['nama' => 'Karangwangi', 'kecamatan_id' => 4],
                ['nama' => 'Cimaragang', 'kecamatan_id' => 4],
                ['nama' => 'Gelarpawitan', 'kecamatan_id' => 4],
                ['nama' => 'Neglasari', 'kecamatan_id' => 4],
                ['nama' => 'Cibuluh', 'kecamatan_id' => 4],
                ['nama' => 'Puncakbaru', 'kecamatan_id' => 4],
                ['nama' => 'Megarjaya', 'kecamatan_id' => 4],
                ['nama' => 'Gelarwangi', 'kecamatan_id' => 4],

                //naringgul
                ['nama' => 'Cinerang', 'kecamatan_id' => 5],
                ['nama' => 'Wangunjaya', 'kecamatan_id' => 5],
                ['nama' => 'Mekarsari', 'kecamatan_id' => 5],
                ['nama' => 'Wangunsari', 'kecamatan_id' => 5],
                ['nama' => 'Melati', 'kecamatan_id' => 5],
                ['nama' => 'Sukamulya', 'kecamatan_id' => 5],
                ['nama' => 'Naringgul', 'kecamatan_id' => 5],
                ['nama' => 'Wanasari', 'kecamatan_id' => 5],
                ['nama' => 'Sukabakti', 'kecamatan_id' => 5],
                ['nama' => 'Balegede', 'kecamatan_id' => 5],
                ['nama' => 'Margasari', 'kecamatan_id' => 5],

                //Cibinong
                ['nama' => 'Panyindangan', 'kecamatan_id' => 5],
                ['nama' => 'Wargaluyu', 'kecamatan_id' => 5],
                ['nama' => 'Hamerang', 'kecamatan_id' => 5],
                ['nama' => 'Pananggapan', 'kecamatan_id' => 5],
                ['nama' => 'Girijaya', 'kecamatan_id' => 5],
                ['nama' => 'Sukajadi', 'kecamatan_id' => 5],
                ['nama' => 'Sukamekar', 'kecamatan_id' => 5],
                ['nama' => 'Batulawang', 'kecamatan_id' => 5],
                ['nama' => 'Cikangkareng', 'kecamatan_id' => 5],
                ['nama' => 'Pamayonan', 'kecamatan_id' => 5],
                ['nama' => 'Cimaskara', 'kecamatan_id' => 5],
                ['nama' => 'Padasuka', 'kecamatan_id' => 5],
                ['nama' => 'Mekarmukti', 'kecamatan_id' => 5],
                ['nama' => 'Ciburial', 'kecamatan_id' => 5],

                //Cikadu
                ['nama' => 'Padaluyu', 'kecamatan_id' => 6],
                ['nama' => 'Sukaluyu', 'kecamatan_id' => 6],
                ['nama' => 'Mekarlaksana', 'kecamatan_id' => 6],
                ['nama' => 'Cikadu', 'kecamatan_id' => 6],
                ['nama' => 'Kelapanunggal', 'kecamatan_id' => 6],
                ['nama' => 'Mekarwangi', 'kecamatan_id' => 6],
                ['nama' => 'Cisaranten', 'kecamatan_id' => 6],
                ['nama' => 'Sukamulya', 'kecamatan_id' => 6],
                ['nama' => 'Mekarjaya', 'kecamatan_id' => 6],
                ['nama' => 'Sukamana', 'kecamatan_id' => 6],

                //
                // ['nama' => 'Sukamulya', 'kecamatan_id' => 5],
            ];

            // Loop through the data and insert into the database
            foreach ($desa as $data) {
                Desa::create($data);
            }
        }
    }
}
