@extends('layouts.app')

@section('title', 'Detail Barang – ' . $barang->nama_barang)

@section('content')

{{-- ══════════════════════════════════════
     HEADER & ACTION
══════════════════════════════════════ --}}
<div class="flex flex-col lg:flex-row
            items-start lg:items-center
            justify-between gap-4 mb-6">

    <div class="flex items-center gap-3">

        <a href="{{ route('barang.index') }}"
           class="btn-secondary btn-sm">

            <i class="bi bi-arrow-left"></i>
            Kembali

        </a>

        <div>

            <h1 class="text-2xl font-bold text-gray-800">
                Detail Barang
            </h1>

            <p class="text-sm text-gray-500 mt-1">
                Informasi lengkap barang.
            </p>

        </div>

    </div>

    <div class="flex flex-wrap gap-2">

        {{-- Edit --}}
        <a href="{{ route('barang.edit', $barang->id_barang) }}"
           class="btn-primary btn-sm">

            <i class="bi bi-pencil"></i>
            Edit Barang

        </a>

        {{-- Hapus --}}
        <button type="button"
                class="btn-danger btn-sm"
                data-hapus-nama="{{ $barang->nama_barang }}"
                data-hapus-url="{{ route('barang.destroy', $barang->id_barang) }}">

            <i class="bi bi-trash3"></i>
            Hapus

        </button>

    </div>

</div>

