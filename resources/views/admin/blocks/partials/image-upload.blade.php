@php
    // Params expected:
    //   $field   - JS expression to read/write (e.g. "d.image" or "slide.image")
    //   $label   - field label shown above the widget
    //   $placeholder - optional placeholder text
@endphp
<div x-data="imageUploader()" class="image-upload-widget">
    <label class="block text-xs font-medium text-gray-600 mb-1">{{ $label ?? 'Imagen' }}</label>
    <div class="flex items-start gap-3">
        <div class="shrink-0 w-24 h-24 bg-gray-50 border border-gray-200 rounded-lg overflow-hidden flex items-center justify-center">
            <template x-if="{{ $field }}">
                <img :src="previewUrl({{ $field }})" class="w-full h-full object-cover" alt="">
            </template>
            <template x-if="!{{ $field }}">
                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </template>
        </div>
        <div class="flex-1 space-y-2">
            <div class="flex flex-wrap items-center gap-2">
                <input type="file" accept="image/*" @change="upload($event, v => {{ $field }} = v)" class="hidden" x-ref="fileInput">
                <button type="button" @click="$refs.fileInput.click()" :disabled="uploading"
                        class="px-3 py-1.5 bg-blue-600 text-white text-xs font-medium rounded hover:bg-blue-700 disabled:opacity-60">
                    <span x-show="!uploading">Subir imagen</span>
                    <span x-show="uploading">Subiendo...</span>
                </button>
                <button type="button" @click="$dispatch('open-media-picker', { onSelect: (path) => { {{ $field }} = path } })"
                        style="padding:.375rem .75rem;background:#374151;color:#fff;font-size:.75rem;font-weight:500;border-radius:.25rem;border:none;cursor:pointer;"
                        onmouseover="this.style.background='#1f2937'" onmouseout="this.style.background='#374151'">
                    Elegir de biblioteca
                </button>
                <button type="button" x-show="{{ $field }}" @click="{{ $field }} = ''"
                        class="px-3 py-1.5 bg-gray-100 text-gray-600 text-xs font-medium rounded hover:bg-gray-200">Quitar</button>
            </div>
            <input type="text" x-model="{{ $field }}" placeholder="{{ $placeholder ?? 'URL o ruta de la imagen' }}"
                   class="w-full rounded border-gray-300 text-xs">
            <p x-show="error" x-text="error" class="text-xs text-red-600"></p>
        </div>
    </div>
</div>
