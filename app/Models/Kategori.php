<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'kategori';

    // Primary key
    protected $primaryKey = 'id_kategori';

    // Kolom yang boleh diisi (mass assignment)
    protected $fillable = [
        'nama_kategori',
        'deskripsi',
    ];

    /**
     * Relasi: Satu kategori punya banyak barang
     */
    public function barang()
    {
        return $this->hasMany(Barang::class, 'id_kategori', 'id_kategori');
    }

    /**
     * Accessor: Jumlah barang dalam kategori ini
     */
    public function getJumlahBarangAttribute(): int
    {
        return $this->barang()->count();
    }
}
