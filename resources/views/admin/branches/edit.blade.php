@extends('layouts.admin', ['title' => 'Editar Sucursal: ' . $branch->name])

@section('content')
<div class="max-w-3xl">
    <form action="{{ route('admin.branches.update', $branch) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        @include('admin.branches._form')
        <div class="mt-6 flex items-center gap-4">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2.5 rounded-lg text-sm font-medium hover:bg-blue-700">Guardar Cambios</button>
            <a href="{{ route('admin.branches.index') }}" class="text-sm text-gray-500 hover:text-gray-700">Cancelar</a>
        </div>
    </form>
</div>
@endsection
