<div class="space-y-3" x-data="{ d: {{ json_encode(array_merge(['title'=>'','subtitle'=>'','anchor_id'=>'','items'=>[]], $data)) }} }">
    <div class="grid grid-cols-2 gap-3">
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">Título</label>
            <input type="text" x-model="d.title" class="w-full rounded border-gray-300 text-sm">
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">Anchor ID</label>
            <input type="text" x-model="d.anchor_id" class="w-full rounded border-gray-300 text-sm">
        </div>
    </div>
    <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Subtítulo</label>
        <input type="text" x-model="d.subtitle" class="w-full rounded border-gray-300 text-sm">
    </div>
    <div class="space-y-2">
        <label class="block text-xs font-medium text-gray-600">Categorías</label>
        <template x-for="(item, idx) in d.items" :key="idx">
            <div class="border border-gray-200 rounded-lg p-3 space-y-2">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-gray-500" x-text="'Categoría ' + (idx + 1)"></span>
                    <button type="button" @click="d.items.splice(idx, 1)" class="text-red-500 text-xs">&times;</button>
                </div>
                <input type="text" x-model="item.title" class="w-full rounded border-gray-300 text-sm" placeholder="Título (ej: Preparación de Suelo)">
                <textarea x-model="item.icon_svg" rows="2" class="w-full rounded border-gray-300 text-xs font-mono" placeholder='<path d="..."/>'></textarea>
                <div>
                    <label class="block text-xs text-gray-500 mb-0.5">Items (uno por línea)</label>
                    <textarea :value="(item.list || []).join('\n')" @input="item.list = $event.target.value.split('\n').map(s => s.trim()).filter(Boolean)" rows="4" class="w-full rounded border-gray-300 text-sm"></textarea>
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <input type="text" x-model="item.cta_text" class="rounded border-gray-300 text-sm" placeholder="Texto CTA">
                    <input type="text" x-model="item.cta_url" class="rounded border-gray-300 text-sm" placeholder="URL">
                </div>
            </div>
        </template>
        <button type="button" @click="d.items.push({title:'',icon_svg:'',list:[],cta_text:'',cta_url:''})" class="text-sm text-blue-600 hover:text-blue-800 font-medium">+ Agregar Categoría</button>
    </div>
    <input type="hidden" :name="'block_data_' + blockId" :value="JSON.stringify(d)">
</div>
