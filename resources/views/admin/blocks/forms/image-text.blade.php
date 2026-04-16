<div class="space-y-3" x-data="{ d: {{ json_encode(array_merge(['variant'=>'default','title'=>'','tag'=>'','text'=>'','image'=>'','button_text'=>'','button_url'=>'','reversed'=>false,'list'=>[],'anchor_id'=>''], $data)) }} }">
    <div class="grid grid-cols-2 gap-3">
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">Variante</label>
            <select x-model="d.variant" class="w-full rounded border-gray-300 text-sm">
                <option value="default">Default (imagen + texto)</option>
                <option value="impl-repuestos">Implementos Repuestos</option>
            </select>
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">Título</label>
            <input type="text" x-model="d.title" class="w-full rounded border-gray-300 text-sm">
        </div>
    </div>
    <div x-show="d.variant === 'impl-repuestos'" class="grid grid-cols-2 gap-3">
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">Tag</label>
            <input type="text" x-model="d.tag" class="w-full rounded border-gray-300 text-sm" placeholder="REPUESTOS">
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">Anchor ID</label>
            <input type="text" x-model="d.anchor_id" class="w-full rounded border-gray-300 text-sm" placeholder="repuestos">
        </div>
    </div>
    <div x-show="d.variant === 'impl-repuestos'">
        <label class="block text-xs font-medium text-gray-600 mb-1">Items de lista (uno por línea)</label>
        <textarea :value="(d.list || []).join('\n')" @input="d.list = $event.target.value.split('\n').map(s => s.trim()).filter(Boolean)" rows="4" class="w-full rounded border-gray-300 text-sm"></textarea>
    </div>
    <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Texto (HTML)</label>
        <textarea x-model="d.text" rows="4" class="w-full rounded border-gray-300 text-sm"></textarea>
    </div>
    @include('admin.blocks.partials.image-upload', ['field' => 'd.image', 'label' => 'Imagen'])
    <div class="grid grid-cols-2 gap-3">
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">Texto botón</label>
            <input type="text" x-model="d.button_text" class="w-full rounded border-gray-300 text-sm">
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">URL botón</label>
            <input type="text" x-model="d.button_url" class="w-full rounded border-gray-300 text-sm">
        </div>
    </div>
    <label class="flex items-center gap-2">
        <input type="checkbox" x-model="d.reversed" class="rounded border-gray-300 text-blue-600">
        <span class="text-xs text-gray-600">Invertir (imagen a la derecha)</span>
    </label>
    <input type="hidden" :name="'block_data_' + blockId" :value="JSON.stringify(d)">
</div>
