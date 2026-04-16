<div class="space-y-3" x-data="{ d: {{ json_encode(array_merge(['title'=>'','text'=>'','show_info'=>true], $data)) }} }">
    <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Título</label>
        <input type="text" x-model="d.title" class="w-full rounded border-gray-300 text-sm">
    </div>
    <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Texto (HTML)</label>
        <textarea x-model="d.text" rows="3" class="w-full rounded border-gray-300 text-sm"></textarea>
    </div>
    <label class="flex items-center gap-2">
        <input type="checkbox" x-model="d.show_info" class="rounded border-gray-300 text-blue-600">
        <span class="text-xs text-gray-600">Mostrar info de contacto (teléfono, email, dirección)</span>
    </label>
    <input type="hidden" :name="'block_data_' + blockId" :value="JSON.stringify(d)">
</div>
