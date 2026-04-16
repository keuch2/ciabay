@extends('layouts.admin', ['title' => 'Contactos'])

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Asunto</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($contacts as $contact)
                <tr class="hover:bg-gray-50 {{ $contact->status === 'new' ? 'bg-blue-50' : '' }}">
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $contact->name }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $contact->email }}</td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $contact->subject ?: Str::limit($contact->message, 40) }}</td>
                    <td class="px-6 py-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            {{ $contact->status === 'new' ? 'bg-green-100 text-green-800' : ($contact->status === 'read' ? 'bg-gray-100 text-gray-800' : 'bg-blue-100 text-blue-800') }}">
                            {{ ['new' => 'Nuevo', 'read' => 'Leído', 'replied' => 'Respondido'][$contact->status] }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $contact->created_at->format('d/m/Y H:i') }}</td>
                    <td class="px-6 py-4 text-right text-sm">
                        <a href="{{ route('admin.contacts.show', $contact) }}" class="text-blue-600 hover:text-blue-800 mr-3">Ver</a>
                        <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="px-6 py-8 text-center text-gray-500">No hay mensajes de contacto.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">{{ $contacts->links() }}</div>
@endsection
