@extends('layouts.admin', ['title' => 'Editar categoría: ' . $category->name])

@section('content')
<div class="max-w-3xl">
    <div class="text-sm text-gray-500 mb-4">
        <a href="{{ route('admin.brands.catalog.show', $brand) }}" class="text-blue-600 hover:text-blue-800">← Catálogo {{ $brand->name }}</a>
    </div>
    <h2 class="text-lg font-semibold text-gray-800 mb-4">Editar categoría: {{ $category->name }}</h2>
    <form action="{{ route('admin.brands.catalog.categories.update', [$brand, $category]) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        @include('admin.brands.catalog.categories._form')
        <div class="mt-6 flex items-center gap-4">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2.5 rounded-lg text-sm font-medium hover:bg-blue-700">Guardar cambios</button>
            <a href="{{ route('admin.brands.catalog.show', $brand) }}" class="text-sm text-gray-500 hover:text-gray-700">Cancelar</a>
        </div>
    </form>
</div>
@endsection
