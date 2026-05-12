<aside class="w-64 bg-slate-900 text-white min-h-screen p-6">

    <h1 class="text-2xl font-bold mb-8">
        Frozeria
    </h1>

    <nav class="space-y-3">

        <a href="{{ route('barang.index') }}"
           class="block p-3 rounded-lg hover:bg-slate-800">
            Dashboard
        </a>

        <a href="{{ route('kategori.index') }}"
           class="block p-3 rounded-lg hover:bg-slate-800">
            Kategori
        </a>

        <a href="{{ route('bantuan.index') }}"
           class="block p-3 rounded-lg hover:bg-slate-800">
            Bantuan
        </a>

    </nav>

</aside>