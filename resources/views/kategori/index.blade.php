@extends('layouts.app')

@section('title', 'Kategori')

@section('navbar-right')
    <a href="{{ route('kategori.create') }}"
       class="btn-primary btn-sm">
        <i class="bi bi-plus-lg"></i>
        Tambah Kategori
    </a>
@endsection

@section('content')

{{-- ══════════════════════════════════════
     HEADER
══════════════════════════════════════ --}}
<div class="mb-5">
    <h1 class="text-2xl font-bold text-gray-800">
        Daftar Kategori
    </h1>

    <p class="text-sm text-gray-500 mt-1">
        Kelola kategori barang Frozeria.
    </p>
</div>

{{-- ══════════════════════════════════════
     SEARCH
══════════════════════════════════════ --}}
<form method="GET"
      action="{{ route('kategori.index') }}"
      class="mb-5">

    <div class="flex flex-col sm:flex-row gap-3 max-w-xl">

        <div class="flex flex-1">

            <input type="text"
                   name="search"
                   class="form-control rounded-r-none"
                   placeholder="Cari kategori..."
                   value="{{ $search }}">

            <button type="submit"
                    class="btn-primary rounded-l-none">
                <i class="bi bi-search"></i>
            </button>

            @if($search)

                <a href="{{ route('kategori.index') }}"
                   class="btn-secondary ml-2">
                    <i class="bi bi-x-lg"></i>
                </a>

            @endif

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
                    <th>Nama kategori</th>
                    <th class="text-center">Jumlah barang</th>
                    <th>Dibuat</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>

                @forelse($kategori as $i => $kat)

                <tr>

                    <td class="text-gray-500">
                        {{ $i + 1 }}
                    </td>

                    <td>

                        <div class="font-semibold text-gray-800">
                            {{ $kat->nama_kategori }}
                        </div>

                        @if($kat->deskripsi)

                            <div class="text-sm text-gray-500 mt-1">
                                {{ Str::limit($kat->deskripsi, 60) }}
                            </div>

                        @endif

                    </td>

                    <td class="text-center">

                        <span class="badge-info">
                            {{ $kat->barang_count }} barang
                        </span>

                    </td>

                    <td class="text-sm text-gray-500">
                        {{ $kat->created_at->format('d M Y') }}
                    </td>

                    <td>

                        <div class="flex flex-wrap justify-center gap-2">

                            {{-- Edit --}}
                            <a href="{{ route('kategori.edit', $kat->id_kategori) }}"
                               class="btn-secondary btn-sm">

                                <i class="bi bi-pencil"></i>
                                Edit

                            </a>

                            {{-- Hapus --}}
                            <button type="button"
                                    class="btn-danger btn-sm"
                                    data-hapus-nama="{{ $kat->nama_kategori }}"
                                    data-hapus-url="{{ route('kategori.destroy', $kat->id_kategori) }}">

                                <i class="bi bi-trash3"></i>
                                Hapus

                            </button>

                        </div>

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="5"
                        class="text-center py-10 text-gray-500">

                        <i class="bi bi-tags text-5xl block mb-3"></i>

                        Belum ada kategori.

                    </td>

                </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    {{-- FOOTER --}}
    <div class="border-t border-gray-200
                bg-white px-4 py-3
                flex items-center justify-between flex-wrap gap-3">

        <small class="text-gray-500">
            {{ $kategori->count() }} kategori terdaftar
        </small>

        @if(method_exists($kategori, 'links'))
            <div>
                {{ $kategori->links() }}
            </div>
        @endif

    </div>

</div>

@endsection