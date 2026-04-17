@extends('layouts.admin', ['title' => 'Configuración de Tienda'])

@section('content')
<form action="{{ route('admin.store-config.update') }}" method="POST" class="max-w-4xl">
    @csrf @method('PUT')

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 rounded-lg mb-6 text-sm">
        Estos valores se aplican a <strong>la Tienda Online</strong> (<code class="bg-white/60 px-1 rounded">/tienda-online</code>) y al bloque <code class="bg-white/60 px-1 rounded">redcase-products</code>.
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
        <h3 class="text-sm font-semibold text-gray-800 uppercase tracking-wider mb-4">Grilla de productos</h3>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Columnas</label>
                <input type="number" name="store_columns" min="1" max="6" required
                       value="{{ old('store_columns', $columns) }}"
                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                <p class="text-xs text-gray-500 mt-1">Entre 1 y 6. En móvil se reduce automáticamente.</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Productos por página</label>
                <input type="number" name="store_per_page" min="1" max="100" required
                       value="{{ old('store_per_page', $perPage) }}"
                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                <p class="text-xs text-gray-500 mt-1">Entre 1 y 100.</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
        <h3 class="text-sm font-semibold text-gray-800 uppercase tracking-wider mb-1">CSS de la tienda</h3>
        <p class="text-xs text-gray-500 mb-3">Sólo se aplica en páginas de la tienda (<code class="bg-gray-100 px-1 rounded">/tienda-online</code> y sus productos).</p>
        <textarea name="store_custom_css" rows="12"
                  class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-xs font-mono"
                  placeholder=".redcase-product-card { border-radius: 16px; }">{{ old('store_custom_css', $customCss) }}</textarea>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
        <h3 class="text-sm font-semibold text-gray-800 uppercase tracking-wider mb-1">JavaScript de la tienda</h3>
        <p class="text-xs text-gray-500 mb-3">Sólo se aplica en páginas de la tienda.</p>
        <textarea name="store_custom_js" rows="10"
                  class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-xs font-mono"
                  placeholder="">{{ old('store_custom_js', $customJs) }}</textarea>
    </div>

    <div class="flex items-center gap-3">
        <button type="submit" class="bg-blue-600 text-white px-6 py-2.5 rounded-lg text-sm font-medium hover:bg-blue-700">
            Guardar configuración
        </button>
        <a href="{{ url('/tienda-online') }}" target="_blank" rel="noopener" class="text-sm text-blue-600 hover:text-blue-800">Ver tienda →</a>
    </div>
</form>
@endsection
