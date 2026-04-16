<div class="space-y-4" x-data="{ d: {{ json_encode(array_merge(['title'=>'','images'=>[]], $data)) }} }">
    <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Título</label>
        <input type="text" x-model="d.title" class="w-full rounded border-gray-300 text-sm">
    </div>
    <div class="space-y-3">
        <label class="block text-xs font-medium text-gray-600">Imágenes</label>
        <template x-for="(img, idx) in d.images" :key="idx">
            <div class="border border-gray-200 rounded-lg p-3 space-y-2">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-gray-500" x-text="'Imagen ' + (idx + 1)"></span>
                    <button type="button" @click="d.images.splice(idx, 1)" class="text-red-500 text-xs">&times; Quitar</button>
                </div>
                @include('admin.blocks.partials.image-upload', ['field' => 'd.images[idx].src', 'label' => 'Archivo'])
                <input type="text" x-model="d.images[idx].alt" class="w-full rounded border-gray-300 text-xs" placeholder="Alt text">
            </div>
        </template>
        <button type="button" @click="d.images.push({src:'',alt:''})" class="text-sm text-blue-600 hover:text-blue-800 font-medium">+ Agregar Imagen</button>
    </div>
    <input type="hidden" :name="'block_data_' + blockId" :value="JSON.stringify(d)">
</div>
