@extends('layouts.admin', ['title' => 'Editar producto: ' . $product->name])

@section('content')
<div class="max-w-4xl">
    <div class="flex items-center justify-between mb-4">
        <div class="text-sm text-gray-500">
            <a href="{{ route('admin.brands.catalog.show', $brand) }}" class="text-blue-600 hover:text-blue-800">← Catálogo {{ $brand->name }}</a>
        </div>
        <a href="{{ url('catalogo/' . $brand->slug . '/' . $product->slug) }}" target="_blank" rel="noopener"
           class="inline-flex items-center gap-1.5 bg-gray-800 text-white px-3 py-1.5 rounded-lg text-xs font-medium hover:bg-gray-700">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
            Vista previa
        </a>
    </div>
    <h2 class="text-lg font-semibold text-gray-800 mb-4">Editar producto: {{ $product->name }}</h2>
    <form action="{{ route('admin.brands.catalog.products.update', [$brand, $product]) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        @include('admin.brands.catalog.products._form')
        <div class="mt-6 flex items-center gap-4">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2.5 rounded-lg text-sm font-medium hover:bg-blue-700">Guardar cambios</button>
            <a href="{{ route('admin.brands.catalog.show', $brand) }}" class="text-sm text-gray-500 hover:text-gray-700">Cancelar</a>
        </div>
    </form>
</div>
@endsection
