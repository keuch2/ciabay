<div class="space-y-3" x-data="{ d: {{ json_encode(array_merge(['variant' => 'default','title'=>'','text'=>'','background'=>'','buttons'=>[]], $data)) }} }">
    <div class="grid grid-cols-2 gap-3">
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">Variante</label>
            <select x-model="d.variant" class="w-full rounded border-gray-300 text-sm">
                <option value="default">Default (cta-section)</option>
                <option value="impl">Implementos (impl-cta)</option>
                <option value="insumos">Insumos (insumos-cta)</option>
            </select>
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">Color de fondo (opcional)</label>
            <input type="text" x-model="d.background" class="w-full rounded border-gray-300 text-sm" placeholder="var(--color-primary)">
        </div>
    </div>
    <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Título</label>
        <input type="text" x-model="d.title" class="w-full rounded border-gray-300 text-sm">
    </div>
    <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Texto</label>
        <textarea x-model="d.text" rows="2" class="w-full rounded border-gray-300 text-sm"></textarea>
    </div>
    <div class="space-y-2">
        <label class="block text-xs font-medium text-gray-600">Botones</label>
        <template x-for="(btn, idx) in d.buttons" :key="idx">
            <div class="border border-gray-200 rounded-lg p-3 space-y-2">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-gray-500" x-text="'Botón ' + (idx + 1)"></span>
                    <button type="button" @click="d.buttons.splice(idx, 1)" class="text-red-500 text-xs">&times;</button>
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <input type="text" x-model="btn.text" class="rounded border-gray-300 text-sm" placeholder="Texto">
                    <input type="text" x-model="btn.url" class="rounded border-gray-300 text-sm" placeholder="URL o slug">
                </div>
                <div class="grid grid-cols-3 gap-2">
                    <select x-model="btn.style" class="rounded border-gray-300 text-sm">
                        <option value="primary">Primario</option>
                        <option value="white">Blanco</option>
                        <option value="whatsapp">WhatsApp</option>
                        <option value="outline-white">Outline Blanco</option>
                        <option value="brand">Marca</option>
                    </select>
                    <select x-model="btn.icon" class="rounded border-gray-300 text-sm">
                        <option value="none">Sin ícono</option>
                        <option value="whatsapp">WhatsApp</option>
                    </select>
                    <select x-model="btn.target" class="rounded border-gray-300 text-sm">
                        <option value="_self">Misma pestaña</option>
                        <option value="_blank">Nueva pestaña</option>
                    </select>
                </div>
            </div>
        </template>
        <button type="button" @click="d.buttons.push({text:'',url:'',style:'primary',icon:'none',target:'_self'})" class="text-sm text-blue-600 hover:text-blue-800 font-medium">+ Agregar Botón</button>
    </div>
    <input type="hidden" :name="'block_data_' + blockId" :value="JSON.stringify(d)">
</div>
