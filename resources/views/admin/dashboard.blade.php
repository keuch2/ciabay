@extends('layouts.admin', ['title' => 'Dashboard'])

@section('content')
<!-- Stats Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Páginas</p>
                <p class="text-2xl font-bold text-gray-800">{{ $stats['pages'] }}</p>
            </div>
            <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Contactos nuevos</p>
                <p class="text-2xl font-bold text-gray-800">{{ $stats['contacts_new'] }}</p>
            </div>
            <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Pedidos pendientes</p>
                <p class="text-2xl font-bold text-gray-800">{{ $stats['orders_pending'] }}</p>
            </div>
            <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Posts publicados</p>
                <p class="text-2xl font-bold text-gray-800">{{ $stats['posts'] }}</p>
            </div>
            <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Recent Contacts -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-800">Últimos contactos</h2>
            <a href="{{ route('admin.contacts.index') }}" class="text-sm text-blue-600 hover:underline">Ver todos</a>
        </div>
        <div class="divide-y divide-gray-100">
            @forelse($recentContacts as $contact)
                <div class="p-4 flex items-center justify-between">
                    <div class="min-w-0">
                        <p class="text-sm font-medium text-gray-800 truncate">{{ $contact->name }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ $contact->subject ?: Str::limit($contact->message, 50) }}</p>
                    </div>
                    <span class="ml-3 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                        {{ $contact->status === 'new' ? 'bg-green-100 text-green-800' : ($contact->status === 'read' ? 'bg-gray-100 text-gray-800' : 'bg-blue-100 text-blue-800') }}">
                        {{ $contact->status }}
                    </span>
                </div>
            @empty
                <div class="p-6 text-center text-gray-500 text-sm">Sin contactos recientes</div>
            @endforelse
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-800">Últimos pedidos</h2>
            <a href="{{ route('admin.orders.index') }}" class="text-sm text-blue-600 hover:underline">Ver todos</a>
        </div>
        <div class="divide-y divide-gray-100">
            @forelse($recentOrders as $order)
                <div class="p-4 flex items-center justify-between">
                    <div class="min-w-0">
                        <p class="text-sm font-medium text-gray-800 truncate">{{ $order->customer_name }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ $order->product?->name ?? 'Producto eliminado' }}</p>
                    </div>
                    <span class="ml-3 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                        {{ $order->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : ($order->status === 'contacted' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') }}">
                        {{ $order->status }}
                    </span>
                </div>
            @empty
                <div class="p-6 text-center text-gray-500 text-sm">Sin pedidos recientes</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
