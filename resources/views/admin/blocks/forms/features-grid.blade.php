<div class="space-y-4" x-data="{ d: {{ json_encode(array_merge(['variant'=>'default','title'=>'','subtitle'=>'','background'=>'#fff','anchor_id'=>'','features'=>[]], $data)) }} }">
    <div class="grid grid-cols-3 gap-3">
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">Variante</label>
            <select x-model="d.variant" class="w-full rounded border-gray-300 text-sm">
                <option value="default">Default</option>
                <option value="insumos-valor">Insumos Valor (3 cards con ícono)</option>
            </select>
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">Título</label>
            <input type="text" x-model="d.title" class="w-full rounded border-gray-300 text-sm">
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">Anchor ID</label>
            <input type="text" x-model="d.anchor_id" class="w-full rounded border-gray-300 text-sm">
        </div>
    </div>
    <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Subtítulo</label>
        <textarea x-model="d.subtitle" rows="2" class="w-full rounded border-gray-300 text-sm"></textarea>
    </div>
    <div x-show="d.variant === 'default'">
        <label class="block text-xs font-medium text-gray-600 mb-1">Color de fondo</label>
        <input type="text" x-model="d.background" class="w-full rounded border-gray-300 text-sm">
    </div>
    <div class="space-y-2">
        <label class="block text-xs font-medium text-gray-600">Features</label>
        <template x-for="(f, idx) in d.features" :key="idx">
            <div class="border border-gray-200 rounded-lg p-3 space-y-2">
                <div class="flex items-center justify-between mb-1">
                    <span class="text-xs font-semibold text-gray-500" x-text="'Feature ' + (idx + 1)"></span>
                    <button type="button" @click="d.features.splice(idx, 1)" class="text-red-500 text-xs">&times;</button>
                </div>
                <input type="text" x-model="f.title" class="w-full rounded border-gray-300 text-sm" placeholder="Título">
                <textarea x-model="f.text" rows="2" class="w-full rounded border-gray-300 text-sm" placeholder="Descripción"></textarea>
                <div x-show="d.variant === 'insumos-valor'">
                    <label class="block text-xs text-gray-500 mb-0.5">SVG del ícono</label>
                    <textarea x-model="f.icon_svg" rows="2" class="w-full rounded border-gray-300 text-xs font-mono"></textarea>
                </div>
                <div x-show="d.variant === 'default'">
                    @include('admin.blocks.partials.image-upload', ['field' => 'd.features[idx].image', 'label' => 'Imagen'])
                </div>
            </div>
        </template>
        <button type="button" @click="d.features.push({title:'',text:'',image:'',icon:'',icon_svg:''})" class="text-sm text-blue-600 hover:text-blue-800 font-medium">+ Agregar Feature</button>
    </div>
    <input type="hidden" :name="'block_data_' + blockId" :value="JSON.stringify(d)">
</div>
