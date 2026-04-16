@extends('layouts.admin', ['title' => 'Navegación'])

@section('content')
<div class="space-y-6">
    @forelse($navigations as $nav)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="font-semibold text-gray-800">{{ $nav->name }}</h3>
                    <p class="text-sm text-gray-500">Ubicación: <code class="bg-gray-100 px-2 py-0.5 rounded text-xs">{{ $nav->location }}</code></p>
                </div>
                <a href="{{ route('admin.navigation.edit', $nav) }}" class="inline-flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700">
                    Editar Items
                </a>
            </div>
            <div class="text-sm text-gray-600">
                {{ $nav->allItems->count() }} items
            </div>
        </div>
    @empty
        <div class="bg-gray-50 rounded-xl border-2 border-dashed border-gray-300 p-12 text-center">
            <p class="text-gray-500">No hay navegaciones creadas. Se crearán automáticamente con el seeder.</p>
        </div>
    @endforelse
</div>
@endsection
