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
        Schema::create('aset', function (Blueprint $table) {
            $table->id(); // Primary key auto increment

            $table->string('kode_barang', 50);   // Kode unik barang, maksimal 50 karakter
            $table->string('nama_barang', 255);  // Nama barang, maksimal 255 karakter
            $table->string('kategori', 100);     // Kategori barang, maksimal 100 karakter
            $table->string('merk', 150);         // Merk barang, maksimal 150 karakter
            $table->string('nomor_seri', 100);   // Nomor seri barang, maksimal 100 karakter

            $table->date('tanggal_pembelian')->nullable(); // Tanggal pembelian, boleh kosong
            $table->date('tanggal_garansi')->nullable();   // Tanggal garansi, boleh kosong

            $table->decimal('harga', 10, 2); // Harga barang, tipe decimal dengan 10 digit total dan 2 digit desimal

            $table->string('pt_pembeban', 150); // Nama perusahaan pembeban, maksimal 150 karakter
            $table->string('user_aset', 150)->nullable();   // Nama user pemilik aset, maksimal 150 karakter
            $table->string('lokasi', 255)->nullable(); // Lokasi barang, boleh kosong

            $table->enum('kondisi', ['baik', 'rusak']); // Kondisi barang, hanya bisa 'baik' atau 'rusak'
            $table->text('keterangan')->nullable();     // Keterangan tambahan, boleh kosong
            $table->enum('status', ['tersedia', 'dipinjam', 'permanen', 'menunggu']); // Status barang, hanya bisa 'tersedia' atau 'dipinjam'

            $table->string('upload_bukti_aset', 255)->nullable(); // Path file bukti tanda terima, boleh kosong

            $table->timestamps(); // Kolom created_at dan updated_at otomatis
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Menghapus tabel 'aset' jika tabel tersebut ada
        Schema::dropIfExists('aset');
    }
};
