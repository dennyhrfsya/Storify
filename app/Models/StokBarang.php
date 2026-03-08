<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokBarang extends Model
{
    use HasFactory;

    // Menentukan nama tabel secara manual (karena bukan jamak/plural inggris)
    protected $table = 'stok_barang';

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'tanggal_pembelian',
        'pt_pembeban',
        'satuan',
        'harga_satuan',
        'harga_total',
        'stok_saat_ini'
    ];

    // Mengubah tipe data secara otomatis saat dipanggil
    protected $casts = [
        'tanggal_pembelian' => 'date',
        'harga_satuan' => 'decimal:2',
        'harga_total' => 'decimal:2',
        'stok_saat_ini' => 'integer',
    ];

    /**
     * Relasi: Satu barang bisa memiliki banyak transaksi.
     */
    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, 'stok_barang_id');
    }
}
