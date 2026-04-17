<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class CatalogConfigController extends Controller
{
    public function edit()
    {
        return view('admin.catalog-config.edit', [
            'columns' => (int) Setting::get('catalog_columns_default', 4),
            'perPage' => (int) Setting::get('catalog_per_page_default', 12),
            'customCss' => Setting::get('catalog_custom_css_default', ''),
            'customJs' => Setting::get('catalog_custom_js_default', ''),
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'catalog_columns_default' => 'required|integer|min:1|max:6',
            'catalog_per_page_default' => 'required|integer|min:1|max:100',
            'catalog_custom_css_default' => 'nullable|string|max:50000',
            'catalog_custom_js_default' => 'nullable|string|max:50000',
        ]);

        Setting::set('catalog_columns_default', (string) $validated['catalog_columns_default'], 'integer', 'catalog');
        Setting::set('catalog_per_page_default', (string) $validated['catalog_per_page_default'], 'integer', 'catalog');
        Setting::set('catalog_custom_css_default', $validated['catalog_custom_css_default'] ?? '', 'textarea', 'catalog');
        Setting::set('catalog_custom_js_default', $validated['catalog_custom_js_default'] ?? '', 'textarea', 'catalog');

        return redirect()->route('admin.catalog-config.edit')
            ->with('success', 'Configuración global de catálogos actualizada correctamente.');
    }
}
