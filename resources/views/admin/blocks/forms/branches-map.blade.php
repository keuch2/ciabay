<div class="space-y-3" x-data="{ d: {{ json_encode(array_merge(['title'=>'','subtitle'=>''], $data)) }} }">
    <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Título</label>
        <input type="text" x-model="d.title" class="w-full rounded border-gray-300 text-sm">
    </div>
    <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Subtítulo</label>
        <input type="text" x-model="d.subtitle" class="w-full rounded border-gray-300 text-sm">
    </div>
    <p class="text-xs text-gray-400">Las sucursales se cargan automáticamente desde la base de datos.</p>
    <input type="hidden" :name="'block_data_' + blockId" :value="JSON.stringify(d)">
</div>
