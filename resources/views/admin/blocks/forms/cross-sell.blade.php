<div class="space-y-3" x-data="{ d: {{ json_encode(array_merge(['icon_svg'=>'','title'=>'','text'=>'','cta_text'=>'','cta_url'=>''], $data)) }} }">
    <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">SVG del ícono (shapes internas)</label>
        <textarea x-model="d.icon_svg" rows="3" class="w-full rounded border-gray-300 text-xs font-mono"></textarea>
    </div>
    <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Título</label>
        <input type="text" x-model="d.title" class="w-full rounded border-gray-300 text-sm">
    </div>
    <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Texto</label>
        <textarea x-model="d.text" rows="3" class="w-full rounded border-gray-300 text-sm"></textarea>
    </div>
    <div class="grid grid-cols-2 gap-3">
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">Texto CTA</label>
            <input type="text" x-model="d.cta_text" class="w-full rounded border-gray-300 text-sm">
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">URL CTA</label>
            <input type="text" x-model="d.cta_url" class="w-full rounded border-gray-300 text-sm">
        </div>
    </div>
    <input type="hidden" :name="'block_data_' + blockId" :value="JSON.stringify(d)">
</div>
