<div class="space-y-3" x-data="{ d: {{ json_encode(array_merge(['anchor_id'=>'','tag'=>'','tag_color'=>'green','cta_color'=>'green','title'=>'','text'=>'','chips'=>[],'brands_label'=>'Marcas destacadas:','brands'=>[],'image'=>'','cta_text'=>'','cta_url'=>'','alt'=>false,'reversed'=>false], $data)) }} }">
    <div class="grid grid-cols-3 gap-3">
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">Anchor ID</label>
            <input type="text" x-model="d.anchor_id" class="w-full rounded border-gray-300 text-sm">
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">Tag</label>
            <input type="text" x-model="d.tag" class="w-full rounded border-gray-300 text-sm" placeholder="GENÉTICA">
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">Color tag</label>
            <select x-model="d.tag_color" @change="d.cta_color = d.tag_color" class="w-full rounded border-gray-300 text-sm">
                <option value="green">Verde</option>
                <option value="blue">Azul</option>
                <option value="orange">Naranja</option>
            </select>
        </div>
    </div>
    <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Título</label>
        <input type="text" x-model="d.title" class="w-full rounded border-gray-300 text-sm">
    </div>
    <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Texto</label>
        <textarea x-model="d.text" rows="3" class="w-full rounded border-gray-300 text-sm"></textarea>
    </div>
    <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Chips (etiquetas separadas por coma)</label>
        <input type="text" :value="(d.chips || []).join(', ')" @input="d.chips = $event.target.value.split(',').map(s => s.trim()).filter(Boolean)" class="w-full rounded border-gray-300 text-sm" placeholder="Soja, Maíz, Sorgo">
    </div>
    <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Marcas (separadas por coma)</label>
        <input type="text" :value="(d.brands || []).join(', ')" @input="d.brands = $event.target.value.split(',').map(s => s.trim()).filter(Boolean)" class="w-full rounded border-gray-300 text-sm" placeholder="Nidera Semillas, Nuseed">
    </div>
    @include('admin.blocks.partials.image-upload', ['field' => 'd.image', 'label' => 'Imagen lateral'])
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
    <div class="flex items-center gap-4">
        <label class="flex items-center gap-2 text-xs text-gray-600">
            <input type="checkbox" x-model="d.alt" class="rounded border-gray-300 text-blue-600">
            Alt (fondo alternado)
        </label>
        <label class="flex items-center gap-2 text-xs text-gray-600">
            <input type="checkbox" x-model="d.reversed" class="rounded border-gray-300 text-blue-600">
            Reversed (imagen a la derecha)
        </label>
    </div>
    <input type="hidden" :name="'block_data_' + blockId" :value="JSON.stringify(d)">
</div>
