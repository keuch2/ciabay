<div class="space-y-4" x-data="{ d: {{ json_encode(array_merge(['title'=>'','background'=>'#f8f9fa','testimonials'=>[]], $data)) }} }">
    <div class="grid grid-cols-2 gap-3">
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">Título</label>
            <input type="text" x-model="d.title" class="w-full rounded border-gray-300 text-sm">
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">Color de fondo</label>
            <input type="text" x-model="d.background" class="w-full rounded border-gray-300 text-sm">
        </div>
    </div>
    <div class="space-y-2">
        <label class="block text-xs font-medium text-gray-600">Testimonios</label>
        <template x-for="(t, idx) in d.testimonials" :key="idx">
            <div class="border border-gray-200 rounded-lg p-3 space-y-2">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-semibold text-gray-500" x-text="'Testimonio ' + (idx + 1)"></span>
                    <button type="button" @click="d.testimonials.splice(idx, 1)" class="text-red-500 text-xs">&times;</button>
                </div>
                <textarea x-model="t.text" rows="2" class="w-full rounded border-gray-300 text-sm" placeholder="Texto del testimonio"></textarea>
                <div class="grid grid-cols-2 gap-2">
                    <input type="text" x-model="t.name" class="rounded border-gray-300 text-sm" placeholder="Nombre">
                    <input type="text" x-model="t.role" class="rounded border-gray-300 text-sm" placeholder="Cargo">
                </div>
                @include('admin.blocks.partials.image-upload', ['field' => 'd.testimonials[idx].avatar', 'label' => 'Avatar'])
            </div>
        </template>
        <button type="button" @click="d.testimonials.push({text:'',name:'',role:'',avatar:''})" class="text-sm text-blue-600 hover:text-blue-800 font-medium">+ Agregar Testimonio</button>
    </div>
    <input type="hidden" :name="'block_data_' + blockId" :value="JSON.stringify(d)">
</div>
