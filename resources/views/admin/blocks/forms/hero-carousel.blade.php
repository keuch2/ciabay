<div class="space-y-4" x-data="{ slides: {{ json_encode($data['slides'] ?? [['title'=>'','subtitle'=>'','image'=>'','mobile_image'=>'','button_text'=>'','button_url'=>'']]) }} }">
    <template x-for="(slide, idx) in slides" :key="idx">
        <div class="border border-gray-200 rounded-lg p-4 relative">
            <div class="flex items-center justify-between mb-3">
                <span class="text-sm font-semibold text-gray-600" x-text="'Slide ' + (idx + 1)"></span>
                <button type="button" @click="slides.splice(idx, 1)" class="text-red-500 hover:text-red-700 text-xs" x-show="slides.length > 1">&times; Eliminar</button>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Título</label>
                    <input type="text" x-model="slide.title" class="w-full rounded border-gray-300 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Subtítulo</label>
                    <input type="text" x-model="slide.subtitle" class="w-full rounded border-gray-300 text-sm">
                </div>
                <div class="col-span-2">
                    @include('admin.blocks.partials.image-upload', ['field' => 'slide.image', 'label' => 'Imagen'])
                </div>
                <div class="col-span-2">
                    @include('admin.blocks.partials.image-upload', ['field' => 'slide.mobile_image', 'label' => 'Imagen móvil (opcional)'])
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Texto botón</label>
                    <input type="text" x-model="slide.button_text" class="w-full rounded border-gray-300 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">URL botón</label>
                    <input type="text" x-model="slide.button_url" class="w-full rounded border-gray-300 text-sm">
                </div>
            </div>
        </div>
    </template>
    <button type="button" @click="slides.push({title:'',subtitle:'',image:'',mobile_image:'',button_text:'',button_url:''})" class="text-sm text-blue-600 hover:text-blue-800 font-medium">+ Agregar Slide</button>
    <input type="hidden" :name="'block_data_' + blockId" :value="JSON.stringify({slides: slides})">
</div>
