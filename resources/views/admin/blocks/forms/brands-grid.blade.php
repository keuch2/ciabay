<div class="space-y-4" x-data="{ d: {{ json_encode(array_merge(['title'=>'','subtitle'=>'','brands'=>[]], $data)) }} }">
    <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Título</label>
        <input type="text" x-model="d.title" class="w-full rounded border-gray-300 text-sm">
    </div>
    <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Subtítulo</label>
        <input type="text" x-model="d.subtitle" class="w-full rounded border-gray-300 text-sm">
    </div>
    <div class="space-y-2">
        <label class="block text-xs font-medium text-gray-600">Marcas</label>
        <template x-for="(brand, idx) in d.brands" :key="idx">
            <div class="border border-gray-200 rounded-lg p-3 space-y-2">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-gray-500" x-text="'Marca ' + (idx + 1)"></span>
                    <button type="button" @click="d.brands.splice(idx, 1)" class="text-red-500 text-xs">&times;</button>
                </div>
                <input type="text" x-model="brand.name" class="w-full rounded border-gray-300 text-sm" placeholder="Nombre">
                @include('admin.blocks.partials.image-upload', ['field' => 'd.brands[idx].logo', 'label' => 'Logo'])
            </div>
        </template>
        <button type="button" @click="d.brands.push({name:'',logo:''})" class="text-sm text-blue-600 hover:text-blue-800 font-medium">+ Agregar Marca</button>
    </div>
    <input type="hidden" :name="'block_data_' + blockId" :value="JSON.stringify(d)">
</div>
