@extends('layouts.admin', ['title' => 'Pedidos'])

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cliente</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Producto</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Teléfono</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($orders as $order)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $order->id }}</td>
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $order->customer_name }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $order->product?->name ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $order->customer_phone }}</td>
                    <td class="px-6 py-4">
                        <form action="{{ route('admin.orders.status', $order) }}" method="POST" class="inline">
                            @csrf @method('PATCH')
                            <select name="status" onchange="this.form.submit()"
                                    class="text-xs rounded-full border-0 py-1 px-3 font-medium
                                    {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : ($order->status === 'contacted' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') }}">
                                <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pendiente</option>
                                <option value="contacted" {{ $order->status === 'contacted' ? 'selected' : '' }}>Contactado</option>
                                <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completado</option>
                            </select>
                        </form>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    <td class="px-6 py-4 text-right text-sm">
                        <a href="{{ route('admin.orders.show', $order) }}" class="text-blue-600 hover:text-blue-800">Ver</a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="px-6 py-8 text-center text-gray-500">No hay pedidos.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $orders->links() }}</div>
@endsection
