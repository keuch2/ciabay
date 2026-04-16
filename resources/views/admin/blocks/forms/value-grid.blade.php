<div class="space-y-3" x-data="{ d: {{ json_encode(array_merge(['variant'=>'historia','title'=>'','items'=>[]], $data)) }} }">
    <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Variante</label>
        <select x-model="d.variant" class="w-full rounded border-gray-300 text-sm">
            <option value="historia">Historia (6 valores compactos)</option>
            <option value="mvv">MVV (4 valores grandes)</option>
        </select>
    </div>
    <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Título</label>
        <input type="text" x-model="d.title" class="w-full rounded border-gray-300 text-sm">
    </div>
    <div class="space-y-2">
        <label class="block text-xs font-medium text-gray-600">Valores</label>
        <template x-for="(item, idx) in d.items" :key="idx">
            <div class="border border-gray-200 rounded-lg p-3 space-y-2">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-gray-500" x-text="'Valor ' + (idx + 1)"></span>
                    <button type="button" @click="d.items.splice(idx, 1)" class="text-red-500 text-xs">&times;</button>
                </div>
                <input type="text" x-model="item.label" class="w-full rounded border-gray-300 text-sm" placeholder="Etiqueta (ej: Proactividad)">
                <textarea x-model="item.icon_svg" rows="2" class="w-full rounded border-gray-300 text-xs font-mono" placeholder='<path d="..."/>'></textarea>
            </div>
        </template>
        <button type="button" @click="d.items.push({label:'',icon_svg:''})" class="text-sm text-blue-600 hover:text-blue-800 font-medium">+ Agregar Valor</button>
    </div>
    <input type="hidden" :name="'block_data_' + blockId" :value="JSON.stringify(d)">
</div>
