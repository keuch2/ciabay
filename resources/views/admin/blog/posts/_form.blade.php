<div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Título *</label>
            <input type="text" name="title" id="title" value="{{ old('title', $post->title ?? '') }}" required
                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            @error('title') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>
        <div>
            <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
            <input type="text" name="slug" id="slug" value="{{ old('slug', $post->slug ?? '') }}" placeholder="Auto-generado"
                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </div>
    </div>

    <div>
        <label for="excerpt" class="block text-sm font-medium text-gray-700 mb-1">Extracto</label>
        <textarea name="excerpt" id="excerpt" rows="2"
                  class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('excerpt', $post->excerpt ?? '') }}</textarea>
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Contenido</label>
        <div id="quill-editor" style="min-height:300px;">{!! old('content', $post->content ?? '') !!}</div>
        <input type="hidden" name="content" id="content-input">
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label for="blog_category_id" class="block text-sm font-medium text-gray-700 mb-1">Categoría</label>
            <select name="blog_category_id" id="blog_category_id"
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                <option value="">Sin categoría</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ old('blog_category_id', $post->blog_category_id ?? '') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
            <select name="status" id="status"
                    class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                <option value="draft" {{ old('status', $post->status ?? 'draft') === 'draft' ? 'selected' : '' }}>Borrador</option>
                <option value="published" {{ old('status', $post->status ?? '') === 'published' ? 'selected' : '' }}>Publicado</option>
            </select>
        </div>
        <div>
            <label for="published_at" class="block text-sm font-medium text-gray-700 mb-1">Fecha publicación</label>
            <input type="date" name="published_at" id="published_at"
                   value="{{ old('published_at', isset($post) && $post->published_at ? $post->published_at->format('Y-m-d') : '') }}"
                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
        </div>
    </div>

    <div>
        <label for="featured_image" class="block text-sm font-medium text-gray-700 mb-1">Imagen destacada</label>
        @if(!empty($post->featured_image))
            <img src="{{ asset('storage/' . $post->featured_image) }}" class="w-48 h-32 object-cover rounded mb-2" alt="">
        @endif
        <input type="file" name="featured_image" id="featured_image" accept="image/*"
               class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
    </div>

    <details class="border-t border-gray-200 pt-4">
        <summary class="cursor-pointer text-sm font-semibold text-gray-800 uppercase tracking-wider">Código personalizado</summary>
        <p class="text-xs text-gray-500 mt-2 mb-3">Sólo se aplica a este post.</p>
        <div class="space-y-4">
            <div>
                <label for="custom_css" class="block text-sm font-medium text-gray-700 mb-1">CSS</label>
                <textarea name="custom_css" id="custom_css" rows="6"
                          class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-xs font-mono"
                          placeholder=".post-hero { background: #000; }">{{ old('custom_css', $post->custom_css ?? '') }}</textarea>
            </div>
            <div>
                <label for="custom_js" class="block text-sm font-medium text-gray-700 mb-1">JavaScript</label>
                <textarea name="custom_js" id="custom_js" rows="6"
                          class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-xs font-mono"
                          placeholder="">{{ old('custom_js', $post->custom_js ?? '') }}</textarea>
            </div>
        </div>
    </details>
</div>

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
<script>
const quill = new Quill('#quill-editor', {
    theme: 'snow',
    modules: {
        toolbar: [
            [{ header: [2, 3, 4, false] }],
            ['bold', 'italic', 'underline', 'strike'],
            [{ list: 'ordered' }, { list: 'bullet' }],
            ['blockquote', 'link', 'image'],
            ['clean']
        ]
    }
});

document.querySelector('form').addEventListener('submit', function() {
    document.getElementById('content-input').value = quill.root.innerHTML;
});
</script>
@endpush
