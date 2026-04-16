<div class="space-y-3" x-data="{ d: {{ json_encode(array_merge(['title'=>'','subtitle'=>'','anchor_id'=>'','brands'=>[]], $data)) }} }">
    <div class="grid grid-cols-2 gap-3">
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">Título</label>
            <input type="text" x-model="d.title" class="w-full rounded border-gray-300 text-sm">
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">Anchor ID (opcional)</label>
            <input type="text" x-model="d.anchor_id" class="w-full rounded border-gray-300 text-sm" placeholder="marcas">
        </div>
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
                <div class="grid grid-cols-2 gap-2">
                    <input type="text" x-model="brand.name" class="rounded border-gray-300 text-sm" placeholder="Nombre">
                    <input type="text" x-model="brand.slug" class="rounded border-gray-300 text-sm" placeholder="slug (ej: tatu)">
                </div>
                <input type="text" x-model="brand.tagline" class="w-full rounded border-gray-300 text-sm" placeholder="Tagline (ej: El Rey del Suelo)">
                @include('admin.blocks.partials.image-upload', ['field' => 'brand.logo', 'label' => 'Logo'])
                <textarea x-model="brand.description" rows="3" class="w-full rounded border-gray-300 text-sm" placeholder="Descripción"></textarea>
                <div>
                    <label class="block text-xs text-gray-500 mb-0.5">Productos (un producto por línea)</label>
                    <textarea :value="(brand.products || []).join('\n')" @input="brand.products = $event.target.value.split('\n').map(s => s.trim()).filter(Boolean)" rows="3" class="w-full rounded border-gray-300 text-sm"></textarea>
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <input type="text" x-model="brand.cta_text" class="rounded border-gray-300 text-sm" placeholder="Texto CTA">
                    <input type="text" x-model="brand.cta_url" class="rounded border-gray-300 text-sm" placeholder="URL CTA">
                </div>
            </div>
        </template>
        <button type="button" @click="d.brands.push({name:'',slug:'',logo:'',tagline:'',description:'',products:[],cta_text:'',cta_url:''})" class="text-sm text-blue-600 hover:text-blue-800 font-medium">+ Agregar Marca</button>
    </div>
    <input type="hidden" :name="'block_data_' + blockId" :value="JSON.stringify(d)">
</div>
