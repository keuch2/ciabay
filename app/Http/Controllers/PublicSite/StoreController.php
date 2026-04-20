<?php

declare(strict_types=1);

namespace App\Http\Controllers\PublicSite;

use App\Http\Controllers\Controller;
use App\Models\Block;
use App\Models\Order;
use App\Models\Page;
use App\Models\Product;
use App\Models\Setting;
use App\Services\StoreFilter;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function show(string $slug)
    {
        $isStaff = auth()->check() && auth()->user()->isStaff();

        $query = Product::with('category')->where('slug', $slug);
        if (! $isStaff) $query->active();
        $product = $query->firstOrFail();

        $relatedCategoryIds = $product->categories()->pluck('product_categories.id');
        $related = Product::active()
            ->where('id', '!=', $product->id)
            ->when(
                $relatedCategoryIds->isNotEmpty(),
                fn ($q) => $q->whereHas('categories', fn ($q2) => $q2->whereIn('product_categories.id', $relatedCategoryIds))
            )
            ->orderBy('sort_order')
            ->limit(4)
            ->get();

        $isDraft = ! $product->is_active;

        $customCss = Setting::get('store_custom_css');
        $customJs = Setting::get('store_custom_js');

        return view('public.store.show', compact('product', 'related', 'isDraft', 'customCss', 'customJs'));
    }

    /**
     * AJAX endpoint: returns the rendered products grid + pagination for
     * the current multi-category filter. The tienda-online page's
     * `redcase-products` block feeds the request back to its own options
     * so `source=category|manual` keep working.
     */
    public function filterAjax(Request $request)
    {
        $blockId = (int) $request->query('block', 0);
        $blockData = [];
        if ($blockId) {
            $block = Block::find($blockId);
            if ($block && $block->type === 'redcase-products') {
                $blockData = $block->data ?? [];
            }
        }

        $filterSlugs = StoreFilter::slugsFromRequest();
        $query = StoreFilter::productsQuery($blockData, $filterSlugs);

        $perPage = !empty($blockData['per_page'])
            ? (int) $blockData['per_page']
            : (int) Setting::get('store_per_page', 12);
        if ($perPage < 1) $perPage = 12;

        $source = $blockData['source'] ?? 'all';
        if ($source === 'manual') {
            $products = $query->get();
            $paginated = null;
        } else {
            $paginated = $query->paginate($perPage)->withQueryString();
            $products = $paginated;
        }

        $showPrice = (bool) ($blockData['show_price'] ?? true);
        $resolveImg = fn ($img) => $this->resolveImgPath($img);

        $html = view('blocks.partials.redcase-products-results', compact(
            'products', 'paginated', 'showPrice', 'resolveImg'
        ))->render();

        return response()->json([
            'html' => $html,
            'total' => $products instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator ? $products->total() : $products->count(),
        ]);
    }

    private function resolveImgPath($img): ?string
    {
        if (! $img) return null;
        if (preg_match('#^(https?:)?//#', $img)) return $img;
        if (str_starts_with($img, 'assets/') || str_starts_with($img, 'storage/')) return asset($img);
        return asset('storage/' . $img);
    }

    public function order(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:50',
            'customer_email' => 'nullable|email|max:255',
            'message' => 'nullable|string|max:1000',
        ]);

        $product = Product::findOrFail($validated['product_id']);

        Order::create([
            ...$validated,
            'whatsapp_sent_at' => now(),
        ]);

        $whatsappNumber = Setting::get('whatsapp_number', '595983730082');
        $template = Setting::get('whatsapp_message_template', 'Hola, soy {nombre} ({telefono}). Me interesa el producto: {producto}. {mensaje}');

        $whatsappText = str_replace(
            ['{nombre}', '{telefono}', '{producto}', '{mensaje}'],
            [$validated['customer_name'], $validated['customer_phone'], $product->name, $validated['message'] ?? ''],
            $template
        );

        $whatsappUrl = 'https://wa.me/' . $whatsappNumber . '?text=' . urlencode(trim($whatsappText));

        return response()->json([
            'success' => true,
            'redirect' => $whatsappUrl,
        ]);
    }
}
