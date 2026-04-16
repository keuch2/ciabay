<div class="space-y-3" x-data="{ d: {{ json_encode(array_merge(['source'=>'branches','title'=>'','subtitle'=>'','items'=>[]], $data)) }} }">
    <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Fuente de datos</label>
        <select x-model="d.source" class="w-full rounded border-gray-300 text-sm">
            <option value="branches">Modelo Sucursales (se actualiza desde /admin/branches)</option>
            <option value="manual">Manual (editar aquí)</option>
        </select>
    </div>
    <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Título</label>
        <input type="text" x-model="d.title" class="w-full rounded border-gray-300 text-sm">
    </div>
    <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Subtítulo</label>
        <input type="text" x-model="d.subtitle" class="w-full rounded border-gray-300 text-sm">
    </div>
    <div x-show="d.source === 'manual'" class="space-y-2">
        <label class="block text-xs font-medium text-gray-600">Sucursales manuales</label>
        <template x-for="(item, idx) in d.items" :key="idx">
            <div class="border border-gray-200 rounded-lg p-3 space-y-2">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-gray-500" x-text="'Sucursal ' + (idx + 1)"></span>
                    <button type="button" @click="d.items.splice(idx, 1)" class="text-red-500 text-xs">&times;</button>
                </div>
                <input type="text" x-model="item.name" class="w-full rounded border-gray-300 text-sm" placeholder="Nombre">
                <input type="text" x-model="item.address" class="w-full rounded border-gray-300 text-sm" placeholder="Dirección completa">
                @include('admin.blocks.partials.image-upload', ['field' => 'item.image', 'label' => 'Imagen'])
            </div>
        </template>
        <button type="button" @click="d.items.push({name:'',image:'',address:''})" class="text-sm text-blue-600 hover:text-blue-800 font-medium">+ Agregar Sucursal</button>
    </div>
    <input type="hidden" :name="'block_data_' + blockId" :value="JSON.stringify(d)">
</div>
