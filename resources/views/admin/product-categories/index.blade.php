@extends('layouts.admin', ['title' => 'Categorías de Productos'])

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-lg font-semibold text-gray-800">Categorías de Productos</h2>
        <p class="text-sm text-gray-500">Agrupan productos de la Tienda Online.</p>
    </div>
    <a href="{{ route('admin.product-categories.create') }}"
       class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700">
        + Nueva Categoría
    </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    @if($categories->count())
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="text-left px-4 py-3 font-medium text-gray-700">Nombre</th>
                    <th class="text-left px-4 py-3 font-medium text-gray-700">Slug</th>
                    <th class="text-left px-4 py-3 font-medium text-gray-700">Productos</th>
                    <th class="text-left px-4 py-3 font-medium text-gray-700">Orden</th>
                    <th class="text-right px-4 py-3 font-medium text-gray-700">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $cat)
                    <tr class="border-b border-gray-100 last:border-0">
                        <td class="px-4 py-3 font-medium text-gray-800">{{ $cat->name }}</td>
                        <td class="px-4 py-3 text-gray-500 font-mono text-xs">{{ $cat->slug }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $cat->products_count }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $cat->sort_order }}</td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('admin.product-categories.edit', $cat) }}" class="text-blue-600 hover:text-blue-800 text-xs font-medium">Editar</a>
                            <form method="POST" action="{{ route('admin.product-categories.destroy', $cat) }}" class="inline ml-3"
                                  onsubmit="return confirm('¿Eliminar esta categoría?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 text-xs font-medium">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="p-12 text-center text-gray-500">
            <p class="mb-2">No hay categorías todavía.</p>
            <p class="text-sm text-gray-400">Creá la primera para organizar los productos.</p>
        </div>
    @endif
</div>
@endsection
