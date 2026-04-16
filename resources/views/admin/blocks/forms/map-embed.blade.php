<div class="space-y-3" x-data="{ d: {{ json_encode(array_merge(['title'=>'','subtitle'=>'','embed_url'=>'','height'=>'600'], $data)) }} }">
    <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Título</label>
        <input type="text" x-model="d.title" class="w-full rounded border-gray-300 text-sm">
    </div>
    <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Subtítulo</label>
        <input type="text" x-model="d.subtitle" class="w-full rounded border-gray-300 text-sm">
    </div>
    <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">URL del iframe (Google Maps embed)</label>
        <input type="text" x-model="d.embed_url" class="w-full rounded border-gray-300 text-sm" placeholder="https://www.google.com/maps/d/embed?mid=...">
    </div>
    <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Altura (px)</label>
        <input type="text" x-model="d.height" class="w-full rounded border-gray-300 text-sm" placeholder="600">
    </div>
    <input type="hidden" :name="'block_data_' + blockId" :value="JSON.stringify(d)">
</div>
