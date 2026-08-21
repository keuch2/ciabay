{{-- Select de plantilla — opciones centralizadas en Page::TEMPLATES.
     Recibe $selected (valor actual, puede ser null). --}}
<select name="template" id="template"
        class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
    <option value="">Por defecto (bloques)</option>
    @foreach(\App\Models\Page::TEMPLATES as $value => $label)
        <option value="{{ $value }}" {{ $selected === $value ? 'selected' : '' }}>{{ $label }}</option>
    @endforeach
</select>
