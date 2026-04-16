<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nombre *</label>
            <input type="text" name="name" id="name" value="{{ old('name', $branch->name ?? '') }}" required
                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
        <div>
            <label for="city" class="block text-sm font-medium text-gray-700 mb-1">Ciudad</label>
            <input type="text" name="city" id="city" value="{{ old('city', $branch->city ?? '') }}"
                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </div>
    </div>

    <div>
        <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Dirección</label>
        <input type="text" name="address" id="address" value="{{ old('address', $branch->address ?? '') }}"
               class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label for="department" class="block text-sm font-medium text-gray-700 mb-1">Departamento</label>
            <input type="text" name="department" id="department" value="{{ old('department', $branch->department ?? '') }}"
                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </div>
        <div>
            <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
            <input type="text" name="phone" id="phone" value="{{ old('phone', $branch->phone ?? '') }}"
                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email', $branch->email ?? '') }}"
                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </div>
        <div>
            <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-1">Orden</label>
            <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $branch->sort_order ?? 0) }}"
                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label for="latitude" class="block text-sm font-medium text-gray-700 mb-1">Latitud</label>
            <input type="text" name="latitude" id="latitude" value="{{ old('latitude', $branch->latitude ?? '') }}"
                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </div>
        <div>
            <label for="longitude" class="block text-sm font-medium text-gray-700 mb-1">Longitud</label>
            <input type="text" name="longitude" id="longitude" value="{{ old('longitude', $branch->longitude ?? '') }}"
                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </div>
    </div>

    <div x-data="{ libraryPath: '' }">
        <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Imagen</label>
        @php
            $img = $branch->image ?? null;
            $imgSrc = null;
            if ($img) {
                if (preg_match('#^(https?:)?//#', $img)) $imgSrc = $img;
                elseif (str_starts_with($img, 'assets/') || str_starts_with($img, 'storage/')) $imgSrc = asset($img);
                else $imgSrc = asset('storage/' . $img);
            }
        @endphp
        @if($imgSrc)
            <div class="flex items-center gap-3 mb-2">
                <img src="{{ $imgSrc }}" class="w-32 h-20 object-cover rounded border border-gray-200" alt="">
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

    <label class="flex items-center gap-2">
        <input type="hidden" name="is_active" value="0">
        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $branch->is_active ?? true) ? 'checked' : '' }}
               class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        <span class="text-sm text-gray-700">Activa</span>
    </label>
</div>
