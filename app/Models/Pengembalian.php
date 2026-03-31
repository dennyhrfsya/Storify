<?php

namespace App\Models;

use App\Models\Peminjaman;
use Illuminate\Database\Eloquent\Model;

class Pengembalian extends Model
{
    protected $table = 'pengembalian';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_peminjaman',
        'kode_pengembalian',
        'tanggal_pengembalian',
        'foto_pengembalian',
        'kondisi_pengembalian',
        'catatan'
    ];

    protected $casts = [
        'tanggal_pengembalian' => 'date',
    ];

    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class, 'id_peminjaman', 'id');
    }
}
