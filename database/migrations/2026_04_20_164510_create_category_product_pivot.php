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
        Schema::create('category_product', function (Blueprint $table) {
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->foreignId('product_category_id')->constrained('product_categories')->cascadeOnDelete();
            $table->primary(['product_id', 'product_category_id']);
            $table->index('product_category_id');
        });

        // Backfill from existing single-category FK so nothing is lost.
        DB::table('products')
            ->whereNotNull('product_category_id')
            ->select('id', 'product_category_id')
            ->orderBy('id')
            ->chunk(500, function ($rows) {
                $pivot = $rows->map(fn ($r) => [
                    'product_id' => $r->id,
                    'product_category_id' => $r->product_category_id,
                ])->all();
                if ($pivot) {
                    DB::table('category_product')->insertOrIgnore($pivot);
                }
            });
    }

    public function down(): void
    {
        Schema::dropIfExists('category_product');
    }
};
