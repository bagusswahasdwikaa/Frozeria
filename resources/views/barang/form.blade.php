@extends('layouts.app')

@section('title', $title)

@section('content')

<div class="max-w-6xl mx-auto">

    {{-- HEADER --}}
    <div class="flex flex-col sm:flex-row
                items-start sm:items-center
                justify-between gap-4 mb-6">

        <div class="flex items-center gap-3">

            <a href="{{ route('barang.index') }}"
               class="btn-secondary btn-sm">

                <i class="bi bi-arrow-left"></i>
                Kembali

            </a>

            <div>

                <h1 class="text-2xl font-bold text-gray-800">
                    {{ $title }}
                </h1>

                <p class="text-sm text-gray-500 mt-1">
                    Lengkapi informasi barang dengan benar.
                </p>

            </div>

        </div>

    </div>

    {{-- FORM --}}
    <form method="POST"
          action="{{ $barang
                ? route('barang.update', $barang->id_barang)
                : route('barang.store') }}"
          enctype="multipart/form-data"
          class="space-y-6">

        @csrf

        @if($barang)
            @method('PUT')
        @endif

        {{-- FOTO BARANG --}}
        <div class="card">

            <div class="card-body">

                <div class="mb-4">

                    <h2 class="text-lg font-bold text-gray-800">
                        Foto Barang
                    </h2>

                    <p class="text-sm text-gray-500 mt-1">
                        Upload foto produk agar lebih mudah dikenali.
                    </p>

                </div>

                {{-- BOX FOTO --}}
                <div id="fotoBox"
                     onclick="document.getElementById('inputFoto').click()"
                     class="foto-upload-box cursor-pointer border-2 border-dashed border-gray-300 rounded-xl p-6 text-center transition hover:border-blue-500">

                    <div id="fotoPreviewWrap">

                        @if($barang && $barang->foto)

                            <img src="{{ $barang->foto_url }}"
                                 class="foto-preview mx-auto mb-3 max-h-64 object-contain rounded-lg"
                                 id="fotoPreview"
                                 alt="Foto barang"
                                 onerror="this.onerror=null;this.src='{{ asset('images/no-image.png') }}';">

                            <div class="text-sm text-gray-500">
                                Klik untuk mengganti foto
                            </div>

                        @else

                            <div id="emptyFotoState"
                                 class="flex flex-col items-center">

                                <i class="bi bi-image text-5xl text-gray-400 mb-3"></i>

                                <div class="text-sm text-gray-600">
                                    Klik atau seret foto ke sini
                                </div>

                                <div class="text-xs text-gray-400 mt-1">
                                    JPG, JPEG, PNG — Maksimal 2MB
                                </div>

                                <button type="button"
                                        class="btn-primary btn-sm mt-4">

                                    <i class="bi bi-upload"></i>
                                    Pilih Foto

                                </button>

                            </div>

                        @endif

                    </div>

                </div>

                {{-- INPUT FILE --}}
                <input type="file"
                       id="inputFoto"
                       name="foto"
                       accept="image/jpg,image/jpeg,image/png"
                       class="hidden"
                       onchange="previewFoto(this)">

                {{-- HAPUS FOTO --}}
                @if($barang && $barang->foto)

                    <label class="flex items-center gap-2 mt-4 cursor-pointer">

                        <input type="checkbox"
                               id="hapusFotoCheckbox"
                               name="hapus_foto"
                               value="1"
                               class="rounded border-gray-300">

                        <span class="text-sm text-red-600">
                            Hapus foto saat ini
                        </span>

                    </label>

                @endif

                {{-- ERROR --}}
                @error('foto')

                    <div class="text-sm text-red-600 mt-2">
                        {{ $message }}
                    </div>

                @enderror

            </div>

        </div>

        {{-- DATA BARANG --}}
        <div class="card">

            <div class="card-body">

                <div class="mb-5">

                    <h2 class="text-lg font-bold text-gray-800">
                        Informasi Barang
                    </h2>

                    <p class="text-sm text-gray-500 mt-1">
                        Data utama produk frozen food.
                    </p>

                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                    {{-- NAMA --}}
                    <div class="md:col-span-2">

                        <label class="form-label">
                            Nama barang
                            <span class="text-red-500">*</span>
                        </label>

                        <input type="text"
                               name="nama_barang"
                               class="form-control"
                               value="{{ old('nama_barang', $barang->nama_barang ?? '') }}"
                               placeholder="Ayam nugget crispy"
                               required>

                        @error('nama_barang')
                            <div class="text-sm text-red-600 mt-1">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    {{-- KATEGORI --}}
                    <div>

                        <label class="form-label">
                            Kategori
                            <span class="text-red-500">*</span>
                        </label>

                        <select name="id_kategori"
                                class="form-control"
                                required>

                            <option value="">
                                Pilih kategori
                            </option>

                            @foreach($kategori as $kat)

                                <option value="{{ $kat->id_kategori }}"
                                    {{ old('id_kategori',
                                        $barang->id_kategori ?? '') == $kat->id_kategori
                                        ? 'selected'
                                        : '' }}>

                                    {{ $kat->nama_kategori }}

                                </option>

                            @endforeach

                        </select>

                        @error('id_kategori')
                            <div class="text-sm text-red-600 mt-1">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    {{-- SATUAN --}}
                    <div>

                        <label class="form-label">
                            Satuan Stok
                            <span class="text-red-500">*</span>
                        </label>

                        <input type="text"
                               name="satuan"
                               class="form-control"
                               value="{{ old('satuan', $barang->satuan ?? 'pcs') }}"
                               placeholder="pcs"
                               required>

                    </div>

                    {{-- STOK --}}
                    <div>

                        <label class="form-label">
                            Jumlah stok
                            <span class="text-red-500">*</span>
                        </label>

                        <input type="number"
                               name="stok"
                               min="0"
                               class="form-control"
                               value="{{ old('stok', $barang->stok ?? 0) }}"
                               placeholder="120"
                               required>

                    </div>

                    {{-- STOK MINIMUM --}}
                    <div>

                        <label class="form-label">
                            Stok minimum
                        </label>

                        <input type="number"
                               name="stok_minimum"
                               min="0"
                               class="form-control"
                               value="{{ old('stok_minimum', $barang->stok_minimum ?? 5) }}"
                               placeholder="20">

                    </div>

                    {{-- HARGA JUAL --}}
                    <div>

                        <label class="form-label">
                            Harga jual (Rp)
                        </label>

                        <input type="number"
                               name="harga_jual"
                               min="0"
                               class="form-control"
                               value="{{ old('harga_jual', $barang->harga_jual ?? 0) }}"
                               placeholder="35000">

                    </div>

                    {{-- HARGA BELI --}}
                    <div>

                        <label class="form-label">
                            Harga beli (Rp)
                        </label>

                        <input type="number"
                               name="harga_beli"
                               min="0"
                               class="form-control"
                               value="{{ old('harga_beli', $barang->harga_beli ?? 0) }}"
                               placeholder="28000">

                    </div>

                    {{-- BERAT --}}
                    <div>

                        <label class="form-label">
                            Berat / ukuran
                        </label>

                        <input type="text"
                               name="berat_ukuran"
                               class="form-control"
                               value="{{ old('berat_ukuran', $barang->berat_ukuran ?? '') }}"
                               placeholder="500 gram">

                    </div>

                    {{-- LOKASI --}}
                    <div>

                        <label class="form-label">
                            Lokasi simpan
                        </label>

                        <input type="text"
                               name="lokasi_simpan"
                               class="form-control"
                               value="{{ old('lokasi_simpan', $barang->lokasi_simpan ?? '') }}"
                               placeholder="Rak A-3">

                    </div>

                    {{-- SUHU --}}
                    <div>

                        <label class="form-label">
                            Suhu simpan
                        </label>

                        <input type="text"
                               name="suhu_simpan"
                               class="form-control"
                               value="{{ old('suhu_simpan', $barang->suhu_simpan ?? '-18°C') }}"
                               placeholder="-18°C">

                    </div>

                    {{-- KADALUARSA --}}
                    <div>

                        <label class="form-label">
                            Tanggal kadaluarsa
                        </label>

                        <input type="date"
                               name="tanggal_kadaluarsa"
                               class="form-control"
                               value="{{ old(
                                   'tanggal_kadaluarsa',
                                   $barang && $barang->tanggal_kadaluarsa
                                        ? $barang->tanggal_kadaluarsa->format('Y-m-d')
                                        : ''
                               ) }}">

                    </div>

                    {{-- DESKRIPSI --}}
                    <div class="md:col-span-2">

                        <label class="form-label">
                            Deskripsi
                        </label>

                        <textarea name="deskripsi"
                                  rows="4"
                                  class="form-control"
                                  placeholder="Deskripsi singkat tentang produk...">{{ old('deskripsi', $barang->deskripsi ?? '') }}</textarea>

                    </div>

                </div>

            </div>

        </div>

        {{-- ACTION --}}
        <div class="flex justify-end gap-3 pb-10">

            <a href="{{ route('barang.index') }}"
               class="btn-secondary">

                <i class="bi bi-x-lg"></i>
                Batal

            </a>

            <button type="submit"
                    class="btn-primary">

                <i class="bi bi-floppy"></i>
                Simpan Barang

            </button>

        </div>

    </form>

