<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicSite;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', PublicSite\HomeController::class)->name('home');
Route::get('/contacto', [PublicSite\ContactController::class, 'show'])->name('contact');
Route::post('/contacto', [PublicSite\ContactController::class, 'submit'])->name('contact.submit');
Route::get('/blog', [PublicSite\BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [PublicSite\BlogController::class, 'show'])->name('blog.show');
Route::post('/tienda-online/pedido', [PublicSite\StoreController::class, 'order'])->name('store.order');
Route::get('/tienda-online/{slug}', [PublicSite\StoreController::class, 'show'])->name('store.show');
// Note: /tienda-online (index) is handled by the catch-all PageController with block-based rendering.

// Brand catalogs (escaparate por marca)
Route::get('/catalogo/{brandSlug}', [PublicSite\BrandCatalogController::class, 'show'])->name('catalog.show');
Route::get('/catalogo/{brandSlug}/{productSlug}', [PublicSite\BrandCatalogController::class, 'product'])->name('catalog.product');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->middleware(['auth', 'verified'])->name('admin.')->group(function () {
    Route::get('/', Admin\DashboardController::class)->name('dashboard');

    // Pages & Blocks
    Route::resource('pages', Admin\PageController::class)->except(['show']);
    Route::post('pages/{page}/blocks', [Admin\PageController::class, 'storeBlock'])->name('pages.blocks.store');
    Route::put('pages/{page}/blocks/{block}', [Admin\PageController::class, 'updateBlock'])->name('pages.blocks.update');
    Route::delete('pages/{page}/blocks/{block}', [Admin\PageController::class, 'destroyBlock'])->name('pages.blocks.destroy');
    Route::post('pages/{page}/blocks/reorder', [Admin\PageController::class, 'reorderBlocks'])->name('pages.blocks.reorder');

    // Navigation
    Route::get('navigation', [Admin\NavigationController::class, 'index'])->name('navigation.index');
    Route::get('navigation/{navigation}/edit', [Admin\NavigationController::class, 'edit'])->name('navigation.edit');
    Route::post('navigation/{navigation}/items', [Admin\NavigationController::class, 'storeItem'])->name('navigation.items.store');
    Route::put('navigation/{navigation}/items/{item}', [Admin\NavigationController::class, 'updateItem'])->name('navigation.items.update');
    Route::delete('navigation/{navigation}/items/{item}', [Admin\NavigationController::class, 'destroyItem'])->name('navigation.items.destroy');
    Route::post('navigation/{navigation}/reorder', [Admin\NavigationController::class, 'reorderItems'])->name('navigation.reorder');

    // Branches
    Route::resource('branches', Admin\BranchController::class)->except(['show']);

    // Brands
    Route::resource('brands', Admin\BrandController::class)->except(['show']);

    // Brand catalogs (categories + products scoped under each brand)
    Route::prefix('brands/{brand}/catalog')->name('brands.catalog.')->group(function () {
        Route::get('/', [Admin\BrandCatalogController::class, 'show'])->name('show');
        Route::put('config', [Admin\BrandCatalogController::class, 'updateConfig'])->name('config.update');

        Route::get('categories/create', [Admin\CatalogCategoryController::class, 'create'])->name('categories.create');
        Route::post('categories', [Admin\CatalogCategoryController::class, 'store'])->name('categories.store');
        Route::get('categories/{category}/edit', [Admin\CatalogCategoryController::class, 'edit'])
            ->name('categories.edit')
            ->whereNumber('category');
        Route::put('categories/{category}', [Admin\CatalogCategoryController::class, 'update'])
            ->name('categories.update')
            ->whereNumber('category');
        Route::delete('categories/{category}', [Admin\CatalogCategoryController::class, 'destroy'])
            ->name('categories.destroy')
            ->whereNumber('category');

        Route::get('products/create', [Admin\CatalogProductController::class, 'create'])->name('products.create');
        Route::post('products', [Admin\CatalogProductController::class, 'store'])->name('products.store');
        Route::get('products/{product}/edit', [Admin\CatalogProductController::class, 'edit'])
            ->name('products.edit')
            ->whereNumber('product');
        Route::put('products/{product}', [Admin\CatalogProductController::class, 'update'])
            ->name('products.update')
            ->whereNumber('product');
        Route::delete('products/{product}', [Admin\CatalogProductController::class, 'destroy'])
            ->name('products.destroy')
            ->whereNumber('product');
    });

    // Products
    Route::resource('products', Admin\ProductController::class)->except(['show']);
    Route::resource('product-categories', Admin\ProductCategoryController::class)
        ->except(['show'])
        ->names('product-categories')
        ->parameters(['product-categories' => 'productCategory']);

    // Orders
    Route::get('orders', [Admin\OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [Admin\OrderController::class, 'show'])->name('orders.show');
    Route::patch('orders/{order}/status', [Admin\OrderController::class, 'updateStatus'])->name('orders.status');

    // Blog
    Route::resource('blog/posts', Admin\BlogPostController::class)->names('blog.posts')->except(['show']);

    // Contacts
    Route::get('contacts', [Admin\ContactSubmissionController::class, 'index'])->name('contacts.index');
    Route::get('contacts/{contact}', [Admin\ContactSubmissionController::class, 'show'])->name('contacts.show');
    Route::patch('contacts/{contact}/status', [Admin\ContactSubmissionController::class, 'updateStatus'])->name('contacts.status');
    Route::delete('contacts/{contact}', [Admin\ContactSubmissionController::class, 'destroy'])->name('contacts.destroy');

    // Media
    Route::get('media', [Admin\MediaController::class, 'index'])->name('media.index');
    Route::get('media/browse', [Admin\MediaController::class, 'browse'])->name('media.browse');
    Route::post('media/upload', [Admin\MediaController::class, 'upload'])->name('media.upload');
    Route::delete('media', [Admin\MediaController::class, 'destroy'])->name('media.destroy');

    // Settings
    Route::get('settings', [Admin\SettingsController::class, 'index'])->name('settings.index');
    Route::put('settings', [Admin\SettingsController::class, 'update'])->name('settings.update');

    // Theme (colors + typography)
    Route::get('theme', [Admin\ThemeController::class, 'edit'])->name('theme.edit');
    Route::put('theme', [Admin\ThemeController::class, 'update'])->name('theme.update');

    // Seguimiento (Google Analytics, GTM, Meta Pixel, HotJar, etc.)
    Route::get('tracking', [Admin\TrackingController::class, 'edit'])->name('tracking.edit');
    Route::put('tracking', [Admin\TrackingController::class, 'update'])->name('tracking.update');

    // Código global (CSS/JS)
    Route::get('code', [Admin\CodeController::class, 'edit'])->name('code.edit');
    Route::put('code', [Admin\CodeController::class, 'update'])->name('code.update');

    // Configuración de Tienda
    Route::get('store-config', [Admin\StoreConfigController::class, 'edit'])->name('store-config.edit');
    Route::put('store-config', [Admin\StoreConfigController::class, 'update'])->name('store-config.update');

    // Configuración de Catálogos (defaults globales)
    Route::get('catalog-config', [Admin\CatalogConfigController::class, 'edit'])->name('catalog-config.edit');
    Route::put('catalog-config', [Admin\CatalogConfigController::class, 'update'])->name('catalog-config.update');

    // Users
    Route::resource('users', Admin\UserController::class)->except(['show']);

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

/*
|--------------------------------------------------------------------------
| Dynamic Page Routes (must be last, after auth routes)
|--------------------------------------------------------------------------
*/
Route::get('/{slug}', [PublicSite\PageController::class, 'show'])->name('page.show');
