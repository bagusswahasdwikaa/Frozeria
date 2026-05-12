<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Barang extends Model
{
    use HasFactory;

    protected $table      = 'barang';
    protected $primaryKey = 'id_barang';

    protected $fillable = [
        'id_kategori',
        'kode_barang',
        'nama_barang',
        'deskripsi',
        'foto',
        'satuan',
        'stok',
        'stok_minimum',
        'harga_beli',
        'harga_jual',
        'suhu_simpan',
        'berat_ukuran',
        'lokasi_simpan',
        'tanggal_kadaluarsa',
    ];

    protected $casts = [
        'stok'               => 'integer',
        'stok_minimum'       => 'integer',
        'harga_beli'         => 'decimal:2',
        'harga_jual'         => 'decimal:2',
        'tanggal_kadaluarsa' => 'date',
    ];

    // -------------------------------------------------------
    // RELATIONSHIPS
    // -------------------------------------------------------

    /**
     * Barang dimiliki oleh satu Kategori
     */
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }

    /**
     * Barang memiliki banyak riwayat stok
     */
    public function riwayatStok()
    {
        return $this->hasMany(RiwayatStok::class, 'id_barang', 'id_barang')
                    ->orderByDesc('created_at');
    }

    // -------------------------------------------------------
    // ACCESSORS
    // -------------------------------------------------------

    /**
     * URL foto barang. Jika tidak ada foto, kembalikan URL placeholder.
     */
    public function getFotoUrlAttribute()
    {
        if ($this->foto) {
            return asset('storage/' . $this->foto);
        }

        return asset('images/no-image.png');
    }

    /**
     * Status stok barang
     */
    public function getStatusStokAttribute(): string
    {
        if ($this->stok == 0) {
            return 'Habis';
        } elseif ($this->stok < $this->stok_minimum) {
            return 'Stok Rendah';
        }
        return 'Tersedia';
    }

    /**
     * Badge class Bootstrap berdasarkan status stok
     */
    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status_stok) {
            'Habis'       => 'danger',
            'Stok Rendah' => 'warning',
            default       => 'success',
        };
    }

    /**
     * Format harga jual ke Rupiah
     */
    public function getHargaJualFormatAttribute(): string
    {
        return 'Rp ' . number_format($this->harga_jual, 0, ',', '.');
    }

    /**
     * Format harga beli ke Rupiah
     */
    public function getHargaBeliFormatAttribute(): string
    {
        return 'Rp ' . number_format($this->harga_beli, 0, ',', '.');
    }

    // -------------------------------------------------------
    // SCOPES
    // -------------------------------------------------------

    /**
     * Scope: Filter berdasarkan nama barang (pencarian)
     */
    public function scopeCariNama($query, string $keyword)
    {
        return $query->where('nama_barang', 'like', '%' . $keyword . '%');
    }

    /**
     * Scope: Filter berdasarkan kategori
     */
    public function scopeByKategori($query, int $idKategori)
    {
        return $query->where('id_kategori', $idKategori);
    }

    /**
     * Scope: Stok menipis (stok > 0 tapi < stok_minimum)
     */
    public function scopeStokMenipis($query)
    {
        return $query->where('stok', '>', 0)->where('stok', '<', 20);
    }

    /**
     * Scope: Stok habis (stok = 0)
     */
    public function scopeStokHabis($query)
    {
        return $query->where('stok', 0);
    }
}
