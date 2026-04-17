@extends('layouts.admin', ['title' => 'Código global'])

@section('content')
<form action="{{ route('admin.code.update') }}" method="POST" class="max-w-4xl">
    @csrf @method('PUT')

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-amber-50 border border-amber-200 text-amber-800 px-4 py-3 rounded-lg mb-6 text-sm">
        <p class="font-semibold mb-1">Atención</p>
        <p>Este CSS y JS se inyecta en <strong>todas las páginas públicas del sitio</strong>. Úselo para ajustes rápidos de estilo o scripts globales que complementen al tema. Para códigos de tracking (GA, Meta Pixel, GTM) use la sección <a href="{{ route('admin.tracking.edit') }}" class="underline">Seguimiento</a>.</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
        <h3 class="text-sm font-semibold text-gray-800 uppercase tracking-wider mb-1">CSS global</h3>
        <p class="text-xs text-gray-500 mb-3">Se inserta como <code class="bg-gray-100 px-1 rounded">&lt;style&gt;</code> en el <code class="bg-gray-100 px-1 rounded">&lt;head&gt;</code> después del tema. Escriba CSS puro, sin etiquetas <code>&lt;style&gt;</code>.</p>
        <textarea name="global_custom_css" rows="14"
                  class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-xs font-mono"
                  placeholder=".main-header { border-bottom: 2px solid var(--color-primary); }&#10;&#10;.btn-cta { text-transform: uppercase; letter-spacing: 0.08em; }">{{ old('global_custom_css', $globalCss) }}</textarea>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
        <h3 class="text-sm font-semibold text-gray-800 uppercase tracking-wider mb-1">JavaScript global</h3>
        <p class="text-xs text-gray-500 mb-3">Se inserta como <code class="bg-gray-100 px-1 rounded">&lt;script&gt;</code> antes del cierre de <code class="bg-gray-100 px-1 rounded">&lt;/body&gt;</code>. Escriba JS puro, sin etiquetas <code>&lt;script&gt;</code>.</p>
        <textarea name="global_custom_js" rows="14"
                  class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-xs font-mono"
                  placeholder="document.addEventListener('DOMContentLoaded', function() {&#10;  // custom behavior&#10;});">{{ old('global_custom_js', $globalJs) }}</textarea>
    </div>

    <div class="flex items-center gap-3">
        <button type="submit" class="bg-blue-600 text-white px-6 py-2.5 rounded-lg text-sm font-medium hover:bg-blue-700">
            Guardar código global
        </button>
        <a href="{{ url('/') }}" target="_blank" rel="noopener" class="text-sm text-blue-600 hover:text-blue-800">Ver sitio público →</a>
    </div>
</form>
@endsection
