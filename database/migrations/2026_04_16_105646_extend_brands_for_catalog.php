<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('brands', function (Blueprint $table) {
            $table->boolean('catalog_enabled')->default(false)->after('is_active');
            $table->string('catalog_hero_image')->nullable()->after('catalog_enabled');
            $table->text('catalog_intro')->nullable()->after('catalog_hero_image');
            $table->string('catalog_contact_whatsapp')->nullable()->after('catalog_intro');
            $table->string('catalog_contact_message')->nullable()->after('catalog_contact_whatsapp');
        });
    }

    public function down(): void
    {
        Schema::table('brands', function (Blueprint $table) {
            $table->dropColumn([
                'catalog_enabled',
                'catalog_hero_image',
                'catalog_intro',
                'catalog_contact_whatsapp',
                'catalog_contact_message',
            ]);
        });
    }
};
