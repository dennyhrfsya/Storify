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
        Schema::create('transaksi', function (Blueprint $table) {
        $table->id();
        $table->string('kode_transaksi')->unique();
        $table->foreignId('stok_barang_id')->constrained('stok_barang')->onDelete('cascade');
        $table->string('nama_peminta');
        $table->string('departemen');
        $table->integer('jumlah');
        $table->enum('status', ['dipinjamkan', 'dibatalkan', 'diberikan']);

        // Kolom kunci untuk laporan "Stok Sebelumnya & Sesudah"
        $table->integer('stok_snapshot');

        $table->timestamp('tanggal_transaksi')->useCurrent();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
