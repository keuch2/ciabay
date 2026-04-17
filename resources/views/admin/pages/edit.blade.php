@extends('layouts.admin', ['title' => 'Editar: ' . $page->title])

@section('content')
@php
    $previewUrl = $page->is_homepage ? url('/') : url($page->slug);
@endphp
<div class="flex items-center justify-end gap-3 mb-4 text-sm">
    <span class="text-gray-500">Estado: <strong class="{{ $page->status === 'published' ? 'text-green-700' : 'text-amber-700' }}">{{ $page->status === 'published' ? 'Publicada' : 'Borrador' }}</strong></span>
    <a href="{{ $previewUrl }}" target="_blank" rel="noopener" class="inline-flex items-center gap-1.5 bg-gray-800 text-white px-3 py-1.5 rounded-lg text-xs font-medium hover:bg-gray-700">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
        Vista previa en nueva pestaña
    </a>
</div>
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Page Settings (sidebar) -->
    <div class="lg:col-span-1 order-2 lg:order-1">
        <form action="{{ route('admin.pages.update', $page) }}" method="POST">
            @csrf @method('PUT')
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-4">
                <h3 class="font-semibold text-gray-800 text-sm uppercase tracking-wider">Configuración</h3>

                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Título *</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $page->title) }}" required
                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                </div>

                <div>
                    <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
                    <input type="text" name="slug" id="slug" value="{{ old('slug', $page->slug) }}" required
                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                </div>

                <div>
                    <label for="template" class="block text-sm font-medium text-gray-700 mb-1">Template</label>
                    <select name="template" id="template" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                        <option value="">Por defecto (bloques)</option>
                        <option value="contact" {{ old('template', $page->template) === 'contact' ? 'selected' : '' }}>Contacto</option>
                        <option value="store" {{ old('template', $page->template) === 'store' ? 'selected' : '' }}>Tienda</option>
                    </select>
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                    <select name="status" id="status" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                        <option value="draft" {{ old('status', $page->status) === 'draft' ? 'selected' : '' }}>Borrador</option>
                        <option value="published" {{ old('status', $page->status) === 'published' ? 'selected' : '' }}>Publicada</option>
                    </select>
                </div>

                <label class="flex items-center gap-2">
                    <input type="hidden" name="is_homepage" value="0">
                    <input type="checkbox" name="is_homepage" value="1" {{ old('is_homepage', $page->is_homepage) ? 'checked' : '' }}
                           class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <span class="text-sm text-gray-700">Página de inicio</span>
                </label>

                <hr class="border-gray-200">
                <h3 class="font-semibold text-gray-800 text-sm uppercase tracking-wider">SEO</h3>

                <div>
                    <label for="meta_title" class="block text-sm font-medium text-gray-700 mb-1">Meta Title</label>
                    <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title', $page->meta_title) }}"
                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                </div>

                <div>
                    <label for="meta_description" class="block text-sm font-medium text-gray-700 mb-1">Meta Description</label>
                    <textarea name="meta_description" id="meta_description" rows="2"
                              class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">{{ old('meta_description', $page->meta_description) }}</textarea>
                </div>

                <hr class="border-gray-200">
                <h3 class="font-semibold text-gray-800 text-sm uppercase tracking-wider">Código personalizado</h3>
                <p class="text-xs text-gray-500 -mt-2">Sólo se aplica a esta página. Para código global use Admin → Código.</p>

                <div>
                    <label for="custom_css" class="block text-sm font-medium text-gray-700 mb-1">CSS</label>
                    <textarea name="custom_css" id="custom_css" rows="6"
                              class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-xs font-mono"
                              placeholder=".hero { background: #000; }">{{ old('custom_css', $page->custom_css) }}</textarea>
                </div>

                <div>
                    <label for="custom_js" class="block text-sm font-medium text-gray-700 mb-1">JavaScript</label>
                    <textarea name="custom_js" id="custom_js" rows="6"
                              class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-xs font-mono"
                              placeholder="">{{ old('custom_js', $page->custom_js) }}</textarea>
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2.5 rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors">
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>

    <!-- Block Editor (main) -->
    <div class="lg:col-span-2 order-1 lg:order-2">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-semibold text-gray-800">Bloques de contenido</h3>
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" type="button"
                        class="inline-flex items-center gap-2 bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-green-700 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Agregar Bloque
                </button>
                <div x-show="open" @click.away="open = false" x-transition
                     class="absolute right-0 mt-2 w-72 bg-white rounded-lg shadow-lg border border-gray-200 z-50 max-h-96 overflow-y-auto">
                    @foreach($blockTypes as $type => $label)
                        <button type="button" @click="addBlock('{{ $type }}', '{{ $label }}'); open = false"
                                class="w-full text-left px-4 py-2.5 text-sm hover:bg-gray-50 border-b border-gray-100 last:border-0">
                            {{ $label }}
                        </button>
                    @endforeach
                </div>
            </div>
        </div>

        <div id="blocks-container" class="space-y-4">
            @foreach($page->blocks as $block)
                <div class="block-item bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden" data-block-id="{{ $block->id }}">
                    <div class="flex items-center justify-between px-4 py-3 bg-gray-50 border-b border-gray-200 cursor-move block-handle">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"/></svg>
                            <span class="text-sm font-medium text-gray-700">{{ $blockTypes[$block->type] ?? $block->type }}</span>
                            <span class="text-xs text-gray-400">#{{ $block->id }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <button type="button" onclick="toggleBlockEdit({{ $block->id }})" class="text-blue-600 hover:text-blue-800 text-xs font-medium">Editar</button>
                            <button type="button" onclick="deleteBlock({{ $page->id }}, {{ $block->id }})" class="text-red-600 hover:text-red-800 text-xs font-medium">Eliminar</button>
                        </div>
                    </div>
                    <div id="block-edit-{{ $block->id }}" class="p-4 hidden" x-data="{ blockId: {{ $block->id }} }">
                        <div class="block-data-editor">
                            @if(view()->exists('admin.blocks.forms.' . $block->type))
                                @include('admin.blocks.forms.' . $block->type, ['data' => $block->data ?? []])
                            @else
                                <textarea id="block-data-{{ $block->id }}" rows="8"
                                          class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm font-mono">{{ json_encode($block->data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</textarea>
                            @endif
                        </div>
                        <div class="mt-3 flex items-center gap-2">
                            <button type="button" onclick="saveBlock({{ $page->id }}, {{ $block->id }})"
                                    class="bg-blue-600 text-white px-3 py-1.5 rounded-lg text-xs font-medium hover:bg-blue-700 transition-colors">
                                Guardar Bloque
                            </button>
                            <span id="block-status-{{ $block->id }}" class="text-xs text-gray-500"></span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if($page->blocks->isEmpty())
            <div id="empty-blocks" class="bg-gray-50 rounded-xl border-2 border-dashed border-gray-300 p-12 text-center">
                <svg class="w-12 h-12 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                <p class="text-gray-500 mb-2">Esta página no tiene bloques todavía.</p>
                <p class="text-sm text-gray-400">Usá el botón "Agregar Bloque" para comenzar a construir el contenido.</p>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.6/Sortable.min.js"></script>
