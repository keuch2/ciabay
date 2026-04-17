<?php

declare(strict_types=1);

namespace App\Http\Controllers\PublicSite;

use App\Http\Controllers\Controller;
use App\Models\Page;

class HomeController extends Controller
{
    public function __invoke()
    {
        $isStaff = auth()->check() && auth()->user()->isStaff();

        $query = Page::with('blocks')->where('is_homepage', true);
        if (! $isStaff) $query->published();
        $page = $query->first();

        if (! $page) {
            $fallback = Page::with('blocks');
            if (! $isStaff) $fallback->published();
            $page = $fallback->first();
        }

        $isDraft = $page && $page->status !== 'published';

        $customCss = $page?->custom_css;
        $customJs = $page?->custom_js;

        return view('public.home', compact('page', 'isDraft', 'customCss', 'customJs'));
    }
}
