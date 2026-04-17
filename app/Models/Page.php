<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Page extends Model
{
    protected $fillable = [
        'title', 'slug', 'template', 'is_homepage',
        'meta_title', 'meta_description', 'og_image',
        'custom_css', 'custom_js',
        'status', 'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_homepage' => 'boolean',
        ];
    }

    public function blocks(): HasMany
    {
        return $this->hasMany(Block::class)->orderBy('sort_order');
    }

    public function seoMeta(): MorphOne
    {
        return $this->morphOne(SeoMeta::class, 'seoable');
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }
}
