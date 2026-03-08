<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transaksi;
use App\Models\StokBarang;

class TransaksiSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil barang pertama (MacBook)
        $barang1 = StokBarang::where('kode_barang', 'BRG-2026-001')->first();

        Transaksi::create([
            'kode_transaksi' => 'TRX/2026/03/001',
            'stok_barang_id' => $barang1->id,
            'nama_peminta'   => 'Agus Setiawan',
            'departemen'     => 'IT Support',
            'jumlah'         => 2,
            'status'         => 'dipinjamkan',
            'stok_snapshot'  => 8, // Stok awal 10 - 2 = 8
            'tanggal_transaksi' => now(),
        ]);

        // Update stok fisik di tabel master setelah dipinjam
        $barang1->update(['stok_saat_ini' => 8]);

        // Ambil barang kedua (Monitor)
        $barang2 = StokBarang::where('kode_barang', 'BRG-2026-002')->first();

        Transaksi::create([
            'kode_transaksi' => 'TRX/2026/03/002',
            'stok_barang_id' => $barang2->id,
            'nama_peminta'   => 'Siti Aminah',
            'departemen'     => 'HRD',
            'jumlah'         => 1,
            'status'         => 'diberikan',
            'stok_snapshot'  => 4, // Stok awal 5 - 1 = 4
            'tanggal_transaksi' => now(),
        ]);

        // Update stok fisik
        $barang2->update(['stok_saat_ini' => 4]);
    }
}
