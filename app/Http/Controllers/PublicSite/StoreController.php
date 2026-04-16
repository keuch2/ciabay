<?php

declare(strict_types=1);

namespace App\Http\Controllers\PublicSite;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function show(string $slug)
    {
        $isStaff = auth()->check() && auth()->user()->isStaff();

        $query = Product::with('category')->where('slug', $slug);
        if (! $isStaff) $query->active();
        $product = $query->firstOrFail();

        $related = Product::active()
            ->where('id', '!=', $product->id)
            ->when($product->product_category_id, fn ($q) => $q->where('product_category_id', $product->product_category_id))
            ->orderBy('sort_order')
            ->limit(4)
            ->get();

        $isDraft = ! $product->is_active;

        return view('public.store.show', compact('product', 'related', 'isDraft'));
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
