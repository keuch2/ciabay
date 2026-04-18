@php
    $categories = \App\Models\ProductCategory::orderBy('sort_order')->get(['id','name']);
    $allProducts = \App\Models\Product::orderBy('sort_order')->get(['id','name']);
@endphp
@php
    $categories = \App\Models\ProductCategory::with('children')->roots()->orderBy('sort_order')->get(['id','name']);
    $allProducts = \App\Models\Product::orderBy('sort_order')->get(['id','name']);
    $defaults = ['title'=>'Nuestros Productos','subtitle'=>'','source'=>'all','category_id'=>null,'product_ids'=>[],'show_category_filter'=>false,'show_price'=>false,'per_page'=>null];
@endphp
<div class="space-y-3" x-data="{ d: {{ json_encode(array_merge($defaults, $data)) }} }">
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
                @if($cat->children->count())
                    <optgroup label="{{ $cat->name }}">
                        <option value="{{ $cat->id }}">{{ $cat->name }} (general)</option>
                        @foreach($cat->children->sortBy('sort_order') as $child)
                            <option value="{{ $child->id }}">{{ $child->name }}</option>
                        @endforeach
                    </optgroup>
                @else
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endif
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

    <div class="grid grid-cols-3 gap-3 pt-2 border-t border-gray-100">
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">Productos por página <span class="text-gray-400">(vacío = config global)</span></label>
            <input type="number" x-model.number="d.per_page" min="1" max="100" placeholder="Global"
                   class="w-full rounded border-gray-300 text-sm">
        </div>
        <div class="flex items-end pb-1">
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" x-model="d.show_category_filter" class="rounded border-gray-300 text-blue-600">
                <span class="text-xs font-medium text-gray-600">Mostrar filtros de categoría</span>
            </label>
        </div>
        <div class="flex items-end pb-1">
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" x-model="d.show_price" class="rounded border-gray-300 text-blue-600">
                <span class="text-xs font-medium text-gray-600">Mostrar precios en el listado</span>
            </label>
        </div>
    </div>

    <input type="hidden" :name="'block_data_' + blockId" :value="JSON.stringify(d)">
</div>
