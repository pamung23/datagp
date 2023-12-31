<?php

namespace Database\Seeders;

use App\Models\Kabupaten;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KabupatenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kabupatens = [
            ['nama' => 'Cianjur'],
            ['nama' => 'Sukabumi'],
            ['nama' => 'Bogor'],
            // Add more data as needed
        ];

        // Loop through the data and insert into the database
        foreach ($kabupatens as $data) {
            Kabupaten::create($data);
        }
    }
}
