@if (session('success'))
    <div class="mb-5 rounded border border-green-500 bg-green-50 px-4 py-3 text-sm font-semibold text-green-800">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="mb-5 rounded border border-red-500 bg-red-50 px-4 py-3 text-sm font-semibold text-red-700">
        {{ session('error') }}
    </div>
@endif

@if ($errors->any())
    <div class="mb-5 rounded border border-red-500 bg-red-50 px-4 py-3 text-sm font-semibold text-red-700">
        {{ $errors->first() }}
    </div>
@endif
