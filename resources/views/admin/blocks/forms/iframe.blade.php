<div class="space-y-3" x-data="{ d: {{ json_encode(array_merge([
    'embed_url' => '',
    'height' => '600',
    'width_mode' => 'container',
    'width_custom' => '',
    'allow_fullscreen' => true,
    'allow_scroll' => true,
], $data)) }} }">
    <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">URL del iframe</label>
        <input type="text" x-model="d.embed_url" class="w-full rounded border-gray-300 text-sm" placeholder="https://...">
        <p class="text-xs text-gray-500 mt-1">Pegá la URL completa del contenido a embeber (formulario, video, mapa, dashboard, etc.).</p>
    </div>
    <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Altura (px)</label>
        <input type="number" min="100" step="10" x-model="d.height" class="w-full rounded border-gray-300 text-sm" placeholder="600">
    </div>
    <div>
        <label class="block text-xs font-medium text-gray-600 mb-1">Ancho</label>
        <select x-model="d.width_mode" class="w-full rounded border-gray-300 text-sm">
            <option value="container">Dentro del contenedor (recomendado)</option>
            <option value="full">Ancho completo (edge-to-edge)</option>
            <option value="custom">Personalizado</option>
        </select>
    </div>
    <div x-show="d.width_mode === 'custom'" x-cloak>
        <label class="block text-xs font-medium text-gray-600 mb-1">Ancho personalizado (CSS)</label>
        <input type="text" x-model="d.width_custom" class="w-full rounded border-gray-300 text-sm" placeholder="800px o 80%">
        <p class="text-xs text-gray-500 mt-1">Ej: <code>800px</code>, <code>90%</code>, <code>60rem</code>. El iframe se centra automáticamente.</p>
    </div>
    <div class="flex items-center gap-4 pt-1">
        <label class="inline-flex items-center text-sm text-gray-700">
            <input type="checkbox" x-model="d.allow_fullscreen" class="rounded border-gray-300 mr-2">
            Permitir pantalla completa
        </label>
        <label class="inline-flex items-center text-sm text-gray-700">
            <input type="checkbox" x-model="d.allow_scroll" class="rounded border-gray-300 mr-2">
            Permitir scroll interno
        </label>
    </div>
    <input type="hidden" :name="'block_data_' + blockId" :value="JSON.stringify(d)">
</div>
