<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StokBarang;
use Carbon\Carbon;

class StokBarangSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'kode_barang' => 'BRG-2026-001',
                'nama_barang' => 'Laptop MacBook Air M2',
                'tanggal_pembelian' => '2026-01-15',
                'pt_pembeban' => 'PT Maju Jaya',
                'satuan' => 'Unit',
                'harga_satuan' => 15000000,
                'harga_total' => 150000000, // 10 unit
                'stok_saat_ini' => 10,
            ],
            [
                'kode_barang' => 'BRG-2026-002',
                'nama_barang' => 'Monitor Dell 24 Inch',
                'tanggal_pembelian' => '2026-02-10',
                'pt_pembeban' => 'PT Sejahtera',
                'satuan' => 'Unit',
                'harga_satuan' => 2500000,
                'harga_total' => 12500000, // 5 unit
                'stok_saat_ini' => 5,
            ],
        ];

        foreach ($data as $item) {
            StokBarang::create($item);
        }
    }
}
