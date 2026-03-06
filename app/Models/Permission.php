<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = [
        'role', 'module', 'all', 'tambah', 'ubah', 'hapus'
    ];
}
