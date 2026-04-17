<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class StoreConfigController extends Controller
{
    public function edit()
    {
        return view('admin.store-config.edit', [
            'columns' => (int) Setting::get('store_columns', 4),
            'perPage' => (int) Setting::get('store_per_page', 12),
            'customCss' => Setting::get('store_custom_css', ''),
            'customJs' => Setting::get('store_custom_js', ''),
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'store_columns' => 'required|integer|min:1|max:6',
            'store_per_page' => 'required|integer|min:1|max:100',
            'store_custom_css' => 'nullable|string|max:50000',
            'store_custom_js' => 'nullable|string|max:50000',
        ]);

        Setting::set('store_columns', (string) $validated['store_columns'], 'integer', 'store');
        Setting::set('store_per_page', (string) $validated['store_per_page'], 'integer', 'store');
        Setting::set('store_custom_css', $validated['store_custom_css'] ?? '', 'textarea', 'store');
        Setting::set('store_custom_js', $validated['store_custom_js'] ?? '', 'textarea', 'store');

        return redirect()->route('admin.store-config.edit')
            ->with('success', 'Configuración de la tienda actualizada correctamente.');
    }
}
