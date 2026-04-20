<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'name', 'slug', 'description', 'product_category_id',
        'price', 'whatsapp_message', 'image', 'images',
        'is_active', 'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'integer',
            'is_active' => 'boolean',
            'images' => 'array',
        ];
    }

    /**
     * Normalized gallery: primary image first, followed by any additional images
     * stored in the `images` JSON column, de-duplicated.
     */
    public function gallery(): array
    {
        $gallery = [];
        if ($this->image) $gallery[] = $this->image;
        foreach ($this->images ?? [] as $img) {
            if ($img && is_string($img) && trim($img) !== '' && !in_array($img, $gallery, true)) {
                $gallery[] = $img;
            }
        }
        return $gallery;
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'product_category_id');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(ProductCategory::class, 'category_product', 'product_id', 'product_category_id');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
