<div class="space-y-3" x-data="{ d: {{ json_encode(array_merge(['title'=>'Red Case IH','subtitle'=>'','image'=>'assets/images/redcaseih/hero.jpg','logo'=>'assets/images/redcase-blanco.png'], $data)) }} }">
    <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Título</label>
        <input type="text" x-model="d.title" class="w-full rounded border-gray-300 text-sm">
    </div>
    <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Subtítulo</label>
        <textarea x-model="d.subtitle" rows="2" class="w-full rounded border-gray-300 text-sm"></textarea>
    </div>
    @include('admin.blocks.partials.image-upload', ['field' => 'd.image', 'label' => 'Imagen de fondo'])
    @include('admin.blocks.partials.image-upload', ['field' => 'd.logo', 'label' => 'Logo overlay (PNG transparente)'])
    <input type="hidden" :name="'block_data_' + blockId" :value="JSON.stringify(d)">
</div>
