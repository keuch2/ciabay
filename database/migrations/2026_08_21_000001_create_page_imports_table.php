<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('page_imports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('original_filename');
            $table->unsignedBigInteger('original_size');
            $table->string('checksum', 40);
            $table->mediumText('body_html');
            $table->mediumText('js_code')->nullable();
            $table->string('detected_title')->nullable();
            $table->text('detected_meta_description')->nullable();
            $table->json('google_fonts')->nullable();
            $table->json('manifest')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_imports');
    }
};
