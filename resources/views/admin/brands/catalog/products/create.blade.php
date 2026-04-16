@extends('layouts.admin', ['title' => 'Nuevo producto - ' . $brand->name])

@section('content')
<div class="max-w-4xl">
    <div class="text-sm text-gray-500 mb-4">
        <a href="{{ route('admin.brands.catalog.show', $brand) }}" class="text-blue-600 hover:text-blue-800">← Catálogo {{ $brand->name }}</a>
    </div>
    <h2 class="text-lg font-semibold text-gray-800 mb-4">Nuevo producto</h2>
    <form action="{{ route('admin.brands.catalog.products.store', $brand) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('admin.brands.catalog.products._form')
        <div class="mt-6 flex items-center gap-4">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2.5 rounded-lg text-sm font-medium hover:bg-blue-700">Crear producto</button>
            <a href="{{ route('admin.brands.catalog.show', $brand) }}" class="text-sm text-gray-500 hover:text-gray-700">Cancelar</a>
        </div>
    </form>
</div>
@endsection
