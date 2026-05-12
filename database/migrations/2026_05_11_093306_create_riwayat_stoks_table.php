<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Tabel: riwayat_stok - Mencatat setiap perubahan stok
     */
    public function up(): void
    {
        Schema::create('riwayat_stok', function (Blueprint $table) {
            $table->id('id_riwayat');
            $table->unsignedBigInteger('id_barang');
            $table->enum('jenis', ['masuk', 'keluar', 'koreksi'])
                  ->comment('masuk=penerimaan, keluar=penjualan, koreksi=opname');
            $table->integer('jumlah')->comment('Jumlah unit yang berubah (selalu positif)');
            $table->integer('stok_sebelum');
            $table->integer('stok_sesudah');
            $table->text('keterangan')->nullable();
            $table->string('nama_staf', 100)->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('id_barang')
                  ->references('id_barang')
                  ->on('barang')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');

            $table->index('id_barang');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_stok');
    }
};
