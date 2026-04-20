<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('catalog_category_catalog_product', function (Blueprint $table) {
            $table->foreignId('catalog_product_id')->constrained('catalog_products')->cascadeOnDelete();
            $table->foreignId('catalog_category_id')->constrained('catalog_categories')->cascadeOnDelete();
            $table->primary(
                ['catalog_product_id', 'catalog_category_id'],
                'cat_cat_prod_pivot_primary'
            );
            $table->index('catalog_category_id');
        });

        DB::table('catalog_products')
            ->whereNotNull('catalog_category_id')
            ->select('id', 'catalog_category_id')
            ->orderBy('id')
            ->chunk(500, function ($rows) {
                $pivot = $rows->map(fn ($r) => [
                    'catalog_product_id' => $r->id,
                    'catalog_category_id' => $r->catalog_category_id,
                ])->all();
                if ($pivot) {
                    DB::table('catalog_category_catalog_product')->insertOrIgnore($pivot);
                }
            });
    }

    public function down(): void
    {
        Schema::dropIfExists('catalog_category_catalog_product');
    }
};
