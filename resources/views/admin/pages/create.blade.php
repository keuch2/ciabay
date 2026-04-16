@extends('layouts.admin', ['title' => 'Nueva Página'])

@section('content')
<div class="max-w-3xl">
    <form action="{{ route('admin.pages.store') }}" method="POST">
        @csrf
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 space-y-6">
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Título *</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" required
                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                @error('title') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="slug" class="block text-sm font-medium text-gray-700 mb-1">Slug (URL)</label>
                <input type="text" name="slug" id="slug" value="{{ old('slug') }}" placeholder="Se genera automáticamente del título"
                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                @error('slug') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="template" class="block text-sm font-medium text-gray-700 mb-1">Template (opcional)</label>
                <select name="template" id="template" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Por defecto (bloques)</option>
                    <option value="contact" {{ old('template') === 'contact' ? 'selected' : '' }}>Contacto</option>
                    <option value="store" {{ old('template') === 'store' ? 'selected' : '' }}>Tienda</option>
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                    <select name="status" id="status" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Borrador</option>
                        <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Publicada</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <label class="flex items-center gap-2">
                        <input type="hidden" name="is_homepage" value="0">
                        <input type="checkbox" name="is_homepage" value="1" {{ old('is_homepage') ? 'checked' : '' }}
                               class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <span class="text-sm text-gray-700">Página de inicio</span>
                    </label>
                </div>
            </div>

            <div>
                <label for="meta_title" class="block text-sm font-medium text-gray-700 mb-1">Meta Title (SEO)</label>
                <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title') }}"
                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            <div>
                <label for="meta_description" class="block text-sm font-medium text-gray-700 mb-1">Meta Description (SEO)</label>
                <textarea name="meta_description" id="meta_description" rows="2"
                          class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('meta_description') }}</textarea>
            </div>
        </div>

        <div class="mt-6 flex items-center gap-4">
            <button type="submit" class="bg-blue-600 text-white px-6 py-2.5 rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors">
                Crear Página
            </button>
            <a href="{{ route('admin.pages.index') }}" class="text-sm text-gray-500 hover:text-gray-700">Cancelar</a>
        </div>
    </form>
</div>
@endsection
