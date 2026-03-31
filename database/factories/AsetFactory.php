<?php

namespace Database\Factories;

use App\Models\Aset;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Aset>
 */
class AsetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Aset::class;

    public function definition(): array
    {
        $kategori = fake()->randomElement(['Laptop', 'Monitor', 'Printer', 'Scanner', 'Server', 'CCTV']);

        return [
            'kode_barang'       => 'BRG' . strtoupper(fake()->unique()->bothify('??-####')),
            'nama_barang'       => $kategori . ' ' . fake()->word(),
            'kategori'          => $kategori,
            'merk'              => fake()->randomElement(['Asus', 'Lenovo', 'HP', 'Dell', 'Logitech', 'Epson', 'Hikvision']),
            'nomor_seri'        => strtoupper(fake()->bothify('SN-**********')),
            'tanggal_pembelian' => fake()->date('Y-m-d', 'now'),
            'tanggal_garansi'   => fake()->dateTimeBetween('now', '+2 years')->format('Y-m-d'),
            'kuantitas'         => fake()->numberBetween(1, 20),
            'harga'             => fake()->numberBetween(100000, 15000000),
            'pt_pembeban'       => fake()->randomElement([
                                    'PT Mitrel Berkat Utama',
                                    'PT Armindo Langgeng Sejahtera',
                                    'PT Bumi Hardana Sakti'
                                   ]),
            'user_aset'         => null,
            'departemen'        => null,
            'lokasi'            => null,
            'grade_barang'      => fake()->randomElement(['baru', 'bekas']),
            'kondisi'           => fake()->randomElement(['baik', 'rusak']),
            'keterangan'        => fake()->sentence(),
            'status'            => 'tersedia', // Karena user/lokasi null, status default tersedia
            'upload_bukti_aset' => null,
        ];
    }
}
