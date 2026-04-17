@extends('layouts.admin', ['title' => 'Catálogo: ' . $brand->name])

@section('content')
@php
    $resolveImg = function($img) {
        if (!$img) return null;
        if (preg_match('#^(https?:)?//#', $img)) return $img;
        if (str_starts_with($img, 'assets/') || str_starts_with($img, 'storage/')) return asset($img);
        return asset('storage/' . $img);
    };
    $heroSrc = $resolveImg($brand->catalog_hero_image);
    $logoSrc = $resolveImg($brand->logo);
@endphp

<div class="flex flex-wrap items-start justify-between gap-4 mb-6">
    <div class="flex items-center gap-4">
        @if($logoSrc)
            <img src="{{ $logoSrc }}" class="w-14 h-14 object-contain rounded-lg border border-gray-200 bg-white p-1" alt="">
        @endif
        <div>
            <h2 class="text-xl font-semibold text-gray-800">Catálogo de {{ $brand->name }}</h2>
            <div class="text-sm text-gray-500 flex items-center gap-3 mt-0.5">
                <span>Marca /{{ $brand->slug }}</span>
                @if($brand->catalog_enabled)
                    <span class="inline-flex items-center gap-1 text-green-700 font-medium">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="5"/></svg>
                        Catálogo habilitado
                    </span>
                @else
                    <span class="inline-flex items-center gap-1 text-amber-700 font-medium">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><circle cx="10" cy="10" r="5"/></svg>
                        Catálogo deshabilitado (no visible al público)
                    </span>
                @endif
            </div>
        </div>
    </div>
    <div class="flex items-center gap-2">
        <a href="{{ url('catalogo/' . $brand->slug) }}" target="_blank" rel="noopener"
           class="inline-flex items-center gap-1.5 bg-gray-800 text-white px-3 py-1.5 rounded-lg text-xs font-medium hover:bg-gray-700">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
            Vista previa
        </a>
        <a href="{{ route('admin.brands.edit', $brand) }}" class="text-sm text-blue-600 hover:text-blue-800">Editar marca</a>
        <a href="{{ route('admin.brands.index') }}" class="text-sm text-gray-500 hover:text-gray-700">← Volver</a>
    </div>
</div>

@if($heroSrc || $brand->catalog_intro)
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6 flex gap-4 p-4">
        @if($heroSrc)
            <img src="{{ $heroSrc }}" class="w-40 h-24 object-cover rounded-lg border border-gray-200" alt="">
        @endif
        <div class="flex-1">
            <p class="text-xs font-medium uppercase tracking-wider text-gray-500">Hero del catálogo</p>
            <p class="text-sm text-gray-700 mt-1">{{ $brand->catalog_intro ?: 'Sin texto de introducción.' }}</p>
        </div>
    </div>
@endif

@if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6 text-sm">
        {{ session('success') }}
    </div>
@endif

{{-- Per-brand catalog configuration (columns, pagination, custom CSS/JS) --}}
@php
    $defaultCols = (int) \App\Models\Setting::get('catalog_columns_default', 4);
    $defaultPerPage = (int) \App\Models\Setting::get('catalog_per_page_default', 12);
@endphp
<details class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6">
    <summary class="cursor-pointer p-4 flex items-center gap-2 font-semibold text-gray-800">
        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/></svg>
        Configuración del catálogo de esta marca
        <span class="text-xs font-normal text-gray-500 ml-2">(sobrescribe los defaults globales)</span>
    </summary>
    <form action="{{ route('admin.brands.catalog.config.update', $brand) }}" method="POST" class="px-4 pb-4 space-y-4">
        @csrf @method('PUT')

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Columnas</label>
                <input type="number" name="catalog_columns" min="1" max="6"
                       value="{{ old('catalog_columns', $brand->catalog_columns) }}"
                       placeholder="Default global: {{ $defaultCols }}"
                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                <p class="text-xs text-gray-500 mt-1">Dejar vacío para usar el default global ({{ $defaultCols }}).</p>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Productos por página</label>
                <input type="number" name="catalog_per_page" min="1" max="100"
                       value="{{ old('catalog_per_page', $brand->catalog_per_page) }}"
                       placeholder="Default global: {{ $defaultPerPage }}"
                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                <p class="text-xs text-gray-500 mt-1">Dejar vacío para usar el default global ({{ $defaultPerPage }}).</p>
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">CSS específico del catálogo de esta marca</label>
            <textarea name="catalog_custom_css" rows="8"
                      class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-xs font-mono"
                      placeholder=".brand-catalog-card { border-radius: 16px; }">{{ old('catalog_custom_css', $brand->catalog_custom_css) }}</textarea>
            <p class="text-xs text-gray-500 mt-1">Se aplica sólo a <code>/catalogo/{{ $brand->slug }}</code>. Se suma al CSS global de catálogo.</p>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">JavaScript específico del catálogo de esta marca</label>
            <textarea name="catalog_custom_js" rows="6"
                      class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-xs font-mono"
                      placeholder="">{{ old('catalog_custom_js', $brand->catalog_custom_js) }}</textarea>
        </div>

        <div class="flex items-center gap-3">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700">
                Guardar configuración
            </button>
            <a href="{{ route('admin.catalog-config.edit') }}" class="text-xs text-blue-600 hover:text-blue-800">Editar defaults globales →</a>
        </div>
    </form>
