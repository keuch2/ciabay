<div class="space-y-3" x-data="{ d: {{ json_encode(array_merge(['variant'=>'specialized','title'=>'','subtitle'=>'','anchor_id'=>'','items'=>[]], $data)) }} }">
    <div class="grid grid-cols-2 gap-3">
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">Variante</label>
            <select x-model="d.variant" class="w-full rounded border-gray-300 text-sm">
                <option value="specialized">Specialized (implementos)</option>
                <option value="marcas">Marcas (insumos)</option>
            </select>
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">Anchor ID</label>
            <input type="text" x-model="d.anchor_id" class="w-full rounded border-gray-300 text-sm">
        </div>
    </div>
    <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Título</label>
        <input type="text" x-model="d.title" class="w-full rounded border-gray-300 text-sm">
    </div>
    <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Subtítulo</label>
        <input type="text" x-model="d.subtitle" class="w-full rounded border-gray-300 text-sm">
    </div>
    <div class="space-y-2">
        <label class="block text-xs font-medium text-gray-600">Items</label>
        <template x-for="(item, idx) in d.items" :key="idx">
            <div class="border border-gray-200 rounded-lg p-3 space-y-2">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-gray-500" x-text="'Item ' + (idx + 1)"></span>
                    <button type="button" @click="d.items.splice(idx, 1)" class="text-red-500 text-xs">&times;</button>
                </div>
                <input type="text" x-model="item.name" class="w-full rounded border-gray-300 text-sm" placeholder="Nombre">
                @include('admin.blocks.partials.image-upload', ['field' => 'item.logo', 'label' => 'Logo'])
                <input type="text" x-model="item.description" class="w-full rounded border-gray-300 text-sm" placeholder="Descripción (solo specialized)">
                <input type="text" x-model="item.cta_url" class="w-full rounded border-gray-300 text-sm" placeholder="URL destino (solo marcas)">
            </div>
        </template>
        <button type="button" @click="d.items.push({name:'',logo:'',description:'',cta_url:''})" class="text-sm text-blue-600 hover:text-blue-800 font-medium">+ Agregar Item</button>
    </div>
    <input type="hidden" :name="'block_data_' + blockId" :value="JSON.stringify(d)">
</div>
