@extends('layouts.admin', ['title' => 'Configuración de Catálogos'])

@section('content')
<form action="{{ route('admin.catalog-config.update') }}" method="POST" class="max-w-4xl">
    @csrf @method('PUT')

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 rounded-lg mb-6 text-sm">
        Estos valores son los <strong>defaults globales</strong> para todos los catálogos de marcas. Cada marca puede sobrescribir columnas, paginación y CSS/JS desde su propio dashboard en <code class="bg-white/60 px-1 rounded">Marcas → [marca] → Catálogo</code>.
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
        <h3 class="text-sm font-semibold text-gray-800 uppercase tracking-wider mb-4">Grilla (defaults)</h3>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Columnas</label>
                <input type="number" name="catalog_columns_default" min="1" max="6" required
                       value="{{ old('catalog_columns_default', $columns) }}"
                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                <p class="text-xs text-gray-500 mt-1">Entre 1 y 6.</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Productos por página</label>
                <input type="number" name="catalog_per_page_default" min="1" max="100" required
                       value="{{ old('catalog_per_page_default', $perPage) }}"
                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                <p class="text-xs text-gray-500 mt-1">Entre 1 y 100.</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
        <h3 class="text-sm font-semibold text-gray-800 uppercase tracking-wider mb-1">CSS global del catálogo</h3>
        <p class="text-xs text-gray-500 mb-3">Se aplica a todas las páginas de catálogo de todas las marcas. Cada marca puede agregar CSS adicional desde su dashboard.</p>
        <textarea name="catalog_custom_css_default" rows="12"
                  class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-xs font-mono"
                  placeholder=".brand-catalog-card { border-radius: 16px; }">{{ old('catalog_custom_css_default', $customCss) }}</textarea>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
        <h3 class="text-sm font-semibold text-gray-800 uppercase tracking-wider mb-1">JavaScript global del catálogo</h3>
        <p class="text-xs text-gray-500 mb-3">Se aplica a todas las páginas de catálogo.</p>
        <textarea name="catalog_custom_js_default" rows="10"
                  class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-xs font-mono"
                  placeholder="">{{ old('catalog_custom_js_default', $customJs) }}</textarea>
    </div>

    <div class="flex items-center gap-3">
        <button type="submit" class="bg-blue-600 text-white px-6 py-2.5 rounded-lg text-sm font-medium hover:bg-blue-700">
            Guardar configuración
        </button>
    </div>
</form>
@endsection
