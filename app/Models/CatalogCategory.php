<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CatalogCategory extends Model
{
    protected $fillable = [
        'brand_id', 'name', 'slug',
        'description', 'image', 'sort_order', 'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Products that have this as their primary category (legacy FK).
     */
    public function products(): HasMany
    {
        return $this->hasMany(CatalogProduct::class);
    }

    /**
     * All catalog products associated with this category through the pivot.
     */
    public function productsAny(): BelongsToMany
    {
        return $this->belongsToMany(
            CatalogProduct::class,
            'catalog_category_catalog_product',
            'catalog_category_id',
            'catalog_product_id'
        );
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