</details>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    {{-- Categories --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="flex items-center justify-between p-4 border-b border-gray-100">
            <div>
                <h3 class="font-semibold text-gray-800">Categorías ({{ $categories->count() }})</h3>
                <p class="text-xs text-gray-500">Agrupan los productos del catálogo.</p>
            </div>
            <a href="{{ route('admin.brands.catalog.categories.create', $brand) }}"
               class="inline-flex items-center gap-1.5 bg-blue-600 text-white px-3 py-1.5 rounded-lg text-xs font-medium hover:bg-blue-700">
                + Nueva categoría
            </a>
        </div>
        @if($categories->count())
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-xs uppercase tracking-wider text-gray-500">
                    <tr>
                        <th class="text-left px-4 py-2 font-medium">Nombre</th>
                        <th class="text-left px-4 py-2 font-medium">Productos</th>
                        <th class="text-left px-4 py-2 font-medium">Orden</th>
                        <th class="text-right px-4 py-2 font-medium">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($categories as $cat)
                        <tr>
                            <td class="px-4 py-2">
                                <div class="font-medium text-gray-800">{{ $cat->name }}</div>
                                <div class="text-xs text-gray-400 font-mono">/{{ $cat->slug }}</div>
                            </td>
                            <td class="px-4 py-2 text-gray-600">{{ $cat->products_count }}</td>
                            <td class="px-4 py-2 text-gray-600">{{ $cat->sort_order }}</td>
                            <td class="px-4 py-2 text-right text-xs">
                                <a href="{{ route('admin.brands.catalog.categories.edit', [$brand, $cat]) }}" class="text-blue-600 hover:text-blue-800 mr-2">Editar</a>
                                <form method="POST" action="{{ route('admin.brands.catalog.categories.destroy', [$brand, $cat]) }}" class="inline"
                                      onsubmit="return confirm('¿Eliminar esta categoría?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="p-8 text-center text-sm text-gray-500">Sin categorías todavía. Creá la primera para organizar los productos.</div>
        @endif
    </div>

    {{-- Products --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="flex items-center justify-between p-4 border-b border-gray-100">
            <div>
                <h3 class="font-semibold text-gray-800">Productos ({{ $products->count() }})</h3>
                <p class="text-xs text-gray-500">Las fichas que se muestran en el catálogo.</p>
            </div>
            <a href="{{ route('admin.brands.catalog.products.create', $brand) }}"
               class="inline-flex items-center gap-1.5 bg-blue-600 text-white px-3 py-1.5 rounded-lg text-xs font-medium hover:bg-blue-700">
                + Nuevo producto
            </a>
        </div>
        @if($products->count())
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-xs uppercase tracking-wider text-gray-500">
                    <tr>
                        <th class="text-left px-4 py-2 font-medium">Producto</th>
                        <th class="text-left px-4 py-2 font-medium">Categoría</th>
                        <th class="text-left px-4 py-2 font-medium">Estado</th>
                        <th class="text-right px-4 py-2 font-medium">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($products as $p)
                        @php $src = $resolveImg($p->image); @endphp
                        <tr>
                            <td class="px-4 py-2">
                                <div class="flex items-center gap-2">
                                    @if($src)
                                        <img src="{{ $src }}" class="w-10 h-10 object-cover rounded border border-gray-200" alt="">
                                    @else
                                        <div class="w-10 h-10 bg-gray-100 border border-gray-200 rounded"></div>
                                    @endif
                                    <div>
                                        <div class="font-medium text-gray-800">{{ $p->name }}</div>
                                        <div class="text-xs text-gray-400 font-mono">/{{ $p->slug }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-2 text-gray-600">{{ $p->category?->name ?? '—' }}</td>
                            <td class="px-4 py-2">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $p->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-700' }}">
                                    {{ $p->is_active ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            <td class="px-4 py-2 text-right text-xs">
                                <a href="{{ route('admin.brands.catalog.products.edit', [$brand, $p]) }}" class="text-blue-600 hover:text-blue-800 mr-2">Editar</a>
                                <form method="POST" action="{{ route('admin.brands.catalog.products.destroy', [$brand, $p]) }}" class="inline"
                                      onsubmit="return confirm('¿Eliminar este producto?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="p-8 text-center text-sm text-gray-500">Sin productos todavía.</div>
        @endif
    </div>
</div>
@endsection
