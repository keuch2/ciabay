<div class="space-y-3" x-data="{ d: {{ json_encode(array_merge(['title'=>''], $data)) }} }">
    <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Título</label>
        <textarea x-model="d.title" rows="3" class="w-full rounded border-gray-300 text-sm" placeholder="No estás solo..."></textarea>
    </div>
    <input type="hidden" :name="'block_data_' + blockId" :value="JSON.stringify(d)">
</div>
