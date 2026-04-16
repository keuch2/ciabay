<div class="space-y-3" x-data="{ d: {{ json_encode(array_merge(['title'=>'','text'=>'','button_text'=>'Contactar por WhatsApp','whatsapp_message'=>'','whatsapp_number'=>''], $data)) }} }">
    <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Título</label>
        <input type="text" x-model="d.title" class="w-full rounded border-gray-300 text-sm">
    </div>
    <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Texto</label>
        <textarea x-model="d.text" rows="2" class="w-full rounded border-gray-300 text-sm"></textarea>
    </div>
    <div class="grid grid-cols-2 gap-3">
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">Texto del botón</label>
            <input type="text" x-model="d.button_text" class="w-full rounded border-gray-300 text-sm">
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">WhatsApp (opcional, usa setting si vacío)</label>
            <input type="text" x-model="d.whatsapp_number" placeholder="595981000000" class="w-full rounded border-gray-300 text-sm">
        </div>
    </div>
    <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Mensaje pre-escrito de WhatsApp</label>
        <input type="text" x-model="d.whatsapp_message" class="w-full rounded border-gray-300 text-sm" placeholder="Hola, quiero consultar sobre...">
    </div>
    <input type="hidden" :name="'block_data_' + blockId" :value="JSON.stringify(d)">
</div>
