<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pages', function (Blueprint $t) {
            $t->text('custom_css')->nullable()->after('og_image');
            $t->text('custom_js')->nullable()->after('custom_css');
        });

        Schema::table('blog_posts', function (Blueprint $t) {
            $t->text('custom_css')->nullable()->after('featured_image');
            $t->text('custom_js')->nullable()->after('custom_css');
        });

        Schema::table('catalog_products', function (Blueprint $t) {
            $t->text('custom_css')->nullable();
            $t->text('custom_js')->nullable();
        });

        Schema::table('brands', function (Blueprint $t) {
            $t->unsignedSmallInteger('catalog_columns')->nullable()->after('catalog_contact_message');
            $t->unsignedSmallInteger('catalog_per_page')->nullable()->after('catalog_columns');
            $t->text('catalog_custom_css')->nullable()->after('catalog_per_page');
            $t->text('catalog_custom_js')->nullable()->after('catalog_custom_css');
        });
    }

    public function down(): void
    {
        Schema::table('pages', function (Blueprint $t) {
            $t->dropColumn(['custom_css', 'custom_js']);
        });

        Schema::table('blog_posts', function (Blueprint $t) {
            $t->dropColumn(['custom_css', 'custom_js']);
        });

        Schema::table('catalog_products', function (Blueprint $t) {
            $t->dropColumn(['custom_css', 'custom_js']);
        });

        Schema::table('brands', function (Blueprint $t) {
            $t->dropColumn([
                'catalog_columns',
                'catalog_per_page',
                'catalog_custom_css',
                'catalog_custom_js',
            ]);
        });
    }
};
