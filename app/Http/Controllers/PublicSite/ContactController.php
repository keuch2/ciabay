<?php

declare(strict_types=1);

namespace App\Http\Controllers\PublicSite;

use App\Http\Controllers\Controller;
use App\Models\ContactSubmission;
use App\Models\Page;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function show()
    {
        $isStaff = auth()->check() && auth()->user()->isStaff();

        $query = Page::with('blocks')->where('slug', 'contacto');
        if (! $isStaff) $query->published();
        $page = $query->first();

        $isDraft = $page && $page->status !== 'published';

        return view('public.page', compact('page', 'isDraft'));
    }

    public function submit(Request $request)
    {
        if ($request->filled('website')) {
            return redirect()->back()->with('success', 'Mensaje enviado correctamente.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:50',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        ContactSubmission::create([
            ...$validated,
            'ip_address' => $request->ip(),
        ]);

        return redirect()->back()->with('success', 'Mensaje enviado correctamente. Nos pondremos en contacto pronto.');
    }
}
