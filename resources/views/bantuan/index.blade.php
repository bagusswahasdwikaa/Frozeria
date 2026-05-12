@extends('layouts.app')

@section('title', 'Bantuan')

@section('content')

<div class="max-w-5xl mx-auto mt-6">

    <h1 class="flex items-center gap-2 text-2xl text-gray-800 mb-6">
        <i class="bi bi-question-circle-fill text-indigo-900"></i>
        Panduan Penggunaan Sistem
    </h1>

    {{-- 1. Cara menambah barang baru --}}
    <div class="card mb-4">
        <div class="bg-indigo-900 text-white px-5 py-3 rounded-t-2xl">
            Cara menambah barang baru
        </div>

        <div class="card-body">
            <ol class="list-decimal pl-5 space-y-3 text-sm text-gray-700">
                <li>
                    Buka halaman <strong>Dashboard</strong>, klik tombol
                    <span class="badge-info">+ Tambah Barang</span>
                    di kanan atas.
                </li>

                <li>
                    Unggah foto barang (opsional), lalu isi formulir:
                    nama, kategori, satuan, jumlah stok, harga, dan lainnya.
                </li>

                <li>
                    Klik <strong>Simpan Barang</strong>.
                    Barang akan muncul di daftar dashboard.
                </li>
            </ol>
        </div>
    </div>

    {{-- 2. Cara update stok barang masuk --}}
    <div class="card mb-4">
        <div class="bg-green-600 text-white px-5 py-3 rounded-t-2xl">
            Cara update stok barang masuk
        </div>

        <div class="card-body">
            <ol class="list-decimal pl-5 space-y-3 text-sm text-gray-700">
                <li>
                    Temukan barang di dashboard menggunakan kolom pencarian
                    atau filter kategori.
                </li>

                <li>
                    Klik tombol
                    <span class="badge">Edit</span>
                    pada baris barang tersebut.
                </li>

                <li>
                    Ubah nilai <strong>Jumlah stok</strong> sesuai kondisi saat ini,
                    lalu klik <strong>Simpan Barang</strong>.
                </li>
            </ol>
        </div>
    </div>

    {{-- 3. Cara mengelola kategori --}}
    <div class="card mb-4">
        <div class="bg-blue-500 text-white px-5 py-3 rounded-t-2xl">
            Cara mengelola kategori
        </div>

        <div class="card-body">
            <ol class="list-decimal pl-5 space-y-3 text-sm text-gray-700">
                <li>
                    Buka halaman <strong>Kategori</strong> dari navigasi atas.
                </li>

                <li>
                    Tambah, edit, atau hapus kategori sesuai kebutuhan toko.
                </li>

                <li>
                    Menghapus kategori <strong>tidak</strong> akan menghapus barang —
                    barang akan menjadi tidak berkategori.
                    Pastikan tidak ada barang dalam kategori sebelum menghapus.
                </li>
            </ol>
        </div>
    </div>

    {{-- 4. Cara mencari barang --}}
    <div class="card mb-4">
        <div class="bg-amber-400 text-black px-5 py-3 rounded-t-2xl">
            Cara mencari barang
        </div>

        <div class="card-body">
            <ol class="list-decimal pl-5 space-y-3 text-sm text-gray-700">
                <li>
                    Di halaman Dashboard, ketik nama barang pada kolom
                    <em>Cari nama barang...</em>, lalu tekan <kbd>Enter</kbd>
                    atau klik tombol <strong>Cari</strong>.
                </li>

                <li>
                    Gunakan dropdown <strong>Semua kategori</strong>
                    untuk menyaring barang berdasarkan kategori tertentu.
                </li>
            </ol>
        </div>
    </div>

    {{-- Info tambahan --}}
    <div class="alert alert-info">
        <i class="bi bi-info-circle-fill text-lg"></i>

        <div>
            <strong>Catatan Satuan:</strong>
            Satuan barang diisi bebas sesuai kebutuhan — misalnya:
            <code>pcs</code>, <code>pack</code>, <code>box</code>,
            <code>kg</code>, <code>liter</code>, dan lain-lain.
        </div>
    </div>

    <div class="alert alert-warning mb-6">
        <i class="bi bi-exclamation-triangle-fill text-lg"></i>

        <div>
            <strong>Stok Menipis:</strong>
            Sistem akan menandai barang
            yang stoknya <strong>kurang dari 20</strong>
            sebagai "Stok Rendah".

            Barang dengan stok <strong>0</strong>
            ditandai "Habis".

            Pantau card di dashboard secara rutin.
        </div>
    </div>

    {{-- INFORMASI DEVELOPER --}}
    <div class="card mb-8 overflow-hidden">

        <div class="bg-indigo-950 text-white px-5 py-4">
            <h2 class="flex items-center gap-2 text-lg border-b border-white/20 pb-2">
                <i class="bi bi-person-badge"></i>
                Informasi Developer
            </h2>
        </div>

        <div class="card-body bg-indigo-900 text-white">

            <div class="grid grid-cols-1 md:grid-cols-12 gap-y-3 text-sm">

                <div class="md:col-span-3 text-white/70">
                    Nama
                </div>
                <div class="md:col-span-9">
                    [ Sukma Bagus Wahasdwika ]
                </div>

                <div class="md:col-span-3 text-white/70">
                    NIM
                </div>
                <div class="md:col-span-9">
                    [ 2241720223 ]
                </div>

                <div class="md:col-span-3 text-white/70">
                    Kelas
                </div>
                <div class="md:col-span-9">
                    [ TI-4F ]
                </div>

                <div class="md:col-span-3 text-white/70">
                    Alamat
                </div>
                <div class="md:col-span-9">
                    [ Malang, Jawa Timur ]
                </div>

                <div class="md:col-span-3 text-white/70">
                    No. Telepon
                </div>
                <div class="md:col-span-9">
                    [ 0822-3456-7890 ]
                </div>

                <div class="md:col-span-3 text-white/70">
                    Email
                </div>
                <div class="md:col-span-9">
                    [ sukmabaguswahasdwika10@gmail.com ]
                </div>

            </div>

        </div>
    </div>

</div>

@endsection