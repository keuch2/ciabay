@php
    $resolveImg = function($img) {
        if (!$img) return null;
        if (preg_match('#^(https?:)?//#', $img)) return $img;
        if (str_starts_with($img, 'assets/') || str_starts_with($img, 'storage/')) return asset($img);
        return asset('storage/' . $img);
    };
    $imgSrc = $resolveImg($category->image ?? null);
@endphp
<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-4">
    <div>
        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nombre *</label>
        <input type="text" name="name" id="name" value="{{ old('name', $category->name ?? '') }}" required
               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
        <input type="text" name="slug" id="slug" value="{{ old('slug', $category->slug ?? '') }}" placeholder="Auto-generado desde el nombre"
               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        @error('slug') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
    <div>
        <label for="parent_id" class="block text-sm font-medium text-gray-700 mb-1">Categoría padre <span class="text-gray-400 font-normal">(opcional — convierte en subcategoría)</span></label>
        <select name="parent_id" id="parent_id"
                class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            <option value="">— Categoría raíz —</option>
            @foreach($parents as $parent)
                <option value="{{ $parent->id }}" {{ old('parent_id', $category->parent_id ?? '') == $parent->id ? 'selected' : '' }}>{{ $parent->name }}</option>
            @endforeach
        </select>
        @error('parent_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <div x-data="{ libraryPath: '' }">
        <label class="block text-sm font-medium text-gray-700 mb-1">Imagen / Ícono <span class="text-gray-400 font-normal">(opcional — se muestra en el filtro de categorías)</span></label>
        @if($imgSrc)
            <div class="flex items-center gap-3 mb-2">
                <img src="{{ $imgSrc }}" class="w-16 h-16 object-cover rounded border border-gray-200" alt="">
                <label class="flex items-center gap-2 text-xs text-gray-600">
                    <input type="checkbox" name="remove_image" value="1" class="rounded border-gray-300 text-red-600">
                    Quitar imagen actual
                </label>
            </div>
        @endif
        <div class="flex items-center gap-3 flex-wrap">
            <input type="file" name="image" accept="image/*"
                   class="text-sm text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded file:border-0 file:text-xs file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            <button type="button" @click="$dispatch('open-media-picker', { onSelect: (p) => libraryPath = p })"
                    style="padding:.375rem .75rem;background:#374151;color:#fff;font-size:.75rem;font-weight:500;border-radius:.25rem;border:none;cursor:pointer;">
                Elegir de biblioteca
            </button>
            <template x-if="libraryPath">
                <span class="text-xs text-gray-600">Biblioteca: <span x-text="libraryPath" class="font-mono"></span></span>
            </template>
        </div>
        <input type="hidden" name="library_image" x-model="libraryPath">
    </div>

    <div>
        <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-1">Orden</label>
        <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $category->sort_order ?? 0) }}"
               class="w-32 rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
    </div>
</div>
