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
        Schema::create('pengembalian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_peminjaman')->constrained('peminjaman', 'id')->onDelete('cascade');
            $table->string('kode_pengembalian', 20)->unique();
            $table->date('tanggal_pengembalian');
            $table->string('foto_pengembalian', 255)->nullable();
            $table->enum('kondisi_pengembalian', ['baik', 'rusak'])->default('baik');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengembalian');
    }
};
