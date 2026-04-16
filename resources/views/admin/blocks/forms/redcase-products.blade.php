@php
    $categories = \App\Models\ProductCategory::orderBy('sort_order')->get(['id','name']);
    $allProducts = \App\Models\Product::orderBy('sort_order')->get(['id','name']);
@endphp
<div class="space-y-3" x-data="{ d: {{ json_encode(array_merge(['title'=>'Nuestros Productos','subtitle'=>'','source'=>'all','category_id'=>null,'product_ids'=>[]], $data)) }} }">
    <div class="grid grid-cols-2 gap-3">
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">Título</label>
            <input type="text" x-model="d.title" class="w-full rounded border-gray-300 text-sm">
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">Fuente</label>
            <select x-model="d.source" class="w-full rounded border-gray-300 text-sm">
                <option value="all">Todos los productos activos</option>
                <option value="category">Por categoría</option>
                <option value="manual">Selección manual</option>
            </select>
        </div>
    </div>
    <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Subtítulo</label>
        <input type="text" x-model="d.subtitle" class="w-full rounded border-gray-300 text-sm">
    </div>

    <div x-show="d.source === 'category'">
        <label class="block text-xs font-medium text-gray-600 mb-1">Categoría</label>
        <select x-model.number="d.category_id" class="w-full rounded border-gray-300 text-sm">
            <option :value="null">— Elegí una categoría —</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
            @endforeach
        </select>
    </div>

    <div x-show="d.source === 'manual'">
        <label class="block text-xs font-medium text-gray-600 mb-1">Productos (Ctrl/Cmd+click para seleccionar múltiples)</label>
        <select x-model="d.product_ids" multiple size="8" class="w-full rounded border-gray-300 text-sm">
            @foreach($allProducts as $p)
                <option value="{{ $p->id }}">{{ $p->name }}</option>
            @endforeach
        </select>
    </div>

    <input type="hidden" :name="'block_data_' + blockId" :value="JSON.stringify(d)">
</div>
