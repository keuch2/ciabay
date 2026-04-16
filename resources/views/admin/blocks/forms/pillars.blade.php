<div class="space-y-4" x-data="{ d: {{ json_encode(array_merge(['variant' => 'default', 'title'=>'','pillars'=>[]], $data)) }} }">
    <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Variante</label>
        <select x-model="d.variant" class="w-full rounded border-gray-300 text-sm">
            <option value="default">Default (pillars genérico)</option>
            <option value="mvv-pillars">MVV (Visión/Misión estilo mision-vision-valores)</option>
            <option value="direccionadores">Direccionadores (estilo historia)</option>
        </select>
    </div>
    <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Título de sección</label>
        <input type="text" x-model="d.title" class="w-full rounded border-gray-300 text-sm">
    </div>
    <div class="space-y-2">
        <label class="block text-xs font-medium text-gray-600">Pilares</label>
        <template x-for="(pillar, idx) in d.pillars" :key="idx">
            <div class="border border-gray-200 rounded-lg p-3 space-y-2">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-gray-500" x-text="'Pilar ' + (idx + 1)"></span>
                    <button type="button" @click="d.pillars.splice(idx, 1)" class="text-red-500 text-xs">&times;</button>
                </div>
                <input type="text" x-model="pillar.title" class="w-full rounded border-gray-300 text-sm" placeholder="Título">
                <textarea x-model="pillar.text" rows="3" class="w-full rounded border-gray-300 text-sm" placeholder="Descripción"></textarea>
                <div>
                    <label class="block text-xs text-gray-500 mb-0.5">Modificador (solo mvv-pillars: ej. vision, mision)</label>
                    <input type="text" x-model="pillar.modifier" class="w-full rounded border-gray-300 text-xs" placeholder="vision / mision">
                </div>
                <div>
                    <label class="block text-xs text-gray-500 mb-0.5">SVG del ícono (paths/shapes SVG interior, sin &lt;svg&gt;)</label>
                    <textarea x-model="pillar.icon_svg" rows="2" class="w-full rounded border-gray-300 text-xs font-mono" placeholder='<circle cx="12" cy="12" r="10"/>'></textarea>
                </div>
                <div>
                    <label class="block text-xs text-gray-500 mb-0.5">Color del título (solo default)</label>
                    <input type="text" x-model="pillar.title_color" class="w-full rounded border-gray-300 text-xs" placeholder="var(--color-primary)">
                </div>
            </div>
        </template>
        <button type="button" @click="d.pillars.push({title:'',text:'',modifier:'',icon_svg:'',title_color:'var(--color-primary)'})" class="text-sm text-blue-600 hover:text-blue-800 font-medium">+ Agregar Pilar</button>
    </div>
    <input type="hidden" :name="'block_data_' + blockId" :value="JSON.stringify(d)">
</div>
