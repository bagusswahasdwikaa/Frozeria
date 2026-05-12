<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatStok extends Model
{
    protected $table      = 'riwayat_stok';
    protected $primaryKey = 'id_riwayat';

    // Tidak pakai updated_at
    public $timestamps = false;

    protected $fillable = [
        'id_barang',
        'jenis',
        'jumlah',
        'stok_sebelum',
        'stok_sesudah',
        'keterangan',
        'nama_staf',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'jumlah'     => 'integer',
    ];

    /**
     * Riwayat dimiliki oleh satu Barang
     */
    public function barang()
    {
        return $this->belongsTo(Barang::class, 'id_barang', 'id_barang');
    }

    /**
     * Label jenis transaksi
     */
    public function getJenisLabelAttribute(): string
    {
        return match ($this->jenis) {
            'masuk'   => 'Barang Masuk',
            'keluar'  => 'Barang Keluar',
            'koreksi' => 'Koreksi Stok',
            default   => ucfirst($this->jenis),
        };
    }

    /**
     * Badge class berdasarkan jenis
     */
    public function getJenisBadgeAttribute(): string
    {
        return match ($this->jenis) {
            'masuk'   => 'success',
            'keluar'  => 'danger',
            'koreksi' => 'warning',
            default   => 'secondary',
        };
    }
}
