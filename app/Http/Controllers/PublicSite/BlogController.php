<?php

declare(strict_types=1);

namespace App\Http\Controllers\PublicSite;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;

class BlogController extends Controller
{
    public function index()
    {
        $isStaff = auth()->check() && auth()->user()->isStaff();

        $query = BlogPost::with('category', 'author');
        if (! $isStaff) $query->published();
        $posts = $query->orderByDesc('published_at')->paginate(12);

        return view('public.blog.index', compact('posts'));
    }

    public function show(string $slug)
    {
        $isStaff = auth()->check() && auth()->user()->isStaff();

        $query = BlogPost::where('slug', $slug)->with('category', 'author');
        if (! $isStaff) $query->published();
        $post = $query->firstOrFail();

        $isDraft = $post->status !== 'published' || !$post->published_at;

        $customCss = $post->custom_css;
        $customJs = $post->custom_js;

        return view('public.blog.show', compact('post', 'isDraft', 'customCss', 'customJs'));
    }
}
