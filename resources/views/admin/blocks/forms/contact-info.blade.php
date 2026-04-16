<div class="space-y-3" x-data="{ d: {{ json_encode(array_merge(['title'=>'Información de Contacto','form_title'=>'Envíanos un Mensaje','address'=>'','phone'=>'','email'=>'','hours'=>''], $data)) }} }">
    <p class="text-xs text-gray-500">Los campos vacíos usan los valores de Configuración. Las redes sociales se toman del grupo "Redes Sociales" en Configuración.</p>
    <div class="grid grid-cols-2 gap-3">
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">Título columna info</label>
            <input type="text" x-model="d.title" class="w-full rounded border-gray-300 text-sm">
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">Título columna formulario</label>
            <input type="text" x-model="d.form_title" class="w-full rounded border-gray-300 text-sm">
        </div>
    </div>
    <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Dirección (opcional, override)</label>
        <input type="text" x-model="d.address" class="w-full rounded border-gray-300 text-sm">
    </div>
    <div class="grid grid-cols-2 gap-3">
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">Teléfono (override)</label>
            <input type="text" x-model="d.phone" class="w-full rounded border-gray-300 text-sm">
        </div>
        <div>
            <label class="block text-xs font-medium text-gray-600 mb-1">Email (override)</label>
            <input type="text" x-model="d.email" class="w-full rounded border-gray-300 text-sm">
        </div>
    </div>
    <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Horarios</label>
        <textarea x-model="d.hours" rows="2" class="w-full rounded border-gray-300 text-sm" placeholder="Lunes a Viernes: 7:00 - 17:00&#10;Sábados: 7:00 - 12:00"></textarea>
    </div>
    <input type="hidden" :name="'block_data_' + blockId" :value="JSON.stringify(d)">
</div>
