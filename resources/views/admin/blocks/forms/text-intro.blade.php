<div class="space-y-3" x-data="{ d: {{ json_encode($data) }} }">
    <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Título</label>
        <input type="text" x-model="d.title" class="w-full rounded border-gray-300 text-sm">
    </div>
    <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Texto (HTML)</label>
        <textarea x-model="d.text" rows="5" class="w-full rounded border-gray-300 text-sm"></textarea>
    </div>
    <input type="hidden" :name="'block_data_' + blockId" :value="JSON.stringify(d)">
</div>
