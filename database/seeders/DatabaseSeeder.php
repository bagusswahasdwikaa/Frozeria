<?php

namespace Database\Seeders;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\RiwayatStok;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed data awal untuk toko Frozeria
     */
    public function run(): void
    {
        // -------------------------------------------------------
        // SEED KATEGORI
        // -------------------------------------------------------
        $kategoriData = [
            ['nama_kategori' => 'Ayam',    'deskripsi' => 'Produk olahan daging ayam beku, nugget, fillet, dll'],
            ['nama_kategori' => 'Sapi',    'deskripsi' => 'Produk olahan daging sapi beku, bakso, burger, dll'],
            ['nama_kategori' => 'Seafood', 'deskripsi' => 'Ikan, udang, cumi, kepiting, dan hasil laut beku'],
            ['nama_kategori' => 'Sayuran', 'deskripsi' => 'Aneka sayuran yang telah dibekukan siap masak'],
            ['nama_kategori' => 'Siap Saji','deskripsi' => 'Makanan beku yang siap digoreng atau dipanaskan'],
            ['nama_kategori' => 'Dimsum',  'deskripsi' => 'Siomay, dimsum, gyoza, dumpling, dan produk serupa'],
            ['nama_kategori' => 'Dessert', 'deskripsi' => 'Es krim, sorbet, dan dessert beku lainnya'],
            ['nama_kategori' => 'Minuman', 'deskripsi' => 'Jus beku, es buah, dan minuman beku lainnya'],
        ];

        foreach ($kategoriData as $data) {
            Kategori::firstOrCreate(['nama_kategori' => $data['nama_kategori']], $data);
        }

        // -------------------------------------------------------
        // SEED BARANG
        // -------------------------------------------------------
        $barangData = [
            // Ayam
            [
                'id_kategori' => Kategori::where('nama_kategori','Ayam')->value('id_kategori'),
                'kode_barang' => 'AYA-001', 'nama_barang' => 'Ayam nugget crispy',
                'satuan' => 'pcs', 'stok' => 120, 'stok_minimum' => 20,
                'harga_beli' => 22000, 'harga_jual' => 35000,
                'suhu_simpan' => '-18°C', 'berat_ukuran' => '500 gram',
                'lokasi_simpan' => 'Rak A-1',
                'deskripsi' => 'Nugget ayam dengan lapisan tepung crispy, cocok untuk camilan atau bekal. Tersedia dalam kemasan 500 gr berisi ±20 pcs.',
            ],
            [
                'id_kategori' => Kategori::where('nama_kategori','Ayam')->value('id_kategori'),
                'kode_barang' => 'AYA-002', 'nama_barang' => 'Ayam fillet dada 1kg',
                'satuan' => 'pack', 'stok' => 45, 'stok_minimum' => 15,
                'harga_beli' => 32000, 'harga_jual' => 42000,
                'suhu_simpan' => '-18°C', 'berat_ukuran' => '1 kg',
                'lokasi_simpan' => 'Rak A-2',
                'deskripsi' => 'Fillet dada ayam tanpa tulang dan kulit, beku segar.',
            ],
            // Sapi
            [
                'id_kategori' => Kategori::where('nama_kategori','Sapi')->value('id_kategori'),
                'kode_barang' => 'SAP-001', 'nama_barang' => 'Sosis sapi premium',
                'satuan' => 'pack', 'stok' => 15, 'stok_minimum' => 20,
                'harga_beli' => 20000, 'harga_jual' => 28000,
                'suhu_simpan' => '-18°C', 'berat_ukuran' => '500 gram',
                'lokasi_simpan' => 'Rak B-1',
                'deskripsi' => 'Sosis sapi premium tanpa campuran babi, lembut dan gurih.',
            ],
            [
                'id_kategori' => Kategori::where('nama_kategori','Sapi')->value('id_kategori'),
                'kode_barang' => 'SAP-002', 'nama_barang' => 'Bakso urat sapi',
                'satuan' => 'pack', 'stok' => 60, 'stok_minimum' => 20,
                'harga_beli' => 18000, 'harga_jual' => 22000,
                'suhu_simpan' => '-18°C', 'berat_ukuran' => '500 gram',
                'lokasi_simpan' => 'Rak B-2',
                'deskripsi' => 'Bakso urat sapi asli, kenyal dan kaya rasa.',
            ],
            // Seafood
            [
                'id_kategori' => Kategori::where('nama_kategori','Seafood')->value('id_kategori'),
                'kode_barang' => 'SEA-001', 'nama_barang' => 'Dim sum udang',
                'satuan' => 'box', 'stok' => 0, 'stok_minimum' => 10,
                'harga_beli' => 32000, 'harga_jual' => 45000,
                'suhu_simpan' => '-18°C', 'berat_ukuran' => '300 gram',
                'lokasi_simpan' => 'Rak C-1',
                'deskripsi' => 'Dimsum isi udang asli, premium, isi 10 pcs per kotak.',
            ],
            [
                'id_kategori' => Kategori::where('nama_kategori','Seafood')->value('id_kategori'),
                'kode_barang' => 'SEA-002', 'nama_barang' => 'Udang vaname 500g',
                'satuan' => 'pack', 'stok' => 25, 'stok_minimum' => 10,
                'harga_beli' => 42000, 'harga_jual' => 55000,
                'suhu_simpan' => '-18°C', 'berat_ukuran' => '500 gram',
                'lokasi_simpan' => 'Rak C-2',
                'deskripsi' => 'Udang vaname ukuran 50/60, sudah dikupas dan dibersihkan.',
            ],
            // Sayuran
            [
                'id_kategori' => Kategori::where('nama_kategori','Sayuran')->value('id_kategori'),
                'kode_barang' => 'SAY-001', 'nama_barang' => 'Edamame beku',
                'satuan' => 'pack', 'stok' => 0, 'stok_minimum' => 10,
                'harga_beli' => 15000, 'harga_jual' => 18000,
                'suhu_simpan' => '-18°C', 'berat_ukuran' => '400 gram',
                'lokasi_simpan' => 'Rak D-1',
                'deskripsi' => 'Kacang edamame rebus beku, siap saji, cocok untuk camilan sehat.',
            ],
            [
                'id_kategori' => Kategori::where('nama_kategori','Sayuran')->value('id_kategori'),
                'kode_barang' => 'SAY-002', 'nama_barang' => 'Mix sayuran beku 500g',
                'satuan' => 'pack', 'stok' => 40, 'stok_minimum' => 12,
                'harga_beli' => 12000, 'harga_jual' => 18000,
                'suhu_simpan' => '-18°C', 'berat_ukuran' => '500 gram',
                'lokasi_simpan' => 'Rak D-2',
                'deskripsi' => 'Campuran wortel, kacang polong, jagung, dan buncis beku.',
            ],
            // Siap Saji
            [
                'id_kategori' => Kategori::where('nama_kategori','Siap Saji')->value('id_kategori'),
                'kode_barang' => 'SIA-001', 'nama_barang' => 'Kentang goreng crispy 1kg',
                'satuan' => 'pack', 'stok' => 35, 'stok_minimum' => 15,
                'harga_beli' => 18000, 'harga_jual' => 25000,
                'suhu_simpan' => '-18°C', 'berat_ukuran' => '1 kg',
                'lokasi_simpan' => 'Rak E-1',
                'deskripsi' => 'French fries kentang lurus ukuran sedang, siap goreng langsung.',
            ],
        ];

        foreach ($barangData as $data) {
            $stokAwal = $data['stok'];
            $barang   = Barang::firstOrCreate(
                ['kode_barang' => $data['kode_barang']],
                $data
            );

            // Catat riwayat stok awal
            if ($barang->wasRecentlyCreated && $stokAwal > 0) {
                RiwayatStok::create([
                    'id_barang'    => $barang->id_barang,
                    'jenis'        => 'masuk',
                    'jumlah'       => $stokAwal,
                    'stok_sebelum' => 0,
                    'stok_sesudah' => $stokAwal,
                    'keterangan'   => 'Stok awal data seed',
                    'nama_staf'    => 'Admin',
                    'created_at'   => now(),
                ]);
            }
        }

        $this->command->info('✅ Data Frozeria berhasil di-seed!');
        $this->command->info('   - ' . Kategori::count() . ' kategori');
        $this->command->info('   - ' . Barang::count() . ' barang');
    }
}
