<?php

namespace App\Services\HtmlImport;

use App\Exceptions\HtmlImportException;

/**
 * Extrae data URIs base64 (imagen/video/audio) de cualquier string y los
 * convierte en archivos, deduplicando por hash del contenido decodificado.
 * El mismo reemplazo por-ocurrencia cubre src= del HTML, url() del CSS y
 * mapas JS tipo `const IMGS = {"clave": "data:..."}`.
 */
class DataUriExtractor
{
    private const PATTERN = '#data:(image|video|audio)/([a-z0-9.+-]+);base64,([A-Za-z0-9+/=\s]+)#i';

    private const EXTENSIONS = [
        'jpeg' => 'jpg',
        'jpg' => 'jpg',
        'png' => 'png',
        'webp' => 'webp',
        'gif' => 'gif',
        'avif' => 'avif',
        'svg+xml' => 'svg',
        'mp4' => 'mp4',
        'webm' => 'webm',
        'mpeg' => 'mp3',
        'mp3' => 'mp3',
        'ogg' => 'ogg',
        'wav' => 'wav',
    ];

    /** @var array<string, array{file: string, mime: string, bytes: int, content: string}> hash sha1 => datos */
    private array $byHash = [];

    /** @var array<string, string> nombre de archivo => hash (para detectar colisiones de nombre) */
    private array $names = [];

    /**
     * Reemplaza cada data URI por "{$replacementPrefix}{archivo}" y acumula
     * los binarios extraídos (accesibles luego vía files()).
     */
    public function extract(string $content, string $replacementPrefix): string
    {
        $result = preg_replace_callback(self::PATTERN, function (array $m) use ($replacementPrefix) {
            $file = $this->store($m[1] . '/' . strtolower($m[2]), $m[3]);

            return $replacementPrefix . $file;
        }, $content);

        if ($result === null) {
            throw new HtmlImportException('No se pudieron procesar los archivos embebidos en la maqueta (contenido demasiado grande o inválido).');
        }

        return $result;
    }

    /** @return array<string, string> nombre de archivo => contenido binario */
    public function files(): array
    {
        $out = [];
        foreach ($this->byHash as $entry) {
            $out[$entry['file']] = $entry['content'];
        }

        return $out;
    }

    /** @return list<array{file: string, mime: string, bytes: int}> metadata para el manifest */
    public function manifest(): array
    {
        return array_values(array_map(
            fn (array $e) => ['file' => $e['file'], 'mime' => $e['mime'], 'bytes' => $e['bytes']],
            $this->byHash,
        ));
    }

    private function store(string $mime, string $base64): string
    {
        $binary = base64_decode(preg_replace('/\s+/', '', $base64), true);
        if ($binary === false || $binary === '') {
            throw new HtmlImportException('La maqueta contiene un archivo embebido con base64 inválido.');
        }

        $hash = sha1($binary);
        if (isset($this->byHash[$hash])) {
            return $this->byHash[$hash]['file'];
        }

        $subtype = strtolower(substr($mime, strpos($mime, '/') + 1));
        $ext = self::EXTENSIONS[$subtype] ?? preg_replace('/[^a-z0-9]/', '', $subtype);
        $file = substr($hash, 0, 8) . '.' . $ext;

        // sha1 truncado a 8 chars: colisión improbable, pero verificada.
        if (isset($this->names[$file]) && $this->names[$file] !== $hash) {
            $file = substr($hash, 0, 16) . '.' . $ext;
        }

        $this->names[$file] = $hash;
        $this->byHash[$hash] = [
            'file' => $file,
            'mime' => $mime,
            'bytes' => strlen($binary),
            'content' => $binary,
        ];

        return $file;
    }
}
