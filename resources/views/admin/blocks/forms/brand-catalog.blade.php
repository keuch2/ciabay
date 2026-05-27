@php
    $brands = \App\Models\Brand::query()
        ->where(function ($q) {
            $q->where('catalog_enabled', true)->orWhereHas('catalogProducts');
        })
        ->orderBy('name')
        ->get(['id', 'name', 'slug', 'catalog_enabled']);

    $catsByBrand = \App\Models\CatalogCategory::orderBy('sort_order')->orderBy('name')
        ->get(['id', 'brand_id', 'name'])
        ->groupBy('brand_id')
        ->map(fn ($g) => $g->map(fn ($c) => ['id' => $c->id, 'name' => $c->name])->values())
        ->toArray();

    $prodsByBrand = \App\Models\CatalogProduct::orderBy('sort_order')->orderBy('name')
        ->get(['id', 'brand_id', 'name', 'code'])
        ->groupBy('brand_id')
        ->map(fn ($g) => $g->map(fn ($p) => [
            'id' => $p->id,
            'name' => $p->name . ($p->code ? ' (' . $p->code . ')' : ''),
        ])->values())
        ->toArray();

    $defaults = [
        'brand_id' => null,
        'source' => 'all',
        'category_ids' => [],
        'product_ids' => [],
        'title' => '',
        'subtitle' => '',
        'show_search' => true,
        'show_category_filter' => true,
        'per_page' => null,
        'columns' => null,
    ];
    $merged = array_merge($defaults, $data ?? []);
    // Normalise types so Alpine x-model works (json_encode preserves null vs [])
    $merged['category_ids'] = array_map('intval', (array) ($merged['category_ids'] ?? []));
    $merged['product_ids'] = array_map('intval', (array) ($merged['product_ids'] ?? []));
@endphp
<div class="space-y-3"
     x-data="{
         d: {{ json_encode($merged) }},
         brandsCats: {{ json_encode($catsByBrand, JSON_UNESCAPED_UNICODE) }},
         brandsProducts: {{ json_encode($prodsByBrand, JSON_UNESCAPED_UNICODE) }},
         get currentCats() { return this.brandsCats[this.d.brand_id] || []; },
         get currentProducts() { return this.brandsProducts[this.d.brand_id] || []; },
         onBrandChange() {
             // Clear stale category/product selections when brand changes.
             this.d.category_ids = [];
             this.d.product_ids = [];
         }
     }">

    <div class="grid grid-cols-2 gap-3">
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">Marca</label>
            <select x-model.number="d.brand_id" @change="onBrandChange()" class="w-full rounded border-gray-300 text-sm">
                <option :value="null">— Elegí una marca —</option>
                @foreach($brands as $brand)
                    <option value="{{ $brand->id }}">
                        {{ $brand->name }}@if(!$brand->catalog_enabled) (catálogo deshabilitado)@endif
                    </option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">Fuente</label>
            <select x-model="d.source" class="w-full rounded border-gray-300 text-sm">
                <option value="all">Todo el catálogo de la marca</option>
                <option value="category">Filtrar por categoría(s)</option>
                <option value="manual">Selección manual de productos</option>
            </select>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-3">
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">Título <span class="text-gray-400">(opcional)</span></label>
            <input type="text" x-model="d.title" class="w-full rounded border-gray-300 text-sm" placeholder="Ej. Catálogo Case IH">
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">Subtítulo <span class="text-gray-400">(opcional)</span></label>
            <input type="text" x-model="d.subtitle" class="w-full rounded border-gray-300 text-sm">
        </div>
    </div>

    <div x-show="d.source === 'category'" x-cloak>
        <label class="block text-xs font-medium text-gray-600 mb-1">Categorías (Ctrl/Cmd+click para múltiples)</label>
        <template x-if="!d.brand_id">
            <p class="text-xs text-gray-500 italic">Elegí una marca primero.</p>
        </template>
        <template x-if="d.brand_id && currentCats.length === 0">
            <p class="text-xs text-gray-500 italic">Esta marca no tiene categorías de catálogo.</p>
        </template>
        <template x-if="d.brand_id && currentCats.length > 0">
            <select x-model.number="d.category_ids" multiple size="6" class="w-full rounded border-gray-300 text-sm">
                <template x-for="cat in currentCats" :key="cat.id">
                    <option :value="cat.id" x-text="cat.name"></option>
                </template>
            </select>
        </template>
    </div>

    <div x-show="d.source === 'manual'" x-cloak>
        <label class="block text-xs font-medium text-gray-600 mb-1">Productos (Ctrl/Cmd+click para múltiples)</label>
        <template x-if="!d.brand_id">
            <p class="text-xs text-gray-500 italic">Elegí una marca primero.</p>
        </template>
        <template x-if="d.brand_id && currentProducts.length === 0">
            <p class="text-xs text-gray-500 italic">Esta marca no tiene productos de catálogo.</p>
        </template>
        <template x-if="d.brand_id && currentProducts.length > 0">
            <select x-model.number="d.product_ids" multiple size="10" class="w-full rounded border-gray-300 text-sm">
                <template x-for="prod in currentProducts" :key="prod.id">
                    <option :value="prod.id" x-text="prod.name"></option>
                </template>
            </select>
        </template>
    </div>

    <div class="grid grid-cols-4 gap-3 pt-2 border-t border-gray-100">
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">Productos por página</label>
            <input type="number" x-model.number="d.per_page" min="1" max="100" placeholder="Global"
                   class="w-full rounded border-gray-300 text-sm">
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">Columnas (desktop)</label>
            <input type="number" x-model.number="d.columns" min="2" max="6" placeholder="Global"
                   class="w-full rounded border-gray-300 text-sm">
        </div>
        <div class="flex items-end pb-1">
            <label class="flex items-center gap-2 cursor-pointer" x-show="d.source !== 'manual'">
                <input type="checkbox" x-model="d.show_search" class="rounded border-gray-300 text-blue-600">
                <span class="text-xs font-medium text-gray-600">Mostrar buscador</span>
            </label>
        </div>
        <div class="flex items-end pb-1">
            <label class="flex items-center gap-2 cursor-pointer" x-show="d.source !== 'manual'">
                <input type="checkbox" x-model="d.show_category_filter" class="rounded border-gray-300 text-blue-600">
                <span class="text-xs font-medium text-gray-600">Mostrar filtros de categoría</span>
            </label>
        </div>
    </div>

    <input type="hidden" :name="'block_data_' + blockId" :value="JSON.stringify(d)">
</div>
