<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KategoriController extends Controller
{
    /**
     * GET /kategori
     * Halaman daftar semua kategori
     */
    public function index(Request $request)
    {
        $search = $request->get('search', '');

        $query = Kategori::withCount('barang');

        if ($search) {
            $query->where('nama_kategori', 'like', '%' . $search . '%');
        }

        $kategori = $query->orderBy('nama_kategori')->get();

        return view('kategori.index', compact('kategori', 'search'));
    }

    /**
     * GET /kategori/create
     * Form tambah kategori baru
     */
    public function create()
    {
        return view('kategori.form', [
            'kategori' => null,
            'title'    => 'Tambah Kategori',
        ]);
    }

    /**
     * POST /kategori
     * Simpan kategori baru ke database
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:100|unique:kategori,nama_kategori',
            'deskripsi'     => 'nullable|string',
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.unique'   => 'Nama kategori sudah ada.',
            'nama_kategori.max'      => 'Nama kategori maksimal 100 karakter.',
        ]);

        Kategori::create($validated);

        return redirect()
            ->route('kategori.index')
            ->with('success', 'Kategori "' . $validated['nama_kategori'] . '" berhasil ditambahkan.');
    }

    /**
     * GET /kategori/{id}/edit
     * Form edit kategori
     */
    public function edit(int $id)
    {
        $kategori = Kategori::findOrFail($id);

        return view('kategori.form', [
            'kategori' => $kategori,
            'title'    => 'Edit Kategori',
        ]);
    }

    /**
     * PUT /kategori/{id}
     * Update data kategori
     */
    public function update(Request $request, int $id)
    {
        $kategori = Kategori::findOrFail($id);

        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:100|unique:kategori,nama_kategori,' . $id . ',id_kategori',
            'deskripsi'     => 'nullable|string',
        ], [
            'nama_kategori.required' => 'Nama kategori wajib diisi.',
            'nama_kategori.unique'   => 'Nama kategori sudah digunakan kategori lain.',
        ]);

        $kategori->update($validated);

        return redirect()
            ->route('kategori.index')
            ->with('success', 'Kategori "' . $kategori->nama_kategori . '" berhasil diperbarui.');
    }

    /**
     * DELETE /kategori/{id}
     * Hapus kategori dari database
     */
    public function destroy(int $id)
    {
        $kategori = Kategori::findOrFail($id);

        // Cek apakah kategori masih digunakan barang
        if ($kategori->barang()->count() > 0) {
            return redirect()
                ->route('kategori.index')
                ->with('error', 'Kategori "' . $kategori->nama_kategori . '" tidak dapat dihapus karena masih memiliki ' . $kategori->barang()->count() . ' barang.');
        }

        $namaKategori = $kategori->nama_kategori;
        $kategori->delete();

        return redirect()
            ->route('kategori.index')
            ->with('success', 'Kategori "' . $namaKategori . '" berhasil dihapus.');
    }
}
