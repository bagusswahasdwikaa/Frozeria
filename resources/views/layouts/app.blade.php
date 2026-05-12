<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') – Frozeria Stok</title>

    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('frozen.png') }}">

    {{-- Tailwind + JS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    @stack('styles')
</head>
<body class="bg-gray-50">

{{-- ════════════════════════════════════════
     NAVBAR
════════════════════════════════════════ --}}
@include('layouts.partials.header')

{{-- ════════════════════════════════════════
     FLASH MESSAGES
════════════════════════════════════════ --}}
<div class="fixed top-16 right-4 z-[9999]
            w-full max-w-sm space-y-2">

    @if(session('success'))
        <div class="alert alert-success shadow-xl animate-fade-in"
             id="alert-success">

            <i class="bi bi-check-circle-fill text-lg"></i>

            <span class="flex-1">
                {{ session('success') }}
            </span>

            <button onclick="this.closest('.alert').remove()"
                    class="ml-auto opacity-70 hover:opacity-100">

                <i class="bi bi-x-lg"></i>

            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error shadow-xl animate-fade-in"
             id="alert-error">

            <i class="bi bi-exclamation-triangle-fill text-lg"></i>

            <span class="flex-1">
                {{ session('error') }}
            </span>

            <button onclick="this.closest('.alert').remove()"
                    class="ml-auto opacity-70 hover:opacity-100">

                <i class="bi bi-x-lg"></i>

            </button>
        </div>
    @endif

    @if(session('warning'))
        <div class="alert alert-warning shadow-xl animate-fade-in"
             id="alert-warning">

            <i class="bi bi-exclamation-circle-fill text-lg"></i>

            <span class="flex-1">
                {{ session('warning') }}
            </span>

            <button onclick="this.closest('.alert').remove()"
                    class="ml-auto opacity-70 hover:opacity-100">

                <i class="bi bi-x-lg"></i>

            </button>
        </div>
    @endif

    @if(session('info'))
        <div class="alert alert-info shadow-xl animate-fade-in"
             id="alert-info">

            <i class="bi bi-info-circle-fill text-lg"></i>

            <span class="flex-1">
                {{ session('info') }}
            </span>

            <button onclick="this.closest('.alert').remove()"
                    class="ml-auto opacity-70 hover:opacity-100">

                <i class="bi bi-x-lg"></i>

            </button>
        </div>
    @endif

</div>

{{-- ════════════════════════════════════════
     MAIN CONTENT
════════════════════════════════════════ --}}
<main class="w-full px-4 pb-16 pt-20">
    @yield('content')
</main>

{{-- ════════════════════════════════════════
     MODAL KONFIRMASI HAPUS
════════════════════════════════════════ --}}
<div id="modalHapus"
     class="hidden fixed inset-0 z-[99999]
            flex items-center justify-center
            bg-black/60 backdrop-blur-sm">

    <div class="bg-white rounded-2xl shadow-2xl
                w-full max-w-md mx-4 overflow-hidden
                animate-modal">

        {{-- Header --}}
        <div class="bg-amber-50 border-b border-amber-300
                    px-6 py-4 flex items-center gap-2">

            <i class="bi bi-exclamation-triangle-fill
                      text-amber-500 text-xl"></i>

            <h5 class="text-gray-800 text-base font-semibold">
                Hapus barang?
            </h5>

        </div>

        {{-- Body --}}
        <div class="px-6 py-5">
            <p class="text-gray-700 text-sm leading-relaxed">
                Data
                <strong id="namaHapus"></strong>
                akan dihapus secara permanen dari sistem.
                Tindakan ini tidak dapat dibatalkan.
            </p>
        </div>

        {{-- Footer --}}
        <div class="px-6 pb-5 flex justify-end gap-3">

            <button type="button"
                    id="btnBatalHapus"
                    class="btn-secondary">

                <i class="bi bi-x-lg"></i>
                Batal

            </button>

            <form id="formHapus" method="POST">
                @csrf
                @method('DELETE')

                <button type="submit"
                        class="btn-danger">

                    <i class="bi bi-trash3"></i>
                    Ya, Hapus

                </button>
            </form>

        </div>

    </div>

</div>

{{-- ════════════════════════════════════════
     SCRIPT
════════════════════════════════════════ --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    const modal = document.getElementById('modalHapus');
    const namaEl = document.getElementById('namaHapus');
    const formEl = document.getElementById('formHapus');
    const btnBatal = document.getElementById('btnBatalHapus');

    // OPEN MODAL
    document.querySelectorAll('[data-hapus-url]').forEach(function (btn) {

        btn.addEventListener('click', function () {

            namaEl.textContent = btn.getAttribute('data-hapus-nama');
            formEl.action = btn.getAttribute('data-hapus-url');

            modal.classList.remove('hidden');

            document.body.classList.add('overflow-hidden');
        });

    });

    // CLOSE MODAL
    function tutupModal() {

        modal.classList.add('hidden');

        document.body.classList.remove('overflow-hidden');
    }

    btnBatal.addEventListener('click', tutupModal);

    modal.addEventListener('click', function (e) {

        if (e.target === modal) {
            tutupModal();
        }

    });

    // ESC KEY CLOSE
    document.addEventListener('keydown', function (e) {

        if (e.key === 'Escape') {
            tutupModal();
        }

    });

    // AUTO DISMISS ALERT
    [
        'alert-success',
        'alert-error',
        'alert-warning',
        'alert-info'
    ].forEach(function (id) {

        const el = document.getElementById(id);

        if (el) {

            setTimeout(() => {

                el.classList.add('opacity-0', 'translate-x-5');

                setTimeout(() => {
                    el.remove();
                }, 300);

            }, 4000);

        }

    });

});
</script>

@stack('scripts')

</body>
</html>