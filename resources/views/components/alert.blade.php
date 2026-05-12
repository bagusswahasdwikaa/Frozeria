@if(session('success'))
<div class="bg-green-100 text-green-700 p-4 rounded-xl mb-5">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="bg-red-100 text-red-700 p-4 rounded-xl mb-5">
    {{ session('error') }}
</div>
@endif