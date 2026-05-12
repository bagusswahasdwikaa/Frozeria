@extends('layouts.app')

@section('title', 'Dashboard – Daftar Barang')

@section('navbar-right')
    <a href="{{ route('barang.create') }}" class="btn-primary btn-sm">
        <i class="bi bi-plus-lg"></i>
        Tambah Barang
    </a>
@endsection

@section('content')

{{-- ══════════════════════════════════════
     CARD STATISTIK
══════════════════════════════════════ --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-5">

    <div class="card-stat border-l-4 border-blue-600">
        <div class="card-body">
            <div class="text-gray-500 text-sm mb-1">Total barang</div>
            <div class="card-value text-blue-600">
                {{ $totalBarang }}
            </div>
        </div>
    </div>

    <div class="card-stat border-l-4 border-cyan-500">
        <div class="card-body">
            <div class="text-gray-500 text-sm mb-1">Total kategori</div>
            <div class="card-value text-cyan-500">
                {{ $totalKategori }}
            </div>
        </div>
    </div>

    <div class="card-stat border-l-4 border-amber-500">
        <div class="card-body">
            <div class="text-gray-500 text-sm mb-1">Stok menipis</div>
            <div class="card-value text-amber-500">
                {{ $stokMenipis }}
            </div>
        </div>
    </div>

    <div class="card-stat border-l-4 border-red-600">
        <div class="card-body">
            <div class="text-gray-500 text-sm mb-1">Stok habis</div>
            <div class="card-value text-red-600">
                {{ $stokHabis }}
            </div>
        </div>
    </div>

</div>

{{-- ══════════════════════════════════════
     FILTER
══════════════════════════════════════ --}}
<form method="GET"
      action="{{ route('barang.index') }}"
      id="formFilter"
      class="mb-5">

    <div class="flex flex-col md:flex-row gap-3">

        {{-- Search --}}
        <div class="flex flex-1">

            <input type="text"
                   name="search"
                   id="inputSearch"
                   class="form-control rounded-r-none"
                   placeholder="Cari nama barang..."
                   value="{{ $search }}">

            <button type="submit"
                    class="btn-primary rounded-l-none">
                <i class="bi bi-search"></i>
                Cari
            </button>

            @if($search || $kategoriId)
                <a href="{{ route('barang.index') }}"
                   class="btn-secondary ml-2">
                    <i class="bi bi-x-lg"></i>
                </a>
            @endif

        </div>

        {{-- Filter kategori --}}
        <div class="w-full md:w-64">
            <select name="kategori"
                    class="form-control"
                    onchange="this.form.submit()">

                <option value="">Semua kategori</option>

                @foreach($semuaKategori as $kat)
                    <option value="{{ $kat->id_kategori }}"
                        {{ $kategoriId == $kat->id_kategori ? 'selected' : '' }}>
                        {{ $kat->nama_kategori }}
                    </option>
                @endforeach

            </select>
        </div>

    </div>

</form>

{{-- ══════════════════════════════════════
     TABLE
══════════════════════════════════════ --}}
<div class="card overflow-hidden">

    <div class="overflow-x-auto">

        <table class="table-barang">

            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama barang</th>
                    <th>Kategori</th>
                    <th class="text-center">Stok</th>
                    <th>Satuan</th>
                    <th>Harga jual</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>

                @forelse($barang as $i => $item)

                <tr>

                    <td class="text-gray-500">
                        {{ $barang->firstItem() + $i }}
                    </td>

                    <td class="font-semibold">
                        {{ $item->nama_barang }}
                    </td>

                    <td>
                        <span class="badge-kategori">
                            {{ $item->kategori->nama_kategori }}
                        </span>
                    </td>

                    <td class="text-center">

                        @php
                            $badgeClass = match($item->status_stok) {
                                'Habis'       => 'badge-stok-habis',
                                'Stok Rendah' => 'badge-stok-menipis',
                                default       => 'badge-stok-ok',
                            };
                        @endphp

                        <span class="{{ $badgeClass }}">
                            {{ $item->stok }}
                        </span>

                    </td>

                    <td>
                        {{ $item->satuan }}
                    </td>

                    <td>
                        {{ $item->harga_jual_format }}
                    </td>

                    <td>

                        <div class="flex flex-wrap justify-center gap-2">

                            {{-- Detail --}}
                            <a href="{{ route('barang.show', $item->id_barang) }}"
                               class="btn-secondary btn-sm">
                                <i class="bi bi-eye"></i>
                                Detail
                            </a>

                            {{-- Edit --}}
                            <a href="{{ route('barang.edit', $item->id_barang) }}"
                               class="btn-primary btn-sm">
                                <i class="bi bi-pencil"></i>
                                Edit
                            </a>

                            {{-- Hapus --}}
                            <button type="button"
                                    class="btn-danger btn-sm"
                                    data-hapus-nama="{{ $item->nama_barang }}"
                                    data-hapus-url="{{ route('barang.destroy', $item->id_barang) }}">

                                <i class="bi bi-trash3"></i>
                                Hapus

                            </button>

                        </div>

                    </td>

                </tr>

                @empty

                <tr>
                    <td colspan="7"
                        class="text-center py-10 text-gray-500">

                        <i class="bi bi-inbox text-5xl block mb-3"></i>

                        Tidak ada barang ditemukan.

                        @if($search || $kategoriId)

                            <a href="{{ route('barang.index') }}"
                               class="block mt-3 text-indigo-700 hover:underline">

                                Reset filter

                            </a>

                        @endif

                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    {{-- FOOTER --}}
    @if($barang->total() > 0)

    <div class="flex flex-col md:flex-row
                justify-between items-center
                gap-3 px-4 py-3 border-t border-gray-200 bg-white">

        <small class="text-gray-500">

            Menampilkan
            {{ $barang->firstItem() }}
            –
            {{ $barang->lastItem() }}

            dari

            {{ $barang->total() }}
            barang

        </small>

        <div>
            {{ $barang->links() }}
        </div>

    </div>

    @endif

</div>

@endsection