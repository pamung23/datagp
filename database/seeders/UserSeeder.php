<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'nama_lengkap' => 'admin',
            'username' => 'admin',
            'email' => 'admin@example.com',
            'hp' => '081234567',
            'password' => Hash::make('password'),
            'level' => 'Admin',
        ]);

        // Seeder untuk role Balai
        User::create([
            'nama_lengkap' => 'Balai User',
            'username' => 'balai_user',
            'email' => 'balai@example.com',
            'hp' => '08123456700',
            'password' => Hash::make('password'),
            'level' => 'Balai',
        ]);

        User::create([
            'nama_lengkap' => 'cibodas',
            'username' => 'cibodas',
            'email' => 'cibodas@example.com',
            'hp' => '08123456787',
            'password' => Hash::make('password'),
            'level' => 'Wilayah Cianjur',
            'resort_id' => 1, // Ganti dengan ID resort yang sesuai
        ]);
        User::create([
            'nama_lengkap' => 'Mandalawangi',
            'username' => 'mandalawangi',
            'email' => 'mandalawangi@example.com',
            'hp' => '08123456788',
            'password' => Hash::make('password'),
            'level' => 'Wilayah Cianjur',
            'resort_id' => 2, // Ganti dengan ID resort yang sesuai
        ]);
        User::create([
            'nama_lengkap' => 'Gunungputri',
            'username' => 'gunungputri',
            'email' => 'gunungputri@example.com',
            'hp' => '08123456789',
            'password' => Hash::make('password'),
            'level' => 'Wilayah Cianjur',
            'resort_id' => 3, // Ganti dengan ID resort yang sesuai
        ]);
        User::create([
            'nama_lengkap' => 'Sarongge',
            'username' => 'sarongge',
            'email' => 'sarongge@example.com',
            'hp' => '08123456790',
            'password' => Hash::make('password'),
            'level' => 'Wilayah Cianjur',
            'resort_id' => 4, // Ganti dengan ID resort yang sesuai
        ]);
        User::create([
            'nama_lengkap' => 'tegallega',
            'username' => 'tegallega',
            'email' => 'tegallega@example.com',
            'hp' => '08123456791',
            'password' => Hash::make('password'),
            'level' => 'Wilayah Cianjur',
            'resort_id' => 5, // Ganti dengan ID resort yang sesuai
        ]);
        // Seeder untuk role Wilayah Sukabumi
        User::create([
            'nama_lengkap' => 'goalpara',
            'username' => 'goalpara',
            'email' => 'goalpara@example.com',
            'hp' => '08123456792',
            'password' => Hash::make('password'),
            'level' => 'Wilayah Sukabumi',
            'resort_id' => 6, // Ganti dengan ID resort yang sesuai
        ]);
        User::create([
            'nama_lengkap' => 'salabintana',
            'username' => 'salabintana',
            'email' => 'salabintana@example.com',
            'hp' => '08123456793',
            'password' => Hash::make('password'),
            'level' => 'Wilayah Sukabumi',
            'resort_id' => 7, // Ganti dengan ID resort yang sesuai
        ]);
        User::create([
            'nama_lengkap' => 'cimungkad',
            'username' => 'cimungkad',
            'email' => 'cimungkad@example.com',
            'hp' => '08123456794',
            'password' => Hash::make('password'),
            'level' => 'Wilayah Sukabumi',
            'resort_id' => 8, // Ganti dengan ID resort yang sesuai
        ]);
        User::create([
            'nama_lengkap' => 'nagrak',
            'username' => 'nagrak',
            'email' => 'nagrak@example.com',
            'hp' => '08123456795',
            'password' => Hash::make('password'),
            'level' => 'Wilayah Sukabumi',
            'resort_id' => 9, // Ganti dengan ID resort yang sesuai
        ]);
        User::create([
            'nama_lengkap' => 'pasirhantap',
            'username' => 'pasirhantap',
            'email' => 'pasirhantap@example.com',
            'hp' => '08123456796',
            'password' => Hash::make('password'),
            'level' => 'Wilayah Sukabumi',
            'resort_id' => 10, // Ganti dengan ID resort yang sesuai
        ]);
        User::create([
            'nama_lengkap' => 'situgunung',
            'username' => 'situgunung',
            'email' => 'situgunung@example.com',
            'hp' => '08123456711',
            'password' => Hash::make('password'),
            'level' => 'Wilayah Sukabumi',
            'resort_id' => 11, // Ganti dengan ID resort yang sesuai
        ]);
        // Seeder untuk role Wilayah Bogor
        User::create([
            'nama_lengkap' => 'bodogol',
            'username' => 'bodogol',
            'email' => 'bodogol@example.com',
            'hp' => '08123456797',
            'password' => Hash::make('password'),
            'level' => 'Wilayah Bogor',
            'resort_id' => 12, // Ganti dengan ID resort yang sesuai
        ]);
        User::create([
            'nama_lengkap' => 'cimande',
            'username' => 'cimande',
            'email' => 'cimande@example.com',
            'hp' => '08123456798',
            'password' => Hash::make('password'),
            'level' => 'Wilayah Bogor',
            'resort_id' => 13 // Ganti dengan ID resort yang sesuai
        ]);
        User::create([
            'nama_lengkap' => 'cisarua',
            'username' => 'cisarua',
            'email' => 'cisarua@example.com',
            'hp' => '08123456799',
            'password' => Hash::make('password'),
            'level' => 'Wilayah Bogor',
            'resort_id' => 14, // Ganti dengan ID resort yang sesuai
        ]);
        User::create([
            'nama_lengkap' => 'tapos',
            'username' => 'tapos',
            'email' => 'tapos@example.com',
            'hp' => '08123456800',
            'password' => Hash::make('password'),
            'level' => 'Wilayah Bogor',
            'resort_id' => 15, // Ganti dengan ID resort yang sesuai
        ]);
    }
}
