<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hak akses default untuk admin
        $modules = ['User', 'Inventory'];

        foreach ($modules as $module) {
            Permission::create([
                'role'   => 'admin',
                'module' => $module,
                'all'    => true,
                'tambah' => true,
                'ubah'   => true,
                'hapus'  => true,
            ]);
        }

        // Hak akses default untuk user
        foreach ($modules as $module) {
            Permission::create([
                'role'   => 'user',
                'module' => $module,
                'all'    => true,   // bisa lihat menu
                'tambah' => false,  // tidak bisa tambah
                'ubah'   => false,  // tidak bisa ubah
                'hapus'  => false,  // tidak bisa hapus
            ]);
        }
    }
}
