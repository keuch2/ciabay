<div class="space-y-3" x-data="{ d: {{ json_encode(array_merge(['variant'=>'default','title'=>'','paragraphs'=>[],'caption'=>''], $data)) }} }">
    <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Variante</label>
        <select x-model="d.variant" class="w-full rounded border-gray-300 text-sm">
            <option value="default">Default</option>
            <option value="historia">Historia (relato largo)</option>
        </select>
    </div>
    <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Título</label>
        <input type="text" x-model="d.title" class="w-full rounded border-gray-300 text-sm">
    </div>
    <div class="space-y-2">
        <label class="block text-xs font-medium text-gray-600">Párrafos</label>
        <template x-for="(para, idx) in d.paragraphs" :key="idx">
            <div class="flex items-start gap-2">
                <textarea x-model="para.text" rows="3" class="flex-1 rounded border-gray-300 text-sm" placeholder="Párrafo de texto (HTML permitido)"></textarea>
                <button type="button" @click="d.paragraphs.splice(idx, 1)" class="text-red-500 text-xs mt-2">&times;</button>
            </div>
        </template>
        <button type="button" @click="d.paragraphs.push({text:''})" class="text-sm text-blue-600 hover:text-blue-800 font-medium">+ Agregar Párrafo</button>
    </div>
    <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Caption (pie de texto)</label>
        <input type="text" x-model="d.caption" class="w-full rounded border-gray-300 text-sm">
    </div>
    <input type="hidden" :name="'block_data_' + blockId" :value="JSON.stringify(d)">
</div>
