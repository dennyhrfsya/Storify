<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::all();
        return view('users.hak-akses', compact('permissions'));
    }

    /**
     * Update atau buat permission berdasarkan role dan module.
     *
     * Alur:
     * 1. Cari permission berdasarkan role dan module dari request.
     * 2. Jika tidak ditemukan, buat permission baru dengan role dan module tersebut.
     * 3. Update field tertentu (dinamis sesuai request->field) dengan value yang diberikan.
     * 4. Kembalikan response JSON dengan status sukses.
     *
     * Catatan:
     * - $request->field digunakan sebagai key untuk update, sehingga pastikan field valid.
     * - Jika permission belum ada, otomatis akan dibuat terlebih dahulu.
     */
    public function update(Request $request)
    {
        // Cari permission berdasarkan role dan module
        $permission = Permission::where('role', $request->role)
            ->where('module', $request->module)
            ->first();

        // Jika belum ada, buat permission baru
        if (!$permission) {
            $permission = Permission::create([
                'role' => $request->role,
                'module' => $request->module,
            ]);
        }

        // Update field sesuai request
        $permission->update([
            $request->field => $request->value
        ]);

        // Kembalikan response sukses
        return response()->json(['success' => true]);
    }
}
