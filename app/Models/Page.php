<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Facades\Storage;

class Page extends Model
{
    /**
     * Plantillas disponibles en el select del admin (value => label).
     * null/'' = página de bloques. 'html-import' es el template reservado
     * de las páginas generadas desde una maqueta HTML subida.
     */
    public const TEMPLATES = [
        'contact' => 'Contacto',
        'store' => 'Tienda',
        'sucursales' => 'Sucursales (mapa interactivo)',
        'inicio' => 'Inicio (nuevo diseño)',
        'repuestos' => 'Repuestos (nuevo diseño)',
        'historia' => 'Historia (nuevo diseño)',
        'trabaja-en-ciabay' => 'Trabaja en Ciabay (nuevo diseño)',
        'ciabay-en-campo' => 'Ciabay en Campo (nuevo diseño)',
        'nidera' => 'Nidera Maíz (nuevo diseño)',
        'vence-tudo' => 'Vence Tudo (nuevo diseño)',
        'html-import' => 'HTML importado (subir maqueta)',
    ];

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

    protected static function booted(): void
    {
        // El cascade de FK borra la fila de page_imports pero no limpia
        // storage; acá se borran los archivos generados por el importador.
        static::deleting(function (Page $page) {
            Storage::disk('public')->deleteDirectory('imported-pages/' . $page->id);
        });
    }

    public function blocks(): HasMany
    {
        return $this->hasMany(Block::class)->orderBy('sort_order');
    }

    public function htmlImport(): HasOne
    {
        return $this->hasOne(PageImport::class);
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
