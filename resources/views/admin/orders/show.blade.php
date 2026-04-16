@extends('layouts.admin', ['title' => 'Pedido #' . $order->id])

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-4">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-gray-500">Cliente</p>
                <p class="font-medium">{{ $order->customer_name }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Teléfono</p>
                <p class="font-medium">{{ $order->customer_phone }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Email</p>
                <p class="font-medium">{{ $order->customer_email ?? '-' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Producto</p>
                <p class="font-medium">{{ $order->product?->name ?? 'Eliminado' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Fecha</p>
                <p class="font-medium">{{ $order->created_at->format('d/m/Y H:i') }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">WhatsApp enviado</p>
                <p class="font-medium">{{ $order->whatsapp_sent_at?->format('d/m/Y H:i') ?? '-' }}</p>
            </div>
        </div>
        @if($order->message)
            <div>
                <p class="text-sm text-gray-500">Mensaje</p>
                <p class="mt-1 text-gray-700">{{ $order->message }}</p>
            </div>
        @endif
        <hr>
        <form action="{{ route('admin.orders.status', $order) }}" method="POST" class="flex items-center gap-4">
            @csrf @method('PATCH')
            <select name="status" class="rounded-lg border-gray-300 shadow-sm text-sm">
                <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pendiente</option>
                <option value="contacted" {{ $order->status === 'contacted' ? 'selected' : '' }}>Contactado</option>
                <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completado</option>
            </select>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700">Actualizar Estado</button>
        </form>
    </div>
    <div class="mt-4">
        <a href="{{ route('admin.orders.index') }}" class="text-sm text-gray-500 hover:text-gray-700">&larr; Volver a pedidos</a>
    </div>
</div>
@endsection
