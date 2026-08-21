<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PageImport extends Model
{
    /**
     * Placeholder que el importador deja en body_html/js_code donde había
     * data URIs; se reemplaza por la URL real (asset()) en render time para
     * soportar deploys con prefijo de path.
     */
    public const ASSET_PLACEHOLDER = '__PAGE_ASSETS__/';

    protected $fillable = [
        'page_id',
        'original_filename',
        'original_size',
        'checksum',
        'body_html',
        'js_code',
        'detected_title',
        'detected_meta_description',
        'google_fonts',
        'manifest',
    ];

    protected $casts = [
        'google_fonts' => 'array',
        'manifest' => 'array',
    ];

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    public function storageDir(): string
    {
        return 'imported-pages/' . $this->page_id;
    }

    public function mediaBaseUrl(): string
    {
        return asset('storage/' . $this->storageDir() . '/media/');
    }

    public function cssUrl(): ?string
    {
        $cssPath = $this->manifest['css_path'] ?? null;
        if (! $cssPath) {
            return null;
        }

        return asset('storage/' . $cssPath) . '?v=' . optional($this->updated_at)->timestamp;
    }

    public function renderedBody(): string
    {
        return $this->resolveAssets($this->body_html ?? '');
    }

    public function renderedJs(): ?string
    {
        return $this->js_code !== null ? $this->resolveAssets($this->js_code) : null;
    }

    private function resolveAssets(string $content): string
    {
        return str_replace(self::ASSET_PLACEHOLDER, rtrim($this->mediaBaseUrl(), '/') . '/', $content);
    }
}
