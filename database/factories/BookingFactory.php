<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => $this->faker->unique()->numerify('##########'), // 10 digit angka acak
            'tujuan' => $this->faker->word,
            'pintu_masuk' => $this->faker->word,
            'pintu_keluar' => $this->faker->word,
            'tanggal_masuk' => $this->faker->date,
            'tanggal_keluar' => $this->faker->date,
            'organisasi_nama' => $this->faker->company,
            'organisasi_alamat' => $this->faker->address,
            'organisasi_telepon' => $this->faker->phoneNumber,
            'anggota' => $this->faker->text,
            'sandi' => $this->faker->text,
            'pembayaran' => $this->faker->text,
            'validasi' => $this->faker->text,
            'kesehatan' => $this->faker->text,
            'simaksi' => $this->faker->text,
            'last_update' => $this->faker->dateTime,
            'agency' => $this->faker->text,
            'flag' => $this->faker->text,
            'batal' => $this->faker->boolean,
        ];
    }
}
