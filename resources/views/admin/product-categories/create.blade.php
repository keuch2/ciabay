@extends('layouts.admin', ['title' => 'Nueva Categoría'])

@section('content')
<div class="max-w-2xl">
    <form action="{{ route('admin.product-categories.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('admin.product-categories._form')
        <div class="mt-6 flex items-center gap-4">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2.5 rounded-lg text-sm font-medium hover:bg-blue-700">Crear Categoría</button>
            <a href="{{ route('admin.product-categories.index') }}" class="text-sm text-gray-500 hover:text-gray-700">Cancelar</a>
        </div>
    </form>
</div>
@endsection
