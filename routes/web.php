<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\BantuanController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Sistem Stok Opname Frozeria
|--------------------------------------------------------------------------
*/

// -------------------------------------------------------
// ROOT → redirect ke dashboard
// -------------------------------------------------------
Route::get('/', function () {
    return redirect()->route('barang.index');
});

// -------------------------------------------------------
// DASHBOARD / DAFTAR BARANG
// -------------------------------------------------------
Route::prefix('barang')->name('barang.')->group(function () {

    // GET  /barang          → Dashboard daftar barang
    Route::get('/',           [BarangController::class, 'index'])->name('index');

    // GET  /barang/create   → Form tambah barang baru
    Route::get('/create',     [BarangController::class, 'create'])->name('create');

    // POST /barang          → Simpan barang baru
    Route::post('/',          [BarangController::class, 'store'])->name('store');

    // GET  /barang/{id}     → Detail barang
    Route::get('/{id}',       [BarangController::class, 'show'])->name('show');

    // GET  /barang/{id}/edit  → Form edit barang
    Route::get('/{id}/edit',  [BarangController::class, 'edit'])->name('edit');

    // PUT  /barang/{id}     → Update data barang
    Route::put('/{id}',       [BarangController::class, 'update'])->name('update');

    // DELETE /barang/{id}   → Hapus barang
    Route::delete('/{id}',    [BarangController::class, 'destroy'])->name('destroy');
});

// -------------------------------------------------------
// KATEGORI
// -------------------------------------------------------
Route::prefix('kategori')->name('kategori.')->group(function () {

    // GET  /kategori          → Daftar kategori
    Route::get('/',           [KategoriController::class, 'index'])->name('index');

    // GET  /kategori/create   → Form tambah kategori
    Route::get('/create',     [KategoriController::class, 'create'])->name('create');

    // POST /kategori          → Simpan kategori baru
    Route::post('/',          [KategoriController::class, 'store'])->name('store');

    // GET  /kategori/{id}/edit  → Form edit kategori
    Route::get('/{id}/edit',  [KategoriController::class, 'edit'])->name('edit');

    // PUT  /kategori/{id}     → Update data kategori
    Route::put('/{id}',       [KategoriController::class, 'update'])->name('update');

    // DELETE /kategori/{id}   → Hapus kategori
    Route::delete('/{id}',    [KategoriController::class, 'destroy'])->name('destroy');
});

// -------------------------------------------------------
// BANTUAN
// -------------------------------------------------------
Route::get('/bantuan', [BantuanController::class, 'index'])->name('bantuan.index');
