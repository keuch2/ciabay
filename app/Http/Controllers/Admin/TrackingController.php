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
            'footerHtml' => Setting::get('tracking_footer_html', ''),
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'tracking_head_html' => 'nullable|string|max:20000',
            'tracking_body_html' => 'nullable|string|max:20000',
            'tracking_footer_html' => 'nullable|string|max:20000',
        ]);

        Setting::set('tracking_head_html', $validated['tracking_head_html'] ?? '', 'textarea', 'tracking');
        Setting::set('tracking_body_html', $validated['tracking_body_html'] ?? '', 'textarea', 'tracking');
        Setting::set('tracking_footer_html', $validated['tracking_footer_html'] ?? '', 'textarea', 'tracking');

        return redirect()->route('admin.tracking.edit')
            ->with('success', 'Códigos de seguimiento actualizados correctamente.');
    }
}
