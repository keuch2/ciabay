<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nombre *</label>
            <input type="text" name="name" id="name" value="{{ old('name', $product->name ?? '') }}" required
                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
        <div>
            <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
            <input type="text" name="slug" id="slug" value="{{ old('slug', $product->slug ?? '') }}" placeholder="Auto-generado"
                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </div>
    </div>

    <div>
        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
        <textarea name="description" id="description" rows="4"
                  class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('description', $product->description ?? '') }}</textarea>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label for="product_category_id" class="block text-sm font-medium text-gray-700 mb-1">Categoría</label>
            <select name="product_category_id" id="product_category_id"
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                <option value="">Sin categoría</option>
                @foreach($categories as $cat)
                    @if($cat->children->count())
                        <optgroup label="{{ $cat->name }}">
                            <option value="{{ $cat->id }}" {{ old('product_category_id', $product->product_category_id ?? '') == $cat->id ? 'selected' : '' }}>{{ $cat->name }} (general)</option>
                            @foreach($cat->children->sortBy('sort_order') as $child)
                                <option value="{{ $child->id }}" {{ old('product_category_id', $product->product_category_id ?? '') == $child->id ? 'selected' : '' }}>{{ $child->name }}</option>
                            @endforeach
                        </optgroup>
                    @else
                        <option value="{{ $cat->id }}" {{ old('product_category_id', $product->product_category_id ?? '') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div>
            <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Precio (Gs.)</label>
            <input type="number" name="price" id="price" value="{{ old('price', $product->price ?? '') }}" step="1" min="0"
                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </div>
        <div>
            <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-1">Orden</label>
            <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $product->sort_order ?? 0) }}"
                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </div>
    </div>

    <div>
        <label for="whatsapp_message" class="block text-sm font-medium text-gray-700 mb-1">Mensaje WhatsApp personalizado</label>
        <input type="text" name="whatsapp_message" id="whatsapp_message" value="{{ old('whatsapp_message', $product->whatsapp_message ?? '') }}"
               placeholder="Opcional: mensaje custom para este producto"
               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
    </div>

    @php
        $existingImage = $product->image ?? null;
        $existingImages = $product->images ?? [];
        $resolveImg = function($img) {
            if (!$img) return null;
            if (preg_match('#^(https?:)?//#', $img)) return $img;
            if (str_starts_with($img, 'assets/') || str_starts_with($img, 'storage/')) return asset($img);
            return asset('storage/' . $img);
        };
    @endphp

    <div x-data="{ libraryPath: '' }">
        <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Imagen principal</label>
        @if($existingImage)
            <div class="flex items-center gap-3 mb-2">
                <img src="{{ $resolveImg($existingImage) }}" class="w-32 h-32 object-cover rounded border border-gray-200" alt="">
                <label class="flex items-center gap-2 text-xs text-gray-600">
                    <input type="checkbox" name="remove_image" value="1" class="rounded border-gray-300 text-red-600">
                    Quitar imagen actual
                </label>
            </div>
        @endif
        <div class="flex items-center gap-3 flex-wrap">
            <input type="file" name="image" id="image" accept="image/*"
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
        <label class="block text-sm font-medium text-gray-700 mb-1">Galería (imágenes adicionales)</label>
        <p class="text-xs text-gray-500 mb-2">Se mostrarán en la página de detalle del producto.</p>
        @if(count($existingImages))
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3 mb-3">
                @foreach($existingImages as $img)
                    <div class="relative" style="aspect-ratio: 1 / 1;">
                        <img src="{{ $resolveImg($img) }}" class="absolute inset-0 w-full h-full object-cover rounded-lg border border-gray-200" alt="">
                        <label class="absolute top-1.5 right-1.5 bg-white/95 rounded px-1.5 py-0.5 shadow cursor-pointer text-xs flex items-center gap-1">
                            <input type="checkbox" name="remove_images[]" value="{{ $img }}" class="rounded border-gray-300 text-red-600">
                            Quitar
                        </label>
                    </div>
                @endforeach
            </div>
        @endif
        <input type="file" name="gallery_images[]" id="gallery_images" accept="image/*" multiple
               class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
    </div>

    <label class="flex items-center gap-2">
        <input type="hidden" name="is_active" value="0">
        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active ?? true) ? 'checked' : '' }}
               class="rounded border-gray-300 text-blue-600 shadow-sm">
        <span class="text-sm text-gray-700">Activo</span>
    </label>
</div>
