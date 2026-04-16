<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    public function edit()
    {
        return view('admin.tracking.edit', [
            'headHtml' => Setting::get('tracking_head_html', ''),
            'bodyHtml' => Setting::get('tracking_body_html', ''),
            'gaId' => Setting::get('google_analytics_id', ''),
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'tracking_head_html' => 'nullable|string|max:20000',
            'tracking_body_html' => 'nullable|string|max:20000',
            'google_analytics_id' => 'nullable|string|max:100',
        ]);

        Setting::set('tracking_head_html', $validated['tracking_head_html'] ?? '', 'textarea', 'tracking');
        Setting::set('tracking_body_html', $validated['tracking_body_html'] ?? '', 'textarea', 'tracking');
        Setting::set('google_analytics_id', $validated['google_analytics_id'] ?? '', 'text', 'seo');

        return redirect()->route('admin.tracking.edit')
            ->with('success', 'Códigos de seguimiento actualizados correctamente.');
    }
}
