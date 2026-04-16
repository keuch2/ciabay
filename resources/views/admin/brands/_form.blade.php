@php
    $resolveImg = function($img) {
        if (!$img) return null;
        if (preg_match('#^(https?:)?//#', $img)) return $img;
        if (str_starts_with($img, 'assets/') || str_starts_with($img, 'storage/')) return asset($img);
        return asset('storage/' . $img);
    };
@endphp

<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-6">
    <h3 class="text-sm font-semibold text-gray-800 uppercase tracking-wider">Datos de la marca</h3>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nombre *</label>
            <input type="text" name="name" id="name" value="{{ old('name', $brand->name ?? '') }}" required
                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
        <div>
            <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
            <input type="text" name="slug" id="slug" value="{{ old('slug', $brand->slug ?? '') }}" placeholder="Auto-generado"
                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </div>
    </div>

    <div>
        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
        <textarea name="description" id="description" rows="3"
                  class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('description', $brand->description ?? '') }}</textarea>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label for="website_url" class="block text-sm font-medium text-gray-700 mb-1">Sitio Web</label>
            <input type="url" name="website_url" id="website_url" value="{{ old('website_url', $brand->website_url ?? '') }}"
                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </div>
        <div>
            <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-1">Orden</label>
            <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $brand->sort_order ?? 0) }}"
                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </div>
    </div>

    <div x-data="{ libraryPath: '' }">
        <label for="logo" class="block text-sm font-medium text-gray-700 mb-1">Logo</label>
        @php $logoSrc = $resolveImg($brand->logo ?? null); @endphp
        @if($logoSrc)
            <div class="flex items-center gap-3 mb-2">
                <img src="{{ $logoSrc }}" class="w-24 h-24 object-contain rounded border border-gray-200 bg-white p-1" alt="">
                <label class="flex items-center gap-2 text-xs text-gray-600">
                    <input type="checkbox" name="remove_logo" value="1" class="rounded border-gray-300 text-red-600">
                    Quitar logo actual
                </label>
            </div>
        @endif
        <div class="flex items-center gap-3 flex-wrap">
            <input type="file" name="logo" id="logo" accept="image/*"
                   class="text-sm text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded file:border-0 file:text-xs file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            <button type="button" @click="$dispatch('open-media-picker', { onSelect: (p) => libraryPath = p })"
                    style="padding:.375rem .75rem;background:#374151;color:#fff;font-size:.75rem;font-weight:500;border-radius:.25rem;border:none;cursor:pointer;">
                Elegir de biblioteca
            </button>
            <template x-if="libraryPath">
                <span class="text-xs text-gray-600">Biblioteca: <span x-text="libraryPath" class="font-mono"></span></span>
            </template>
        </div>
        <input type="hidden" name="library_logo" x-model="libraryPath">
    </div>

    <div class="flex items-center gap-6">
        <label class="flex items-center gap-2">
            <input type="hidden" name="is_represented" value="0">
            <input type="checkbox" name="is_represented" value="1" {{ old('is_represented', $brand->is_represented ?? true) ? 'checked' : '' }}
                   class="rounded border-gray-300 text-blue-600 shadow-sm">
            <span class="text-sm text-gray-700">Marca representada</span>
        </label>
        <label class="flex items-center gap-2">
            <input type="hidden" name="is_active" value="0">
            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $brand->is_active ?? true) ? 'checked' : '' }}
                   class="rounded border-gray-300 text-blue-600 shadow-sm">
            <span class="text-sm text-gray-700">Activa</span>
        </label>
    </div>
</div>

{{-- Catalog section --}}
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-6 mt-6" x-data="{ libraryHero: '' }">
    <div>
        <h3 class="text-sm font-semibold text-gray-800 uppercase tracking-wider">Catálogo de la marca</h3>
        <p class="text-xs text-gray-500 mt-1">Al habilitar el catálogo, se activa la página pública <code class="bg-gray-100 px-1 py-0.5 rounded">/catalogo/{{ $brand->slug ?? '{slug}' }}</code>.</p>
    </div>

    <label class="flex items-center gap-2">
        <input type="hidden" name="catalog_enabled" value="0">
        <input type="checkbox" name="catalog_enabled" value="1" {{ old('catalog_enabled', $brand->catalog_enabled ?? false) ? 'checked' : '' }}
               class="rounded border-gray-300 text-blue-600 shadow-sm">
        <span class="text-sm text-gray-700 font-medium">Catálogo habilitado</span>
    </label>

    <div>
        <label for="catalog_hero_image" class="block text-sm font-medium text-gray-700 mb-1">Imagen de hero del catálogo</label>
        @php $heroSrc = $resolveImg($brand->catalog_hero_image ?? null); @endphp
        @if($heroSrc)
            <div class="flex items-center gap-3 mb-2">
                <img src="{{ $heroSrc }}" class="w-32 h-20 object-cover rounded border border-gray-200" alt="">
                <label class="flex items-center gap-2 text-xs text-gray-600">
                    <input type="checkbox" name="remove_catalog_hero_image" value="1" class="rounded border-gray-300 text-red-600">
                    Quitar imagen actual
                </label>
            </div>
        @endif
        <div class="flex items-center gap-3 flex-wrap">
            <input type="file" name="catalog_hero_image" id="catalog_hero_image" accept="image/*"
                   class="text-sm text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded file:border-0 file:text-xs file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            <button type="button" @click="$dispatch('open-media-picker', { onSelect: (p) => libraryHero = p })"
                    style="padding:.375rem .75rem;background:#374151;color:#fff;font-size:.75rem;font-weight:500;border-radius:.25rem;border:none;cursor:pointer;">
                Elegir de biblioteca
            </button>
            <template x-if="libraryHero">
                <span class="text-xs text-gray-600">Biblioteca: <span x-text="libraryHero" class="font-mono"></span></span>
            </template>
        </div>
        <input type="hidden" name="library_catalog_hero_image" x-model="libraryHero">
    </div>

    <div>
        <label for="catalog_intro" class="block text-sm font-medium text-gray-700 mb-1">Texto de introducción</label>
        <textarea name="catalog_intro" id="catalog_intro" rows="3" placeholder="Breve descripción que aparece sobre la grilla de productos…"
                  class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('catalog_intro', $brand->catalog_intro ?? '') }}</textarea>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label for="catalog_contact_whatsapp" class="block text-sm font-medium text-gray-700 mb-1">WhatsApp del vendedor (opcional)</label>
            <input type="text" name="catalog_contact_whatsapp" id="catalog_contact_whatsapp"
                   value="{{ old('catalog_contact_whatsapp', $brand->catalog_contact_whatsapp ?? '') }}"
                   placeholder="595981000000 (si vacío usa la configuración global)"
                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </div>
        <div>
            <label for="catalog_contact_message" class="block text-sm font-medium text-gray-700 mb-1">Mensaje predefinido de WhatsApp</label>
            <input type="text" name="catalog_contact_message" id="catalog_contact_message"
                   value="{{ old('catalog_contact_message', $brand->catalog_contact_message ?? '') }}"
                   placeholder="Hola, me interesa {producto}. {url}"
                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            <p class="text-xs text-gray-400 mt-1">Podés usar <code class="bg-gray-100 px-1 rounded">{producto}</code> y <code class="bg-gray-100 px-1 rounded">{url}</code>.</p>
        </div>
    </div>
</div>
