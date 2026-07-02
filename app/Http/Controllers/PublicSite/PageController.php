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

        $customCss = $page->custom_css;
        $customJs = $page->custom_js;
        $metaTitle = $page->meta_title;
        $metaDescription = $page->meta_description;

        $data = compact('page', 'isDraft', 'customCss', 'customJs', 'metaTitle', 'metaDescription');

        if ($page->template) {
            return view('public.' . $page->template, $data);
        }

        return view('public.page', $data);
    }
}