<script>
const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
const pageId = {{ $page->id }};
const assetBase = @json(rtrim(asset(''), '/'));
const blockEndpoints = {
    store: @json(route('admin.pages.blocks.store', $page)),
    reorder: @json(route('admin.pages.blocks.reorder', $page)),
    item: (blockId) => @json(url('admin/pages/'.$page->id.'/blocks').'/') + blockId,
    upload: @json(route('admin.media.upload')),
};

async function parseResponse(r) {
    const text = await r.text();
    try { return { ok: r.ok, status: r.status, data: JSON.parse(text) }; }
    catch (e) { return { ok: false, status: r.status, data: { message: `Error ${r.status}: respuesta no-JSON` } }; }
}

// SortableJS for drag & drop
const container = document.getElementById('blocks-container');
if (container) {
    Sortable.create(container, {
        handle: '.block-handle',
        animation: 150,
        onEnd: function() {
            const order = [...container.querySelectorAll('.block-item')].map(el => parseInt(el.dataset.blockId));
            fetch(blockEndpoints.reorder, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
                body: JSON.stringify({ order })
            });
        }
    });
}

function toggleBlockEdit(blockId) {
    const el = document.getElementById('block-edit-' + blockId);
    el.classList.toggle('hidden');
}

async function saveBlock(pageId, blockId) {
    const status = document.getElementById('block-status-' + blockId);
    const hiddenInput = document.querySelector(`[name="block_data_${blockId}"]`);
    const textarea = document.getElementById('block-data-' + blockId);
    let data;
    try {
        if (hiddenInput) {
            data = JSON.parse(hiddenInput.value);
        } else if (textarea) {
            data = JSON.parse(textarea.value);
        } else {
            status.textContent = 'No se encontró editor';
            status.className = 'text-xs text-red-600';
            return;
        }
    } catch (e) {
        status.textContent = 'JSON inválido';
        status.className = 'text-xs text-red-600';
        return;
    }
    status.textContent = 'Guardando...';
    status.className = 'text-xs text-gray-500';

    const res = await parseResponse(await fetch(blockEndpoints.item(blockId), {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
        body: JSON.stringify({ data })
    }));
    if (res.ok && res.data.success) {
        status.textContent = 'Guardado ✓';
        status.className = 'text-xs text-green-600';
    } else {
        status.textContent = res.data.message || 'Error al guardar';
        status.className = 'text-xs text-red-600';
    }
}

async function deleteBlock(pageId, blockId) {
    if (!confirm('¿Eliminar este bloque?')) return;
    const res = await parseResponse(await fetch(blockEndpoints.item(blockId), {
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
    }));
    if (res.ok && res.data.success) {
        document.querySelector(`[data-block-id="${blockId}"]`).remove();
    } else {
        alert(res.data.message || 'Error al eliminar bloque');
    }
}

async function addBlock(type, label) {
    const res = await parseResponse(await fetch(blockEndpoints.store, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
        body: JSON.stringify({ type, data: {} })
    }));
    if (res.ok && res.data.success) {
        location.reload();
    } else {
        alert(res.data.message || 'Error al crear bloque');
    }
}

// Alpine component for image upload widgets
document.addEventListener('alpine:init', () => {
    Alpine.data('imageUploader', () => ({
        uploading: false,
        error: '',
        previewUrl(value) {
            if (!value) return '';
            if (/^(https?:)?\/\//.test(value) || value.startsWith('data:')) return value;
            const clean = value.replace(/^\/+/, '');
            // Prefix with app base URL so relative paths (assets/..., storage/...) work under a path-prefixed deploy
            return assetBase + '/' + clean;
        },
        async upload(event, setValue) {
            const file = event.target.files[0];
            if (!file) return;
            this.uploading = true;
            this.error = '';
            const fd = new FormData();
            fd.append('files[]', file);
            fd.append('folder', 'uploads');
            try {
                const r = await fetch(blockEndpoints.upload, {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
                    body: fd,
                });
                const res = await parseResponse(r);
                if (res.ok && res.data.success) {
                    setValue(res.data.files[0].url);
                } else {
                    this.error = res.data.message || 'Error al subir';
                }
            } catch (e) {
                this.error = 'Error de red al subir';
            } finally {
                this.uploading = false;
                event.target.value = '';
            }
        },
    }));
});
</script>
@endpush
@endsection
