@extends('layouts.admin', ['title' => 'Configuración'])

@section('content')
<form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
    @csrf @method('PUT')

    @php
        $resolveImg = function ($value) {
            if (!$value) return null;
            if (preg_match('#^(https?:)?//#', $value)) return $value;
            $v = ltrim($value, '/');
            if (str_starts_with($v, 'assets/') || str_starts_with($v, 'storage/')) return asset($v);
            return asset('storage/' . $v);
        };
    @endphp

    @foreach($settings as $group => $items)
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
            <h3 class="text-sm font-semibold text-gray-800 uppercase tracking-wider mb-4">
                {{ ['general' => 'General', 'contact' => 'Contacto', 'whatsapp' => 'WhatsApp', 'social' => 'Redes Sociales', 'topbar' => 'Barra Superior', 'footer' => 'Footer', 'seo' => 'SEO / Tracking', 'maps' => 'Mapas'][$group] ?? ucfirst($group) }}
            </h3>
            <div class="space-y-4">
                @foreach($items as $setting)
                    <div>
                        <label for="setting-{{ $setting->key }}" class="block text-sm font-medium text-gray-700 mb-1">
                            {{ str_replace('_', ' ', ucfirst(str_replace($group . '_', '', $setting->key))) }}
                        </label>
                        @if($setting->type === 'image')
                            @php $currentImg = $resolveImg($setting->value); @endphp
                            <div class="flex items-start gap-4">
                                <div class="shrink-0 w-24 h-24 bg-gray-50 border border-gray-200 rounded-lg overflow-hidden flex items-center justify-center">
                                    @if($currentImg)
                                        <img src="{{ $currentImg }}" alt="" class="w-full h-full object-contain">
                                    @else
                                        <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    @endif
                                </div>
                                <div class="flex-1 space-y-2">
                                    <input type="file" name="files[{{ $setting->key }}]" id="setting-{{ $setting->key }}"
                                           accept="{{ str_ends_with($setting->key, 'favicon') ? 'image/*,.ico' : 'image/*' }}"
                                           class="w-full text-xs text-gray-500 file:mr-3 file:py-1.5 file:px-3 file:rounded file:border-0 file:text-xs file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                    <div class="flex items-center gap-2">
                                        <input type="text" name="settings[{{ $setting->key }}]" value="{{ $setting->value }}"
                                               class="flex-1 rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-xs font-mono">
                                        <label class="text-xs text-gray-500 flex items-center gap-1 whitespace-nowrap">
                                            <input type="checkbox" name="clear[{{ $setting->key }}]" value="1" class="rounded border-gray-300 text-red-600">
                                            Quitar
                                        </label>
                                    </div>
                                    <p class="text-xs text-gray-400">Subí un archivo o pegá una ruta/URL directa.</p>
                                </div>
                            </div>
                        @elseif($setting->type === 'textarea')
                            <textarea name="settings[{{ $setting->key }}]" id="setting-{{ $setting->key }}" rows="3"
                                      class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">{{ $setting->value }}</textarea>
                        @elseif($setting->type === 'bool')
                            <select name="settings[{{ $setting->key }}]" id="setting-{{ $setting->key }}"
                                    class="rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                                <option value="1" {{ $setting->value ? 'selected' : '' }}>Sí</option>
                                <option value="0" {{ !$setting->value ? 'selected' : '' }}>No</option>
                            </select>
                        @else
                            <input type="text" name="settings[{{ $setting->key }}]" id="setting-{{ $setting->key }}"
                                   value="{{ $setting->value }}"
                                   class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach

    <button type="submit" class="bg-blue-600 text-white px-6 py-2.5 rounded-lg text-sm font-medium hover:bg-blue-700">
        Guardar Configuración
    </button>
</form>
@endsection
