<?php

namespace Database\Seeders;

use App\Models\resort;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ResortSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            'Resort Cibodas',
            'Resort Mandalawangi',
            'Resort Gunung Putri',
            'Resort Sarongge',
            'Resort Tegallega',
            'Resort Goalpara',
            'Resort Selabintana',
            'Resort Cimungkad',
            'Resort Nagrak',
            'Resort Pasirhantap',
            'Resort Situgunung',
            'Resort Bodogol',
            'Resort Cimande',
            'Resort Cisarua',
            'Resort Tapos',
        ];
        foreach ($data as $resortName) {
            resort::create(['nama' => $resortName]);
        }
    }
}
