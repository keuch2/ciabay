<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NavigationItem extends Model
{
    protected $fillable = [
        'navigation_id', 'parent_id', 'label', 'url',
        'target', 'page_id', 'sort_order',
    ];

    public function navigation(): BelongsTo
    {
        return $this->belongsTo(Navigation::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(NavigationItem::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(NavigationItem::class, 'parent_id')->orderBy('sort_order');
    }

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    public function getResolvedUrlAttribute(): string
    {
        if ($this->page_id && $this->page) {
            return url($this->page->slug);
        }

        $raw = $this->url ?? '#';

        if ($raw === '#' || $raw === '') {
            return '#';
        }

        // External URLs and fragments pass through unchanged.
        if (preg_match('#^(https?:)?//#i', $raw) || str_starts_with($raw, 'mailto:') || str_starts_with($raw, 'tel:') || str_starts_with($raw, '#')) {
            return $raw;
        }

        // Internal paths -> prefix with app base URL via url() helper.
        return url(ltrim($raw, '/'));
    }
}
