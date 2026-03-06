<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Cek apakah tabel 'users' belum memiliki kolom 'role'
            if (!Schema::hasColumn('users', 'role')) {
                // Tambahkan kolom 'role' dengan tipe enum (admin/user)
                // Default value = 'user'
                // Diletakkan setelah kolom 'password'
                $table->enum('role', ['admin', 'user'])->default('user')->after('password');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Hapus kolom 'role' dari tabel users
            $table->dropColumn('role');
        });
    }
};
