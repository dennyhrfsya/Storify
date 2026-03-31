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
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id();
            $table->string('kode_peminjaman', 20)->unique();
            $table->foreignId('id_aset')->constrained('aset', 'id');
            $table->string('user_aset', 150); // Nama peminjam manual
            $table->date('tanggal_peminjaman');
            $table->string('foto_peminjaman', 255)->nullable();
            $table->enum('status', ['dipinjam', 'dikembalikan','permanen'])->default('dipinjam');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};
