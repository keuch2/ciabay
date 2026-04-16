<div class="space-y-3" x-data="{ d: {{ json_encode(array_merge(['title'=>'','subtitle'=>'','image'=>'','button_text'=>'','button_url'=>'','button_target'=>'_self'], $data)) }} }">
    <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Título</label>
        <input type="text" x-model="d.title" class="w-full rounded border-gray-300 text-sm">
    </div>
    <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Subtítulo</label>
        <input type="text" x-model="d.subtitle" class="w-full rounded border-gray-300 text-sm">
    </div>
    @include('admin.blocks.partials.image-upload', ['field' => 'd.image', 'label' => 'Imagen de fondo'])
    <div class="grid grid-cols-2 gap-3">
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">Texto del botón (opcional)</label>
            <input type="text" x-model="d.button_text" class="w-full rounded border-gray-300 text-sm">
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">URL del botón</label>
            <input type="text" x-model="d.button_url" class="w-full rounded border-gray-300 text-sm" placeholder="contacto o https://...">
        </div>
    </div>
    <label class="flex items-center gap-2 text-xs text-gray-600">
        <input type="checkbox" x-model="d.button_target" :value="d.button_target === '_blank' ? '_self' : '_blank'" @change="d.button_target = $event.target.checked ? '_blank' : '_self'" :checked="d.button_target === '_blank'" class="rounded border-gray-300 text-blue-600">
        Abrir en pestaña nueva
    </label>
    <input type="hidden" :name="'block_data_' + blockId" :value="JSON.stringify(d)">
</div>
