<div class="space-y-3" x-data="{ d: {{ json_encode(array_merge(['background_image'=>'','background_alt'=>'Agricultor','overlay_image'=>'','overlay_alt'=>'Agricultura en buenas manos'], $data)) }} }">
    @include('admin.blocks.partials.image-upload', ['field' => 'd.background_image', 'label' => 'Imagen de fondo'])
    <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Alt imagen de fondo</label>
        <input type="text" x-model="d.background_alt" class="w-full rounded border-gray-300 text-sm">
    </div>
    @include('admin.blocks.partials.image-upload', ['field' => 'd.overlay_image', 'label' => 'Imagen overlay'])
    <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Alt imagen overlay</label>
        <input type="text" x-model="d.overlay_alt" class="w-full rounded border-gray-300 text-sm">
    </div>
    <input type="hidden" :name="'block_data_' + blockId" :value="JSON.stringify(d)">
</div>
