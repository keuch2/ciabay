@extends('layouts.admin', ['title' => 'Mensaje de ' . $contact->name])

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-4">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-gray-500">Nombre</p>
                <p class="font-medium">{{ $contact->name }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Email</p>
                <p class="font-medium"><a href="mailto:{{ $contact->email }}" class="text-blue-600">{{ $contact->email }}</a></p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Teléfono</p>
                <p class="font-medium">{{ $contact->phone ?? '-' }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Fecha</p>
                <p class="font-medium">{{ $contact->created_at->format('d/m/Y H:i') }}</p>
            </div>
        </div>
        @if($contact->subject)
        <div>
            <p class="text-sm text-gray-500">Asunto</p>
            <p class="font-medium">{{ $contact->subject }}</p>
        </div>
        @endif
        <div>
            <p class="text-sm text-gray-500">Mensaje</p>
            <div class="mt-1 p-4 bg-gray-50 rounded-lg text-gray-700">{{ $contact->message }}</div>
        </div>
        <hr>
        <form action="{{ route('admin.contacts.status', $contact) }}" method="POST" class="flex items-center gap-4">
            @csrf @method('PATCH')
            <select name="status" class="rounded-lg border-gray-300 shadow-sm text-sm">
                <option value="new" {{ $contact->status === 'new' ? 'selected' : '' }}>Nuevo</option>
                <option value="read" {{ $contact->status === 'read' ? 'selected' : '' }}>Leído</option>
                <option value="replied" {{ $contact->status === 'replied' ? 'selected' : '' }}>Respondido</option>
            </select>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700">Actualizar</button>
        </form>
    </div>
    <div class="mt-4">
        <a href="{{ route('admin.contacts.index') }}" class="text-sm text-gray-500 hover:text-gray-700">&larr; Volver</a>
    </div>
</div>
@endsection
