@extends('layouts.admin', ['title' => 'Nueva Marca'])

@section('content')
<div class="max-w-3xl">
    <form action="{{ route('admin.brands.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('admin.brands._form', ['brand' => new \App\Models\Brand()])
        <div class="mt-6 flex items-center gap-4">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2.5 rounded-lg text-sm font-medium hover:bg-blue-700">Crear Marca</button>
            <a href="{{ route('admin.brands.index') }}" class="text-sm text-gray-500 hover:text-gray-700">Cancelar</a>
        </div>
    </form>
</div>
@endsection
