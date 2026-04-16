@extends('layouts.admin', ['title' => 'Nueva categoría - ' . $brand->name])

@section('content')
<div class="max-w-3xl">
    <div class="text-sm text-gray-500 mb-4">
        <a href="{{ route('admin.brands.catalog.show', $brand) }}" class="text-blue-600 hover:text-blue-800">← Catálogo {{ $brand->name }}</a>
    </div>
    <h2 class="text-lg font-semibold text-gray-800 mb-4">Nueva categoría</h2>
    <form action="{{ route('admin.brands.catalog.categories.store', $brand) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('admin.brands.catalog.categories._form')
        <div class="mt-6 flex items-center gap-4">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2.5 rounded-lg text-sm font-medium hover:bg-blue-700">Crear categoría</button>
            <a href="{{ route('admin.brands.catalog.show', $brand) }}" class="text-sm text-gray-500 hover:text-gray-700">Cancelar</a>
        </div>
    </form>
</div>
@endsection
