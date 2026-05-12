<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Tabel: barang - Menyimpan data produk makanan beku
     */
    public function up(): void
    {
        Schema::create('barang', function (Blueprint $table) {
            $table->id('id_barang');
            $table->unsignedBigInteger('id_kategori');
            $table->string('kode_barang', 20)->unique();
            $table->string('nama_barang', 150);
            $table->text('deskripsi')->nullable();
            $table->string('foto', 255)->nullable()->comment('Nama file foto produk');
            $table->string('satuan', 20)->default('pcs')->comment('Satuan: pcs, kg, pack, karton, dll');
            $table->integer('stok')->default(0);
            $table->integer('stok_minimum')->default(5)->comment('Batas stok minimum');
            $table->decimal('harga_beli', 12, 2)->default(0);
            $table->decimal('harga_jual', 12, 2)->default(0);
            $table->string('suhu_simpan', 50)->nullable()->comment('Mis: -18C');
            $table->string('berat_ukuran', 50)->nullable()->comment('Mis: 500 gram');
            $table->string('lokasi_simpan', 100)->nullable()->comment('Mis: Rak A-3');
            $table->date('tanggal_kadaluarsa')->nullable();
            $table->timestamps();

            // Foreign key ke tabel kategori
            $table->foreign('id_kategori')
                  ->references('id_kategori')
                  ->on('kategori')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');

            // Index untuk pencarian & filter
            $table->index('nama_barang');
            $table->index('id_kategori');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang');
    }
};
