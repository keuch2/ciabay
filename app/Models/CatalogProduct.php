<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CatalogProduct extends Model
{
    protected $fillable = [
        'brand_id', 'catalog_category_id', 'name', 'slug',
        'short_description', 'description', 'image', 'images',
        'contact_enabled', 'sort_order', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'images' => 'array',
            'contact_enabled' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(CatalogCategory::class, 'catalog_category_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Normalized gallery: primary image first, followed by additional images.
     * Mirrors the same pattern used in App\Models\Product::gallery().
     */
    public function gallery(): array
    {
        $gallery = [];
        if ($this->image) $gallery[] = $this->image;
        foreach ($this->images ?? [] as $img) {
            if ($img && !in_array($img, $gallery, true)) {
                $gallery[] = $img;
            }
        }
        return $gallery;
    }
}
