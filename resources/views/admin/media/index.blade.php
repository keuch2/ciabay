@extends('layouts.admin', ['title' => 'Media'])

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h2 class="text-lg font-semibold text-gray-800">Biblioteca de Media</h2>
        <p class="text-sm text-gray-500">Archivos subidos desde el admin y recursos originales del sitio.</p>
    </div>
    <form action="{{ route('admin.media.upload') }}" method="POST" enctype="multipart/form-data" class="flex items-center gap-3">
        @csrf
        <input type="file" name="files[]" multiple accept="image/*,.pdf,.doc,.docx"
               class="text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-700">Subir</button>
    </form>
</div>

@php
    $uploads = $files->where('source', 'upload');
    $assets = $files->where('source', 'asset');
@endphp

<div x-data="{ tab: 'all', q: '' }" class="space-y-6">
    <div class="flex items-center gap-3 border-b border-gray-200">
        @foreach([
            ['all', 'Todo (' . $files->count() . ')'],
            ['upload', 'Subidos (' . $uploads->count() . ')'],
            ['asset', 'Assets del sitio (' . $assets->count() . ')'],
        ] as [$key, $label])
            <button type="button" @click="tab = '{{ $key }}'"
                    :class="tab === '{{ $key }}' ? 'text-blue-600 border-blue-600' : 'text-gray-500 border-transparent hover:text-gray-700'"
                    class="px-3 py-2 text-sm font-medium border-b-2 -mb-px transition-colors">
                {{ $label }}
            </button>
        @endforeach
        <input type="search" x-model="q" placeholder="Buscar por nombre de archivo…"
               class="ml-auto rounded-lg border-gray-300 text-sm w-64 mb-1">
    </div>

    @if($files->count())
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
            @foreach($files as $file)
                @php
                    $isImage = in_array(strtolower($file['extension']), ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg']);
                @endphp
                <div x-show="(tab === 'all' || tab === '{{ $file['source'] }}') && (q === '' || '{{ addslashes(strtolower($file['path'])) }}'.includes(q.toLowerCase()))"
                     class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden group relative">
                    @if($isImage)
                        <div class="w-full bg-gray-50" style="aspect-ratio: 1/1;">
                            <img src="{{ $file['url'] }}" alt="" class="w-full h-full object-contain">
                        </div>
                    @else
                        <div class="w-full flex items-center justify-center bg-gray-100" style="aspect-ratio: 1/1;">
                            <span class="text-xs font-mono text-gray-400 uppercase">{{ $file['extension'] }}</span>
                        </div>
                    @endif

                    <div class="p-2">
                        <p class="text-xs text-gray-700 truncate font-medium" title="{{ $file['path'] }}">{{ basename($file['path']) }}</p>
                        <div class="flex items-center justify-between mt-0.5">
                            <span class="text-xs text-gray-400">{{ number_format($file['size'] / 1024, 1) }} KB</span>
                            @if($file['source'] === 'asset')
                                <span class="text-[10px] bg-gray-100 text-gray-600 px-1.5 py-0.5 rounded">asset</span>
                            @else
                                <span class="text-[10px] bg-blue-100 text-blue-700 px-1.5 py-0.5 rounded">upload</span>
                            @endif
                        </div>
                    </div>

                    <div class="absolute top-1.5 right-1.5 opacity-0 group-hover:opacity-100 transition-opacity flex gap-1">
                        <button type="button"
                                onclick="navigator.clipboard.writeText('{{ $file['path'] }}');this.textContent='✓';setTimeout(()=>this.textContent='Copiar ruta',1200)"
                                class="bg-white rounded px-2 py-1 text-[10px] font-medium shadow border border-gray-200">Copiar ruta</button>
                        @if($file['source'] === 'upload')
                            <form action="{{ route('admin.media.destroy') }}" method="POST" onsubmit="return confirm('¿Eliminar este archivo?')">
                                @csrf @method('DELETE')
                                <input type="hidden" name="path" value="{{ $file['path'] }}">
                                <button type="submit" class="bg-white rounded px-2 py-1 text-[10px] font-medium shadow border border-gray-200 text-red-600">Eliminar</button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="bg-gray-50 rounded-xl border-2 border-dashed border-gray-300 p-12 text-center">
            <p class="text-gray-500">No hay archivos todavía. Subí archivos usando el formulario de arriba.</p>
        </div>
    @endif
</div>
@endsection
