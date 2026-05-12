<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\RiwayatStok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BarangController extends Controller
{
    /**
     * GET /
     * Dashboard - Daftar semua barang dengan pencarian & filter kategori
     */
    public function index(Request $request)
    {
        $search      = $request->get('search', '');
        $kategoriId  = $request->get('kategori', '');

        // Query barang dengan eager load kategori
        $query = Barang::with('kategori');

        // Filter pencarian nama
        if ($search) {
            $query->cariNama($search);
        }

        // Filter kategori
        if ($kategoriId) {
            $query->byKategori((int) $kategoriId);
        }

        // Pagination 10 item per halaman
        $barang = $query->orderBy('nama_barang')->paginate(10)->withQueryString();

        // Data untuk card informasi
        $totalBarang    = Barang::count();
        $totalKategori  = kategori::count();
        $stokMenipis    = Barang::stokMenipis()->count();
        $stokHabis      = Barang::stokHabis()->count();

        // Semua kategori untuk dropdown filter
        $semuaKategori  = Kategori::orderBy('nama_kategori')->get();

        return view('barang.index', compact(
            'barang',
            'search',
            'kategoriId',
            'totalBarang',
            'totalKategori',
            'stokMenipis',
            'stokHabis',
            'semuaKategori'
        ));
    }

    /**
     * GET /barang/{id}
     * Halaman detail barang
     */
    public function show(int $id)
    {
        $barang = Barang::with(['kategori', 'riwayatStok'])->findOrFail($id);
        return view('barang.detail', compact('barang'));
    }

    /**
     * GET /barang/create
     * Form tambah barang baru
     */
    public function create()
    {
        $kategori = Kategori::orderBy('nama_kategori')->get();

        return view('barang.form', [
            'barang'   => null,
            'kategori' => $kategori,
            'title'    => 'Tambah Barang Baru',
        ]);
    }

    /**
     * POST /barang
     * Simpan barang baru ke database
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_barang'        => 'required|string|max:150',
            'id_kategori'        => 'required|exists:kategori,id_kategori',
            'satuan'             => 'required|string|max:20',
            'stok'               => 'required|integer|min:0',
            'stok_minimum'       => 'nullable|integer|min:0',
            'harga_jual'         => 'nullable|numeric|min:0',
            'harga_beli'         => 'nullable|numeric|min:0',
            'suhu_simpan'        => 'nullable|string|max:50',
            'berat_ukuran'       => 'nullable|string|max:50',
            'lokasi_simpan'      => 'nullable|string|max:100',
            'deskripsi'          => 'nullable|string',
            'tanggal_kadaluarsa' => 'nullable|date',
            'foto'               => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], $this->pesan());

        // Generate kode barang
        $validated['kode_barang'] =
            $this->generateKodeBarang(
                $validated['id_kategori']
            );

        // Default stok minimum
        $validated['stok_minimum'] =
            $validated['stok_minimum'] ?? 5;

        /**
         * UPLOAD FOTO
         */
        if ($request->hasFile('foto')) {

            $pathFoto = $this->uploadFoto(
                $request->file('foto')
            );

            $validated['foto'] = $pathFoto;
        }

        // Simpan barang
        $barang = Barang::create($validated);

        /**
         * RIWAYAT STOK
         */
        if ($barang->stok > 0) {

            RiwayatStok::create([
                'id_barang'    => $barang->id_barang,
                'jenis'        => 'masuk',
                'jumlah'       => $barang->stok,
                'stok_sebelum' => 0,
                'stok_sesudah' => $barang->stok,
                'keterangan'   => 'Stok awal saat barang ditambahkan',
                'nama_staf'    => 'Sistem',
                'created_at'   => now(),
            ]);
        }

        return redirect()
            ->route('barang.index')
            ->with(
                'success',
                'Barang "' . $barang->nama_barang . '" berhasil ditambahkan.'
            );
    }

    /**
     * GET /barang/{id}/edit
     * Form edit barang
     */
    public function edit(int $id)
    {
        $barang   = Barang::findOrFail($id);
        $kategori = Kategori::orderBy('nama_kategori')->get();

        return view('barang.form', [
            'barang'   => $barang,
            'kategori' => $kategori,
            'title'    => 'Edit Barang',
        ]);
    }

    /**
     * PUT /barang/{id}
     * Update data barang di database
     */
    public function update(Request $request, int $id)
    {
        $barang = Barang::findOrFail($id);

        $validated = $request->validate([
            'nama_barang'        => 'required|string|max:150',
            'id_kategori'        => 'required|exists:kategori,id_kategori',
            'satuan'             => 'required|string|max:20',
            'stok'               => 'required|integer|min:0',
            'stok_minimum'       => 'nullable|integer|min:0',
            'harga_jual'         => 'nullable|numeric|min:0',
            'harga_beli'         => 'nullable|numeric|min:0',
            'suhu_simpan'        => 'nullable|string|max:50',
            'berat_ukuran'       => 'nullable|string|max:50',
            'lokasi_simpan'      => 'nullable|string|max:100',
            'deskripsi'          => 'nullable|string',
            'tanggal_kadaluarsa' => 'nullable|date',
            'foto'               => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'hapus_foto'         => 'nullable|boolean',
        ], $this->pesan());

        $stokLama = $barang->stok;

        // Proses foto
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            $this->hapusFoto($barang->foto);
            $validated['foto'] = $this->uploadFoto($request->file('foto'));
        } elseif ($request->boolean('hapus_foto')) {
            $this->hapusFoto($barang->foto);
            $validated['foto'] = null;
        }

        $barang->update($validated);

        // Catat riwayat stok jika berubah
        $stokBaru = (int) $validated['stok'];
        if ($stokLama !== $stokBaru) {
            $selisih = abs($stokBaru - $stokLama);
            $jenis   = $stokBaru > $stokLama ? 'masuk' : 'keluar';

            RiwayatStok::create([
                'id_barang'    => $barang->id_barang,
                'jenis'        => $jenis,
                'jumlah'       => $selisih,
                'stok_sebelum' => $stokLama,
                'stok_sesudah' => $stokBaru,
                'keterangan'   => 'Perubahan stok via form edit barang',
                'nama_staf'    => 'Staf',
                'created_at'   => now(),
            ]);
        }

        return redirect()
            ->route('barang.index')
            ->with('success', 'Barang "' . $barang->nama_barang . '" berhasil diperbarui.');
    }

    /**
     * DELETE /barang/{id}
     * Hapus barang dari database
     */
    public function destroy(int $id)
    {
        $barang = Barang::findOrFail($id);
        $nama   = $barang->nama_barang;

        // Hapus foto dari storage
        $this->hapusFoto($barang->foto);

        // Hapus barang (cascade: riwayat stok ikut terhapus)
        $barang->delete();

        return redirect()
            ->route('barang.index')
            ->with('success', 'Barang "' . $nama . '" berhasil dihapus dari sistem.');
    }

    // -------------------------------------------------------
    // PRIVATE HELPERS
    // -------------------------------------------------------

    /**
     * Upload foto barang ke storage/public/uploads
     */
    private function uploadFoto($file): string
    {
        $namaFile = time() . '_'
            . Str::slug(
                pathinfo(
                    $file->getClientOriginalName(),
                    PATHINFO_FILENAME
                )
            )
            . '.'
            . $file->getClientOriginalExtension();

        $file->storeAs('uploads', $namaFile, 'public');

        return 'uploads/' . $namaFile;
    }

    /**
     * Hapus foto dari storage
     */
    private function hapusFoto(?string $pathFoto): void
    {
        if (
            $pathFoto &&
            Storage::disk('public')->exists($pathFoto)
        ) {
            Storage::disk('public')->delete($pathFoto);
        }
    }

    /**
     * Generate kode barang otomatis berdasarkan kategori
     * Format: XXX-NNN (3 huruf kategori - 3 digit nomor urut)
     */
    private function generateKodeBarang(int $idKategori): string
    {
        $kategori = Kategori::find($idKategori);
        $prefix   = strtoupper(substr(preg_replace('/[^a-zA-Z]/', '', $kategori->nama_kategori), 0, 3));

        // Cari nomor urut terakhir untuk prefix ini
        $lastBarang = Barang::where('kode_barang', 'like', $prefix . '-%')
                            ->orderByDesc('kode_barang')
                            ->first();

        $nomor = 1;
        if ($lastBarang) {
            $parts = explode('-', $lastBarang->kode_barang);
            $nomor = (int) end($parts) + 1;
        }

        return $prefix . '-' . str_pad($nomor, 3, '0', STR_PAD_LEFT);
    }

    /**
     * Pesan validasi dalam Bahasa Indonesia
     */
    private function pesan(): array
    {
        return [
            'nama_barang.required'  => 'Nama barang wajib diisi.',
            'nama_barang.max'       => 'Nama barang maksimal 150 karakter.',
            'id_kategori.required'  => 'Kategori wajib dipilih.',
            'id_kategori.exists'    => 'Kategori tidak ditemukan.',
            'satuan.required'       => 'Satuan wajib diisi.',
            'stok.required'         => 'Jumlah stok wajib diisi.',
            'stok.integer'          => 'Jumlah stok harus berupa angka.',
            'stok.min'              => 'Jumlah stok tidak boleh negatif.',
            'harga_jual.numeric'    => 'Harga jual harus berupa angka.',
            'harga_beli.numeric'    => 'Harga beli harus berupa angka.',
            'foto.image'            => 'File harus berupa gambar.',
            'foto.mimes'            => 'Format foto harus JPG atau PNG.',
            'foto.max'              => 'Ukuran foto maksimal 2 MB.',
        ];
    }
}
