<div class="space-y-4" x-data="{ d: {{ json_encode(array_merge(['variant'=>'default','title'=>'','events'=>[]], $data)) }} }">
    <div class="grid grid-cols-2 gap-3">
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">Variante</label>
            <select x-model="d.variant" class="w-full rounded border-gray-300 text-sm">
                <option value="default">Default</option>
                <option value="historia">Historia (con logos)</option>
            </select>
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">Título</label>
            <input type="text" x-model="d.title" class="w-full rounded border-gray-300 text-sm">
        </div>
    </div>
    <div class="space-y-2">
        <label class="block text-xs font-medium text-gray-600">Eventos</label>
        <template x-for="(event, idx) in d.events" :key="idx">
            <div class="border border-gray-200 rounded-lg p-3 space-y-2">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-gray-500" x-text="'Evento ' + (idx + 1)"></span>
                    <button type="button" @click="d.events.splice(idx, 1)" class="text-red-500 text-xs">&times;</button>
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="block text-xs text-gray-500 mb-0.5">Año</label>
                        <input type="text" x-model="event.year" class="w-full rounded border-gray-300 text-sm">
                    </div>
                    <div>
                        <label class="block text-xs text-gray-500 mb-0.5">Título</label>
                        <input type="text" x-model="event.title" class="w-full rounded border-gray-300 text-sm">
                    </div>
                </div>
                <div>
                    <label class="block text-xs text-gray-500 mb-0.5">Descripción</label>
                    <textarea x-model="event.description" rows="2" class="w-full rounded border-gray-300 text-sm"></textarea>
                </div>
                @include('admin.blocks.partials.image-upload', ['field' => 'd.events[idx].image', 'label' => 'Imagen (opcional)'])
            </div>
        </template>
        <button type="button" @click="d.events.push({year:'',title:'',description:'',image:''})" class="text-sm text-blue-600 hover:text-blue-800 font-medium">+ Agregar Evento</button>
    </div>
    <input type="hidden" :name="'block_data_' + blockId" :value="JSON.stringify(d)">
</div>
