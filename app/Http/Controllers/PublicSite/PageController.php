<?php

declare(strict_types=1);

namespace App\Http\Controllers\PublicSite;

use App\Http\Controllers\Controller;
use App\Models\Page;

class PageController extends Controller
{
    public function show(string $slug)
    {
        $query = Page::with('blocks')->where('slug', $slug);
        $isStaff = auth()->check() && auth()->user()->isStaff();
        if (! $isStaff) {
            $query->published();
        }
        $page = $query->firstOrFail();
        $isDraft = $page->status !== 'published';

        if ($page->template) {
            return view('public.' . $page->template, compact('page', 'isDraft'));
        }

        return view('public.page', compact('page', 'isDraft'));
    }
}
