<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Aset;

class AsetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Aset::create([
        //     'kode_barang' => 'BRG001',
        //     'nama_barang' => 'Laptop Dell',
        //     'kategori' => 'Elektronik',
        //     'merk' => 'Dell',
        //     'nomor_seri' => 'SN12345',
        //     'tanggal_pembelian' => '2024-01-15',
        //     'harga' => 15000000,
        //     'pt_pembeban' => 'PT Teknologi',
        //     'user_aset' => 'Tarjo',
        //     'lokasi' => 'Gudang A',
        //     'kondisi' => 'baik',
        //     'keterangan' => 'Masih baru',
        //     'status' => 'tersedia',
        //     'upload_bukti_aset' => null,
        // ]);
        Aset::factory(50)->create();
    }
}
