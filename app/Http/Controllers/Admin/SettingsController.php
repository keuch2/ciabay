<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = Setting::orderBy('group')->orderBy('key')->get()->groupBy('group');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'settings' => 'nullable|array',
            'settings.*' => 'nullable|string|max:5000',
            'files' => 'nullable|array',
            'files.*' => 'nullable|file|max:4096',
            'clear' => 'nullable|array',
        ]);

        $textValues = (array) $request->input('settings', []);
        $files = (array) $request->file('files', []);
        $clear = (array) $request->input('clear', []);

        foreach ($textValues as $key => $value) {
            $setting = Setting::where('key', $key)->first();
            if (! $setting) continue;

            // Uploaded file takes priority; then clear flag; then text value
            if (isset($files[$key]) && $files[$key] && $files[$key]->isValid()) {
                // Delete the old uploaded file (only storage-managed ones, not assets/)
                if ($setting->value && !str_starts_with(ltrim($setting->value, '/'), 'assets/') && !preg_match('#^(https?:)?//#', $setting->value)) {
                    Storage::disk('public')->delete(ltrim($setting->value, '/storage/'));
                }
                $path = $files[$key]->store('uploads/settings', 'public');
                $setting->update(['value' => $path]);
            } elseif (!empty($clear[$key])) {
                if ($setting->value && !str_starts_with(ltrim($setting->value, '/'), 'assets/') && !preg_match('#^(https?:)?//#', $setting->value)) {
                    Storage::disk('public')->delete(ltrim($setting->value, '/storage/'));
                }
                $setting->update(['value' => '']);
            } else {
                $setting->update(['value' => $value ?? '']);
            }
        }

        return redirect()->route('admin.settings.index')
            ->with('success', 'Configuración actualizada correctamente.');
    }
}
