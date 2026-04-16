<div class="space-y-3" x-data="{ d: {{ json_encode(array_merge(['quote'=>'','author'=>'','background'=>'var(--color-primary)','color'=>'#fff'], $data)) }} }">
    <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Cita</label>
        <textarea x-model="d.quote" rows="3" class="w-full rounded border-gray-300 text-sm"></textarea>
    </div>
    <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Autor</label>
        <input type="text" x-model="d.author" class="w-full rounded border-gray-300 text-sm">
    </div>
    <div class="grid grid-cols-2 gap-3">
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">Color de fondo</label>
            <input type="text" x-model="d.background" class="w-full rounded border-gray-300 text-sm">
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">Color de texto</label>
            <input type="text" x-model="d.color" class="w-full rounded border-gray-300 text-sm">
        </div>
    </div>
    <input type="hidden" :name="'block_data_' + blockId" :value="JSON.stringify(d)">
</div>
