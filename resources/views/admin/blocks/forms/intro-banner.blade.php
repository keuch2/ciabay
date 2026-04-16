<div class="space-y-3" x-data="{ d: {{ json_encode(array_merge(['variant'=>'default','title'=>'','text'=>''], $data)) }} }">
    <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Variante</label>
        <select x-model="d.variant" class="w-full rounded border-gray-300 text-sm">
            <option value="default">Default</option>
            <option value="historia">Historia (banner con H1)</option>
            <option value="impl">Implementos</option>
        </select>
    </div>
    <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Título</label>
        <input type="text" x-model="d.title" class="w-full rounded border-gray-300 text-sm">
    </div>
    <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Texto (HTML permitido)</label>
        <textarea x-model="d.text" rows="4" class="w-full rounded border-gray-300 text-sm"></textarea>
    </div>
    <input type="hidden" :name="'block_data_' + blockId" :value="JSON.stringify(d)">
</div>
