@extends('layouts.admin', ['title' => 'Tema (Colores y Tipografía)'])

@section('content')
<form action="{{ route('admin.theme.update') }}" method="POST" class="max-w-3xl">
    @csrf @method('PUT')

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg mb-6 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
        <h3 class="text-sm font-semibold text-gray-800 uppercase tracking-wider mb-4">Colores</h3>
        <p class="text-xs text-gray-500 mb-4">Estos colores se inyectan como variables CSS y se aplican automáticamente al sitio público.</p>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach([
                'theme_color_primary' => ['Color primario', 'Azul principal (botones, headers)'],
                'theme_color_secondary' => ['Color secundario', 'Gris de fondo'],
                'theme_color_accent' => ['Color de acento', 'Verde Case IH'],
                'theme_color_cta' => ['Color CTA (rojo)', 'Botones de llamada a la acción'],
                'theme_color_text' => ['Color de texto', 'Cuerpo de texto'],
                'theme_color_text_light' => ['Color de texto claro', 'Texto secundario'],
            ] as $key => [$label, $help])
                <div>
                    <label for="{{ $key }}" class="block text-sm font-medium text-gray-700 mb-1">{{ $label }}</label>
                    <div class="flex items-center gap-2">
                        <input type="color" value="{{ $theme[$key] ?: '#000000' }}" onchange="document.getElementById('{{ $key }}').value = this.value"
                               class="h-10 w-14 rounded border border-gray-300 cursor-pointer">
                        <input type="text" name="{{ $key }}" id="{{ $key }}" value="{{ $theme[$key] }}" placeholder="#000000"
                               class="flex-1 rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm font-mono">
                    </div>
                    <p class="text-xs text-gray-400 mt-1">{{ $help }}</p>
                </div>
            @endforeach
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
        <h3 class="text-sm font-semibold text-gray-800 uppercase tracking-wider mb-4">Tipografía</h3>
        <div class="space-y-4">
            <div>
                <label for="theme_font_family" class="block text-sm font-medium text-gray-700 mb-1">Familia tipográfica principal</label>
                <input type="text" name="theme_font_family" id="theme_font_family" value="{{ $theme['theme_font_family'] }}"
                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" placeholder="Montserrat">
                <p class="text-xs text-gray-400 mt-1">Nombre de la fuente (ej: Montserrat, Inter, Roboto).</p>
            </div>
            <div>
                <label for="theme_font_url" class="block text-sm font-medium text-gray-700 mb-1">URL de importación (Google Fonts u otra)</label>
                <input type="text" name="theme_font_url" id="theme_font_url" value="{{ $theme['theme_font_url'] }}"
                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" placeholder="https://fonts.googleapis.com/css2?family=...">
                <p class="text-xs text-gray-400 mt-1">Se carga en el &lt;head&gt; del sitio público.</p>
            </div>
            <div>
                <label for="theme_font_size_base" class="block text-sm font-medium text-gray-700 mb-1">Tamaño base</label>
                <input type="text" name="theme_font_size_base" id="theme_font_size_base" value="{{ $theme['theme_font_size_base'] }}"
                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" placeholder="16px">
            </div>
            <hr class="border-gray-100">
            <div>
                <label for="theme_heading_font_family" class="block text-sm font-medium text-gray-700 mb-1">Familia tipográfica de títulos (opcional)</label>
                <input type="text" name="theme_heading_font_family" id="theme_heading_font_family" value="{{ $theme['theme_heading_font_family'] }}"
                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
            </div>
            <div>
                <label for="theme_heading_font_url" class="block text-sm font-medium text-gray-700 mb-1">URL de importación de títulos (opcional)</label>
                <input type="text" name="theme_heading_font_url" id="theme_heading_font_url" value="{{ $theme['theme_heading_font_url'] }}"
                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-6">
        <h3 class="text-sm font-semibold text-gray-800 uppercase tracking-wider mb-4">Vista Previa</h3>
        <div class="border border-gray-200 rounded-lg p-6" style="background: {{ $theme['theme_color_secondary'] }}; font-family: '{{ $theme['theme_font_family'] }}', sans-serif;">
            <h2 class="text-2xl font-bold mb-2" style="color: {{ $theme['theme_color_primary'] }}">Título principal</h2>
            <p class="mb-4" style="color: {{ $theme['theme_color_text'] }}">Texto de ejemplo con la tipografía y colores seleccionados.</p>
            <button type="button" class="px-5 py-2 rounded font-semibold text-white" style="background: {{ $theme['theme_color_primary'] }}">Botón primario</button>
            <button type="button" class="px-5 py-2 rounded font-semibold text-white ml-2" style="background: {{ $theme['theme_color_accent'] }}">Botón acento</button>
            <button type="button" class="px-5 py-2 rounded font-semibold text-white ml-2" style="background: {{ $theme['theme_color_cta'] }}">Botón CTA</button>
        </div>
    </div>

    <div class="flex items-center gap-3">
        <button type="submit" class="bg-blue-600 text-white px-6 py-2.5 rounded-lg text-sm font-medium hover:bg-blue-700">
            Guardar Tema
        </button>
        <a href="{{ url('/') }}" target="_blank" class="text-sm text-blue-600 hover:text-blue-800">Ver sitio público</a>
    </div>
</form>
@endsection
