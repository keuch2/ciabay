<div class="space-y-4" x-data="{ d: {{ json_encode(array_merge(['title' => '', 'stats' => []], $data)) }} }">
    <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Título</label>
        <input type="text" x-model="d.title" class="w-full rounded border-gray-300 text-sm">
    </div>
    <div class="space-y-2">
        <label class="block text-xs font-medium text-gray-600">Estadísticas</label>
        <template x-for="(stat, idx) in d.stats" :key="idx">
            <div class="flex items-center gap-2">
                <input type="text" x-model="stat.number" class="w-24 rounded border-gray-300 text-sm" placeholder="31+">
                <input type="text" x-model="stat.label" class="flex-1 rounded border-gray-300 text-sm" placeholder="Años de Experiencia">
                <button type="button" @click="d.stats.splice(idx, 1)" class="text-red-500 text-xs">&times;</button>
            </div>
        </template>
        <button type="button" @click="d.stats.push({number:'',label:''})" class="text-sm text-blue-600 hover:text-blue-800 font-medium">+ Agregar</button>
    </div>
    <input type="hidden" :name="'block_data_' + blockId" :value="JSON.stringify(d)">
</div>
