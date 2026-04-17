<?php

namespace App\Models;

use App\Models\Pengembalian;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';
    protected $primaryKey = 'id';

    protected $fillable = [
        'kode_peminjaman',
        'id_aset',
        'urutan_pemakaian',
        'user_aset',
        'pt_user',
        'departemen',
        'lokasi',
        'tanggal_peminjaman',
        'foto_peminjaman',
        'status'
    ];

    protected $casts = [
        'tanggal_peminjaman' => 'date',
    ];

    public function aset()
    {
        return $this->belongsTo(Aset::class, 'id_aset', 'id');
    }

    public function pengembalian()
    {
        return $this->hasOne(Pengembalian::class, 'id_peminjaman', 'id');
    }
}
