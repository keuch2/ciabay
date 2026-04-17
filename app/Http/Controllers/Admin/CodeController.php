<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class CodeController extends Controller
{
    public function edit()
    {
        return view('admin.code.edit', [
            'globalCss' => Setting::get('global_custom_css', ''),
            'globalJs' => Setting::get('global_custom_js', ''),
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'global_custom_css' => 'nullable|string|max:50000',
            'global_custom_js' => 'nullable|string|max:50000',
        ]);

        Setting::set('global_custom_css', $validated['global_custom_css'] ?? '', 'textarea', 'code');
        Setting::set('global_custom_js', $validated['global_custom_js'] ?? '', 'textarea', 'code');

        return redirect()->route('admin.code.edit')
            ->with('success', 'Código global actualizado correctamente.');
    }
}
