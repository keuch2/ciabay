@extends('layouts.admin', ['title' => 'Marcas'])

@section('content')
<div class="flex items-center justify-between mb-6">
    <h2 class="text-lg font-semibold text-gray-700">Todas las marcas</h2>
    <a href="{{ route('admin.brands.create') }}" class="inline-flex items-center gap-2 bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Nueva Marca
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Logo</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tipo</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Catálogo</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($brands as $brand)
                @php
                    $img = $brand->logo;
                    $src = null;
                    if ($img) {
                        if (preg_match('#^(https?:)?//#', $img)) $src = $img;
                        elseif (str_starts_with($img, 'assets/') || str_starts_with($img, 'storage/')) $src = asset($img);
                        else $src = asset('storage/' . $img);
                    }
                @endphp
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        @if($src)
                            <img src="{{ $src }}" class="w-12 h-12 object-contain" alt="{{ $brand->name }}">
                        @else
                            <div class="w-12 h-12 bg-gray-100 rounded flex items-center justify-center text-gray-400 text-xs">N/A</div>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">
                        {{ $brand->name }}
                        <div class="text-xs text-gray-400 font-normal">/{{ $brand->slug }}</div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $brand->is_represented ? 'Representada' : 'Otra' }}</td>
                    <td class="px-6 py-4">
                        @if($brand->catalog_enabled)
                            <a href="{{ route('admin.brands.catalog.show', $brand) }}"
                               class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded text-xs font-medium bg-blue-600 text-white hover:bg-blue-700">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                                Gestionar ({{ $brand->catalog_categories_count ?? 0 }}/{{ $brand->catalog_products_count ?? 0 }})
                            </a>
                        @else
                            <a href="{{ route('admin.brands.edit', $brand) }}" class="text-xs text-gray-400 hover:text-gray-600">Habilitar</a>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $brand->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $brand->is_active ? 'Activa' : 'Inactiva' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right text-sm">
                        <a href="{{ route('admin.brands.edit', $brand) }}" class="text-blue-600 hover:text-blue-800 mr-3">Editar</a>
                        <form action="{{ route('admin.brands.destroy', $brand) }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="px-6 py-8 text-center text-gray-500">No hay marcas.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
