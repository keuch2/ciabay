<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductCategory extends Model
{
    protected $fillable = ['name', 'slug', 'sort_order', 'parent_id'];

    /**
     * Products that have this as their primary category (legacy FK).
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * All products associated with this category through the pivot,
     * regardless of which one they mark as primary.
     */
    public function productsAny(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'category_product', 'product_category_id', 'product_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(ProductCategory::class, 'parent_id');
    }

    public function scopeRoots($query)
    {
        return $query->whereNull('parent_id');
    }
}
