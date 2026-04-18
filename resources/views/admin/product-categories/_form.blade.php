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
    <div>
        <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-1">Orden</label>
        <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $category->sort_order ?? 0) }}"
               class="w-32 rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
    </div>
</div>