</div>

@endsection

@push('scripts')
<script>

function renderEmptyFotoState() {

    return `
        <div id="emptyFotoState"
             class="flex flex-col items-center">

            <i class="bi bi-image text-5xl text-gray-400 mb-3"></i>

            <div class="text-sm text-gray-600">
                Klik atau seret foto ke sini
            </div>

            <div class="text-xs text-gray-400 mt-1">
                JPG, JPEG, PNG — Maksimal 2MB
            </div>

            <button type="button"
                    class="btn-primary btn-sm mt-4">

                <i class="bi bi-upload"></i>
                Pilih Foto

            </button>

        </div>
    `;
}

function previewFoto(input) {

    if (input.files && input.files[0]) {

        const reader = new FileReader();

        reader.onload = function (e) {

            const wrap =
                document.getElementById('fotoPreviewWrap');

            wrap.innerHTML = `
                <img src="${e.target.result}"
                     class="foto-preview mx-auto mb-3 max-h-64 object-contain rounded-lg"
                     id="fotoPreview"
                     alt="Preview Foto">

                <div class="text-sm text-gray-500">
                    Klik untuk mengganti foto
                </div>
            `;

            const hapusCheckbox =
                document.getElementById('hapusFotoCheckbox');

            if (hapusCheckbox) {
                hapusCheckbox.checked = false;
            }
        };

        reader.readAsDataURL(input.files[0]);
    }
}

// DRAG & DROP
const fotoBox = document.getElementById('fotoBox');

if (fotoBox) {

    fotoBox.addEventListener('dragover', (e) => {

        e.preventDefault();

        fotoBox.classList.add('border-blue-500');
    });

    fotoBox.addEventListener('dragleave', () => {

        fotoBox.classList.remove('border-blue-500');
    });

    fotoBox.addEventListener('drop', (e) => {

        e.preventDefault();

        fotoBox.classList.remove('border-blue-500');

        const file = e.dataTransfer.files[0];

        if (file && file.type.startsWith('image/')) {

            const input =
                document.getElementById('inputFoto');

            const dt = new DataTransfer();

            dt.items.add(file);

            input.files = dt.files;

            previewFoto(input);
        }
    });
}

// HAPUS FOTO
const hapusCheckbox =
    document.getElementById('hapusFotoCheckbox');

if (hapusCheckbox) {

    hapusCheckbox.addEventListener('change', function () {

        const wrap =
            document.getElementById('fotoPreviewWrap');

        if (this.checked) {

            wrap.innerHTML = renderEmptyFotoState();

            document.getElementById('inputFoto').value = '';

        }
    });
}

</script>
@endpush