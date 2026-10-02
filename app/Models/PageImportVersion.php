<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Una entrada del historial de maquetas HTML subidas a una página.
 * El archivo original se guarda tal cual en el disco 'local' (privado,
 * storage/app/private) y se descarga solo vía ruta admin autenticada.
 * Varias versiones con el mismo checksum comparten html_path (dedup);
 * los archivos se limpian por directorio al borrar la página.
 */
class PageImportVersion extends Model
{
    protected $fillable = [
        'page_id', 'user_id', 'original_filename', 'original_size', 'checksum', 'html_path',
    ];

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
