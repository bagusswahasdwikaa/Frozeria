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
        Schema::table('barang', function (Blueprint $table) {

            if (!Schema::hasColumn('barang', 'berat_ukuran')) {
                $table->string('berat_ukuran', 50)->nullable();
            }

            if (!Schema::hasColumn('barang', 'lokasi_simpan')) {
                $table->string('lokasi_simpan', 100)->nullable();
            }

            if (!Schema::hasColumn('barang', 'suhu_simpan')) {
                $table->string('suhu_simpan', 50)->nullable();
            }

            if (!Schema::hasColumn('barang', 'deskripsi')) {
                $table->text('deskripsi')->nullable();
            }

            if (!Schema::hasColumn('barang', 'tanggal_kadaluarsa')) {
                $table->date('tanggal_kadaluarsa')->nullable();
            }

            if (!Schema::hasColumn('barang', 'foto')) {
                $table->string('foto')->nullable();
            }

            if (!Schema::hasColumn('barang', 'stok_minimum')) {
                $table->integer('stok_minimum')->default(5);
            }

            if (!Schema::hasColumn('barang', 'harga_jual')) {
                $table->decimal('harga_jual', 15, 2)->nullable();
            }

            if (!Schema::hasColumn('barang', 'harga_beli')) {
                $table->decimal('harga_beli', 15, 2)->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('barang', function (Blueprint $table) {

            $table->dropColumn([
                'berat_ukuran',
                'lokasi_simpan',
                'suhu_simpan',
                'deskripsi',
                'tanggal_kadaluarsa',
                'foto',
                'stok_minimum',
                'harga_jual',
                'harga_beli'
            ]);
        });
    }
};