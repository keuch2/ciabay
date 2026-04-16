@extends('layouts.admin', ['title' => 'Editar Navegación: ' . $navigation->name])

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Add Item Form -->
    <div class="lg:col-span-1">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h3 class="font-semibold text-gray-800 text-sm uppercase tracking-wider mb-4">Agregar Item</h3>
            <form id="addItemForm" class="space-y-4">
                <div>
                    <label for="label" class="block text-sm font-medium text-gray-700 mb-1">Etiqueta *</label>
                    <input type="text" name="label" id="label" required
                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                </div>
                <div>
                    <label for="url" class="block text-sm font-medium text-gray-700 mb-1">URL</label>
                    <input type="text" name="url" id="url" placeholder="/ruta o https://..."
                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                </div>
                <div>
                    <label for="page_id" class="block text-sm font-medium text-gray-700 mb-1">O seleccionar Página</label>
                    <select name="page_id" id="page_id"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                        <option value="">Ninguna (usar URL)</option>
                        @foreach($pages as $page)
                            <option value="{{ $page->id }}">{{ $page->title }} (/{{ $page->slug }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="parent_id" class="block text-sm font-medium text-gray-700 mb-1">Padre</label>
                    <select name="parent_id" id="parent_id"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                        <option value="">Raíz (nivel principal)</option>
                        @foreach($navigation->items as $item)
                            <option value="{{ $item->id }}">{{ $item->label }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="target" class="block text-sm font-medium text-gray-700 mb-1">Target</label>
                    <select name="target" id="target"
                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                        <option value="_self">Misma ventana</option>
                        <option value="_blank">Nueva ventana</option>
                    </select>
                </div>
                <button type="submit" class="w-full bg-green-600 text-white px-4 py-2.5 rounded-lg text-sm font-medium hover:bg-green-700">
                    Agregar Item
                </button>
                <p id="addItemStatus" class="text-xs hidden"></p>
            </form>
        </div>
    </div>

    <!-- Current Items -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold text-gray-800 text-sm uppercase tracking-wider">Items actuales</h3>
                <span id="reorderStatus" class="text-xs text-gray-400"></span>
            </div>
            <p class="text-xs text-gray-500 mb-4">Arrastrá el ícono <svg class="inline w-4 h-4 -mt-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"/></svg> para reordenar items y sub-items.</p>

            <div id="nav-items-list" class="space-y-2 nav-sortable" data-parent-id="">
                @foreach($navigation->items as $item)
                    <div class="nav-item border border-gray-200 rounded-lg p-3" data-id="{{ $item->id }}" data-parent-id="">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-gray-400 cursor-move nav-handle" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"/></svg>
                                <span class="text-sm font-medium text-gray-700">{{ $item->label }}</span>
                                <span class="text-xs text-gray-400">{{ $item->url ?: ($item->page ? '/' . $item->page->slug : '') }}</span>
                            </div>
                            <button type="button" onclick="deleteNavItem({{ $navigation->id }}, {{ $item->id }}, this)"
                                    class="text-red-500 hover:text-red-700 text-xs">Eliminar</button>
                        </div>
                        <div class="ml-6 mt-2 space-y-2 nav-sortable-children" data-parent-id="{{ $item->id }}">
                            @foreach($item->children as $child)
                                <div class="nav-item border border-gray-100 rounded-lg p-2" data-id="{{ $child->id }}" data-parent-id="{{ $item->id }}">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-4 h-4 text-gray-400 cursor-move nav-handle" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"/></svg>
                                            <span class="text-sm text-gray-600">{{ $child->label }}</span>
                                            <span class="text-xs text-gray-400">{{ $child->url ?: ($child->page ? '/' . $child->page->slug : '') }}</span>
                                        </div>
                                        <button type="button" onclick="deleteNavItem({{ $navigation->id }}, {{ $child->id }}, this)"
                                                class="text-red-500 hover:text-red-700 text-xs">Eliminar</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            @if($navigation->items->isEmpty())
                <p class="text-center text-gray-500 text-sm py-8">No hay items en esta navegación.</p>
            @endif
        </div>
        <div class="mt-4">
            <a href="{{ route('admin.navigation.index') }}" class="text-sm text-gray-500 hover:text-gray-700">&larr; Volver a navegaciones</a>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.6/Sortable.min.js"></script>
<script>
const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
const navEndpoints = {
    storeItem: @json(route('admin.navigation.items.store', $navigation)),
    reorder:   @json(route('admin.navigation.reorder', $navigation)),
    item:      (id) => @json(url('admin/navigation/'.$navigation->id.'/items').'/') + id,
};

async function parseResponse(r) {
    const text = await r.text();
    try { return { ok: r.ok, status: r.status, data: JSON.parse(text) }; }
    catch (e) { return { ok: false, status: r.status, data: { message: `Error ${r.status}: respuesta no-JSON` } }; }
}

// ==================== Add Item ====================
document.getElementById('addItemForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const status = document.getElementById('addItemStatus');
    const form = new FormData(this);
    const data = Object.fromEntries(form.entries());
    if (!data.page_id) delete data.page_id;
    if (!data.parent_id) delete data.parent_id;
    if (!data.url) delete data.url;

    status.textContent = 'Guardando…';
    status.className = 'text-xs text-gray-500';
    status.classList.remove('hidden');

    const res = await parseResponse(await fetch(navEndpoints.storeItem, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
        body: JSON.stringify(data)
    }));
    if (res.ok && res.data.success) {
        location.reload();
    } else {
        status.textContent = res.data.message || 'Error al agregar item';
        status.className = 'text-xs text-red-600';
    }
});

// ==================== Delete Item ====================
async function deleteNavItem(navId, itemId, btn) {
    if (!confirm('¿Eliminar este item y sus sub-items?')) return;
    const res = await parseResponse(await fetch(navEndpoints.item(itemId), {
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' }
    }));
    if (res.ok && res.data.success) {
        btn.closest('.nav-item').remove();
    } else {
        alert(res.data.message || 'Error al eliminar item');
    }
}

// ==================== Reorder (SortableJS) ====================
function collectOrder() {
    const payload = [];
    // Top-level items
    document.querySelectorAll('#nav-items-list > .nav-item').forEach((el, idx) => {
        payload.push({ id: parseInt(el.dataset.id), parent_id: null, sort_order: idx });
    });
    // Children for each top-level item
    document.querySelectorAll('.nav-sortable-children').forEach((container) => {
        const parentId = parseInt(container.dataset.parentId);
        container.querySelectorAll(':scope > .nav-item').forEach((el, idx) => {
            payload.push({ id: parseInt(el.dataset.id), parent_id: parentId, sort_order: idx });
        });
    });
    return payload;
}

async function saveOrder() {
    const status = document.getElementById('reorderStatus');
    status.textContent = 'Guardando orden…';
    status.className = 'text-xs text-gray-400';
    const res = await parseResponse(await fetch(navEndpoints.reorder, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
        body: JSON.stringify({ order: collectOrder() })
    }));
    if (res.ok && res.data.success) {
        status.textContent = 'Orden guardado ✓';
        status.className = 'text-xs text-green-600';
        setTimeout(() => status.textContent = '', 2500);
    } else {
        status.textContent = res.data.message || 'Error al guardar orden';
        status.className = 'text-xs text-red-600';
    }
}

// Top-level sortable (note: avoid naming the var `top` — it collides with window.top)
const topList = document.getElementById('nav-items-list');
if (topList) {
    Sortable.create(topList, {
        handle: '.nav-handle',
        animation: 150,
        draggable: '.nav-item',
        filter: '.nav-sortable-children',
        preventOnFilter: false,
        // Only sort among direct children (not nested)
        group: { name: 'top', pull: false, put: false },
        onEnd: saveOrder,
    });
}

// Per-parent children sortables
document.querySelectorAll('.nav-sortable-children').forEach((container) => {
    Sortable.create(container, {
        handle: '.nav-handle',
        animation: 150,
        draggable: '.nav-item',
        group: { name: 'children-' + container.dataset.parentId, pull: false, put: false },
        onEnd: saveOrder,
    });
});
</script>
@endpush
@endsection
