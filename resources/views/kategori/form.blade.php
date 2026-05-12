@extends('layouts.app')

@section('title', $title)

@section('content')

<div class="max-w-3xl mx-auto">

    {{-- ══════════════════════════════════════
         HEADER
    ══════════════════════════════════════ --}}
    <div class="flex flex-col sm:flex-row
                items-start sm:items-center
                justify-between gap-4 mb-6">

        <div class="flex items-center gap-3">

            <a href="{{ route('kategori.index') }}"
               class="btn-secondary btn-sm">

                <i class="bi bi-arrow-left"></i>
                Kembali

            </a>

            <div>

                <h1 class="text-2xl font-bold text-gray-800">
                    {{ $title }}
                </h1>

                <p class="text-sm text-gray-500 mt-1">
                    Tambahkan atau ubah kategori barang.
                </p>

            </div>

        </div>

    </div>

    {{-- ══════════════════════════════════════
         FORM
    ══════════════════════════════════════ --}}
    <div class="card">

        <div class="card-body">

            <form method="POST"
                  action="{{ $kategori
                        ? route('kategori.update', $kategori->id_kategori)
                        : route('kategori.store') }}"
                  class="space-y-5">

                @csrf

                @if($kategori)
                    @method('PUT')
                @endif

                {{-- NAMA KATEGORI --}}
                <div>

                    <label class="form-label">

                        Nama kategori
                        <span class="text-red-500">*</span>

                    </label>

                    <input type="text"
                           name="nama_kategori"
                           class="form-control"
                           value="{{ old('nama_kategori', $kategori->nama_kategori ?? '') }}"
                           placeholder="Ayam"
                           required>

                    @error('nama_kategori')

                        <div class="text-sm text-red-600 mt-1">
                            {{ $message }}
                        </div>

                    @enderror

                </div>

                {{-- DESKRIPSI --}}
                <div>

                    <label class="form-label">
                        Deskripsi
                    </label>

                    <textarea name="deskripsi"
                              rows="4"
                              class="form-control"
                              placeholder="Produk berbahan dasar ayam beku...">{{ old('deskripsi', $kategori->deskripsi ?? '') }}</textarea>

                </div>

                {{-- ACTION --}}
                <div class="flex justify-end gap-3 pt-2">

                    <a href="{{ route('kategori.index') }}"
                       class="btn-secondary">

                        <i class="bi bi-x-lg"></i>
                        Batal

                    </a>

                    <button type="submit"
                            class="btn-primary">

                        <i class="bi bi-floppy"></i>
                        Simpan Kategori

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection