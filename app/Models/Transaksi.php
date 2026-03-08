<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';

    protected $fillable = [
        'kode_transaksi',
        'stok_barang_id',
        'nama_user',
        'departemen',
        'jumlah',
        'status',
        'stok_snapshot',
        'tanggal_transaksi'
    ];

    protected $casts = [
        'tanggal_transaksi' => 'datetime',
        'jumlah' => 'integer',
        'stok_snapshot' => 'integer',
    ];

    /**
     * Relasi: Satu transaksi hanya merujuk ke satu barang (Belongs To).
     */
    public function stokBarang()
    {
        return $this->belongsTo(StokBarang::class, 'stok_barang_id');
    }

    /**
     * Relasi ke User (Petugas yang menginput).
     * Jika Anda menambahkan kolom user_id di tabel transaksi nanti.
     */
    public function petugas()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Tambahkan di dalam class Transaksi
    public function getStatusAttribute($value)
    {
        return ucfirst($value);
    }
}