{{-- ══════════════════════════════════════
     CONTENT
══════════════════════════════════════ --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- SIDEBAR --}}
    <div class="lg:col-span-1">

        <div class="card h-full">

            <div class="card-body flex flex-col items-center text-center">

                {{-- FOTO --}}
                <div class="w-full h-56
                            bg-gray-100 rounded-xl
                            overflow-hidden
                            flex items-center justify-center mb-4">

                    <img src="{{ $barang->foto_url }}"
                        alt="{{ $barang->nama_barang }}"
                        class="w-full h-full object-contain"
                        loading="lazy"
                        onerror="this.onerror=null;this.src='{{ asset('images/no-image.png') }}';">
                    
                </div>

                {{-- NAMA --}}
                <h2 class="text-xl font-bold text-gray-800 mb-2">
                    {{ $barang->nama_barang }}
                </h2>

                {{-- KATEGORI --}}
                <span class="badge-kategori mb-3">
                    {{ $barang->kategori->nama_kategori }}
                </span>

                {{-- KODE --}}
                <div class="text-sm text-gray-500 flex items-center gap-1">

                    <i class="bi bi-upc-scan"></i>

                    {{ $barang->kode_barang }}

                </div>

                {{-- STATUS --}}
                <div class="mt-5">

                    @php
                        $badgeClass = match($barang->status_stok) {
                            'Habis'       => 'badge-stok-habis',
                            'Stok Rendah' => 'badge-stok-menipis',
                            default       => 'badge-stok-ok',
                        };
                    @endphp

                    <span class="{{ $badgeClass }}">
                        {{ $barang->status_stok }}
                    </span>

                </div>

            </div>

        </div>

    </div>

    {{-- DETAIL --}}
    <div class="lg:col-span-2 space-y-6">

        {{-- INFORMASI --}}
        <div class="card">

            <div class="card-body">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    {{-- STOK --}}
                    <div class="bg-gray-50 rounded-xl p-4">

                        <div class="text-sm text-gray-500 mb-1">
                            Jumlah stok
                        </div>

                        <div class="text-2xl font-bold text-gray-800">
                            {{ $barang->stok }} {{ $barang->satuan }}
                        </div>

                    </div>

                    {{-- STOK MINIMUM --}}
                    <div class="bg-gray-50 rounded-xl p-4">

                        <div class="text-sm text-gray-500 mb-1">
                            Stok minimum
                        </div>

                        <div class="text-2xl font-bold text-gray-800">
                            {{ $barang->stok_minimum }} {{ $barang->satuan }}
                        </div>

                    </div>

                    {{-- HARGA JUAL --}}
                    <div class="bg-gray-50 rounded-xl p-4">

                        <div class="text-sm text-gray-500 mb-1">
                            Harga jual
                        </div>

                        <div class="text-2xl font-bold text-indigo-700">
                            {{ $barang->harga_jual_format }}
                        </div>

                    </div>

                    {{-- HARGA BELI --}}
                    <div class="bg-gray-50 rounded-xl p-4">

                        <div class="text-sm text-gray-500 mb-1">
                            Harga beli
                        </div>

                        <div class="text-2xl font-bold text-gray-700">
                            {{ $barang->harga_beli_format }}
                        </div>

                    </div>

                    {{-- BERAT --}}
                    <div class="bg-gray-50 rounded-xl p-4">

                        <div class="text-sm text-gray-500 mb-1">
                            Berat / ukuran
                        </div>

                        <div class="font-semibold text-gray-800">
                            {{ $barang->berat_ukuran ?? '-' }}
                        </div>

                    </div>

                    {{-- LOKASI --}}
                    <div class="bg-gray-50 rounded-xl p-4">

                        <div class="text-sm text-gray-500 mb-1">
                            Lokasi simpan
                        </div>

                        <div class="font-semibold text-gray-800">
                            {{ $barang->lokasi_simpan ?? '-' }}
                        </div>

                    </div>

                    {{-- SUHU --}}
                    <div class="bg-gray-50 rounded-xl p-4">

                        <div class="text-sm text-gray-500 mb-1">
                            Suhu simpan
                        </div>

                        <div class="font-semibold text-gray-800">
                            {{ $barang->suhu_simpan ?? '-' }}
                        </div>

                    </div>

                    {{-- EXPIRED --}}
                    <div class="bg-gray-50 rounded-xl p-4">

                        <div class="text-sm text-gray-500 mb-1">
                            Tanggal kadaluarsa
                        </div>

                        <div class="font-semibold text-gray-800">

                            {{ $barang->tanggal_kadaluarsa
                                ? $barang->tanggal_kadaluarsa->format('d M Y')
                                : '-' }}

                        </div>

                    </div>

                    {{-- DESKRIPSI --}}
                    @if($barang->deskripsi)

                    <div class="md:col-span-2
                                bg-gray-50 rounded-xl p-4">

                        <div class="text-sm text-gray-500 mb-1">
                            Deskripsi
                        </div>

                        <div class="text-gray-700 leading-relaxed">
                            {{ $barang->deskripsi }}
                        </div>

                    </div>

                    @endif

                </div>

            </div>

        </div>

        {{-- RIWAYAT STOK --}}
        @if($barang->riwayatStok->count() > 0)

        <div class="card overflow-hidden">

            <div class="px-5 py-4 border-b border-gray-200
                        flex items-center gap-2">

                <i class="bi bi-clock-history text-indigo-700"></i>

                <h2 class="font-bold text-gray-800">
                    Riwayat Stok
                </h2>

            </div>

            <div class="overflow-x-auto">

                <table class="table-barang">

                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Jenis</th>
                            <th class="text-center">Jumlah</th>
                            <th class="text-center">Sebelum</th>
                            <th class="text-center">Sesudah</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($barang->riwayatStok->take(10) as $r)

                        <tr>

                            <td class="text-sm text-gray-500 whitespace-nowrap">
                                {{ $r->created_at->format('d/m/Y H:i') }}
                            </td>

                            <td>

                                @php
                                    $riwayatBadge = match($r->jenis_badge) {
                                        'danger' => 'badge-danger',
                                        'warning' => 'badge-warning',
                                        default => 'badge-success',
                                    };
                                @endphp

                                <span class="{{ $riwayatBadge }}">
                                    {{ $r->jenis_label }}
                                </span>

                            </td>

                            <td class="text-center font-bold">
                                {{ $r->jumlah }}
                            </td>

                            <td class="text-center text-gray-500">
                                {{ $r->stok_sebelum }}
                            </td>

                            <td class="text-center font-semibold">
                                {{ $r->stok_sesudah }}
                            </td>

                            <td class="text-sm text-gray-500">
                                {{ $r->keterangan ?? '-' }}
                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

        @endif

    </div>

</div>

@endsection