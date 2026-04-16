<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Navigation;
use App\Models\NavigationItem;
use App\Models\Page;
use Illuminate\Http\Request;

class NavigationController extends Controller
{
    public function index()
    {
        $navigations = Navigation::with('allItems.page')->get();
        return view('admin.navigation.index', compact('navigations'));
    }

    public function edit(Navigation $navigation)
    {
        $navigation->load('allItems.children.page', 'items.children');
        $pages = Page::published()->orderBy('title')->get();
        return view('admin.navigation.edit', compact('navigation', 'pages'));
    }

    public function storeItem(Request $request, Navigation $navigation)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'url' => 'nullable|string|max:500',
            'target' => 'required|in:_self,_blank',
            'page_id' => 'nullable|exists:pages,id',
            'parent_id' => 'nullable|exists:navigation_items,id',
        ]);

        $maxOrder = $navigation->allItems()->where('parent_id', $validated['parent_id'] ?? null)->max('sort_order') ?? 0;

        $item = $navigation->allItems()->create([
            ...$validated,
            'sort_order' => $maxOrder + 1,
        ]);

        return response()->json(['success' => true, 'item' => $item->load('page')]);
    }

    public function updateItem(Request $request, Navigation $navigation, NavigationItem $item)
    {
        $validated = $request->validate([
            'label' => 'required|string|max:255',
            'url' => 'nullable|string|max:500',
            'target' => 'required|in:_self,_blank',
            'page_id' => 'nullable|exists:pages,id',
            'parent_id' => 'nullable|exists:navigation_items,id',
        ]);

        $item->update($validated);

        return response()->json(['success' => true, 'item' => $item->load('page')]);
    }

    public function destroyItem(Navigation $navigation, NavigationItem $item)
    {
        $item->children()->delete();
        $item->delete();

        return response()->json(['success' => true]);
    }

    public function reorderItems(Request $request, Navigation $navigation)
    {
        $validated = $request->validate([
            'order' => 'required|array',
            'order.*.id' => 'required|integer|exists:navigation_items,id',
            'order.*.parent_id' => 'nullable|integer',
            'order.*.sort_order' => 'required|integer',
        ]);

        foreach ($validated['order'] as $item) {
            NavigationItem::where('id', $item['id'])
                ->where('navigation_id', $navigation->id)
                ->update([
                    'parent_id' => $item['parent_id'],
                    'sort_order' => $item['sort_order'],
                ]);
        }

        return response()->json(['success' => true]);
    }
}
