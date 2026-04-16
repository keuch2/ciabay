<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Brand extends Model
{
    protected $fillable = [
        'name', 'slug', 'logo', 'description', 'website_url',
        'is_represented', 'sort_order', 'is_active',
        'catalog_enabled', 'catalog_hero_image', 'catalog_intro',
        'catalog_contact_whatsapp', 'catalog_contact_message',
    ];

    protected function casts(): array
    {
        return [
            'is_represented' => 'boolean',
            'is_active' => 'boolean',
            'catalog_enabled' => 'boolean',
        ];
    }

    public function catalogCategories(): HasMany
    {
        return $this->hasMany(CatalogCategory::class);
    }

    public function catalogProducts(): HasMany
    {
        return $this->hasMany(CatalogProduct::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeRepresented($query)
    {
        return $query->where('is_represented', true);
    }

    public function scopeWithActiveCatalog($query)
    {
        return $query->where('is_active', true)->where('catalog_enabled', true);
    }
}
