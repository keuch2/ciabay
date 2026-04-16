<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class ThemeController extends Controller
{
    public const DEFAULTS = [
        'theme_color_primary' => '#112f83',
        'theme_color_secondary' => '#e8e8e8',
        'theme_color_accent' => '#6da339',
        'theme_color_text' => '#333333',
        'theme_color_text_light' => '#666666',
        'theme_color_cta' => '#d32f2f',
        'theme_font_family' => 'Montserrat',
        'theme_font_url' => 'https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap',
        'theme_font_size_base' => '16px',
        'theme_heading_font_family' => '',
        'theme_heading_font_url' => '',
    ];

    public function edit()
    {
        $theme = [];
        foreach (self::DEFAULTS as $key => $default) {
            $theme[$key] = Setting::get($key, $default);
        }
        return view('admin.theme.edit', compact('theme'));
    }

    public function update(Request $request)
    {
        $rules = [];
        foreach (array_keys(self::DEFAULTS) as $key) {
            $rules[$key] = 'nullable|string|max:500';
        }
        $validated = $request->validate($rules);

        foreach (array_keys(self::DEFAULTS) as $key) {
            Setting::set($key, $validated[$key] ?? '', 'text', 'theme');
        }

        return redirect()->route('admin.theme.edit')
            ->with('success', 'Tema actualizado correctamente.');
    }

    public static function cssVariables(): string
    {
        $map = [
            '--color-primary' => 'theme_color_primary',
            '--color-secondary' => 'theme_color_secondary',
            '--color-accent' => 'theme_color_accent',
            '--color-text' => 'theme_color_text',
            '--color-text-light' => 'theme_color_text_light',
            '--color-cta' => 'theme_color_cta',
        ];

        $lines = [];
        foreach ($map as $var => $key) {
            $value = Setting::get($key, self::DEFAULTS[$key] ?? '');
            if ($value !== '' && $value !== null) {
                $lines[] = sprintf('%s: %s;', $var, $value);
            }
        }

        $font = Setting::get('theme_font_family', self::DEFAULTS['theme_font_family']);
        if ($font) {
            $lines[] = sprintf("--font-primary: '%s', sans-serif;", addslashes($font));
        }
        $fontSize = Setting::get('theme_font_size_base', self::DEFAULTS['theme_font_size_base']);
        if ($fontSize) {
            $lines[] = sprintf('--font-size-base: %s;', $fontSize);
        }

        if (empty($lines)) {
            return '';
        }

        return ":root{\n" . implode("\n", $lines) . "\n}\nbody{font-size:var(--font-size-base,16px);}";
    }

    public static function fontImports(): array
    {
        $urls = [];
        $primary = Setting::get('theme_font_url', self::DEFAULTS['theme_font_url']);
        if ($primary) {
            $urls[] = $primary;
        }
        $heading = Setting::get('theme_heading_font_url', '');
        if ($heading && $heading !== $primary) {
            $urls[] = $heading;
        }
        return $urls;
    }
}
