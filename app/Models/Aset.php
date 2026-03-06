<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aset extends Model
{
    use HasFactory;

    protected $table = 'aset'; // Nama tabel yang digunakan model ini

    // Field yang boleh diisi secara mass assignment
    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'kategori',
        'merk',
        'nomor_seri',
        'tanggal_pembelian',
        'tanggal_garansi',
        'kuantitas',
        'harga',
        'pt_pembeban',
        'user_aset',
        'lokasi',
        'kondisi',
        'keterangan',
        'status',
        'bukti_tanda_terima',
    ];

    // Casting field ke tipe data tertentu agar otomatis dikonversi saat diakses
    protected $casts = [
        'tanggal_pembelian' => 'date',   // otomatis jadi instance Carbon
        'tanggal_garansi'   => 'date',   // otomatis jadi instance Carbon
        'status_garansi'    => 'date',   // akan diperlakukan sebagai tanggal (pastikan field ini ada di tabel)
        'harga'             => 'decimal:2', // harga otomatis jadi decimal dengan 2 digit di belakang koma
    ];
}
