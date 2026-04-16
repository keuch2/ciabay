<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function index()
    {
        $files = $this->collectAllFiles();
        return view('admin.media.index', compact('files'));
    }

    /**
     * JSON endpoint used by the media library picker modal.
     * Returns only image files with resolvable URLs.
     */
    public function browse(Request $request)
    {
        $q = $request->input('q');
        $files = $this->collectAllFiles()
            ->filter(fn ($f) => in_array(strtolower($f['extension']), ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg']));

        if ($q) {
            $needle = strtolower($q);
            $files = $files->filter(fn ($f) => str_contains(strtolower($f['path']), $needle));
        }

        return response()->json([
            'files' => $files->values()->all(),
        ]);
    }

    public function upload(Request $request)
    {
        $request->validate([
            'files' => 'required|array',
            'files.*' => 'file|max:10240',
            'folder' => 'nullable|string|max:100',
        ]);

        $folder = $request->input('folder', 'uploads');
        $uploaded = [];

        foreach ($request->file('files') as $file) {
            $path = $file->store($folder, 'public');
            $uploaded[] = [
                'path' => $path,
                'url' => $this->resolveStorageUrl($path),
            ];
        }

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'files' => $uploaded]);
        }

        return redirect()->route('admin.media.index')
            ->with('success', count($uploaded) . ' archivo(s) subidos correctamente.');
    }

    public function destroy(Request $request)
    {
        $request->validate(['path' => 'required|string']);
        $path = $request->input('path');

        // Only allow deletion of storage-managed files — never touch seeded assets
        if (str_starts_with($path, 'assets/')) {
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'No se puede eliminar archivos del sistema.'], 422);
            }
            return redirect()->route('admin.media.index')
                ->with('error', 'No se puede eliminar archivos del sistema (assets/).');
        }

        Storage::disk('public')->delete(ltrim($path, '/'));

        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('admin.media.index')->with('success', 'Archivo eliminado.');
    }

    /**
     * Returns a collection of media items from both the storage disk
     * (user uploads) and the public/assets/images directory (seeded assets).
     * Each item has: path, url, size, last_modified, extension, source.
     */
    private function collectAllFiles()
    {
        $storageFiles = collect(Storage::disk('public')->allFiles())
            ->filter(fn ($f) => !str_starts_with(basename($f), '.'))
            ->map(function ($path) {
                return [
                    'path' => $path,
                    'url' => $this->resolveStorageUrl($path),
                    'size' => Storage::disk('public')->size($path),
                    'last_modified' => Storage::disk('public')->lastModified($path),
                    'extension' => pathinfo($path, PATHINFO_EXTENSION),
                    'source' => 'upload',
                ];
            });

        $assetsRoot = public_path('assets/images');
        $assetFiles = collect();
        if (is_dir($assetsRoot)) {
            $assetFiles = collect(File::allFiles($assetsRoot))->map(function ($file) use ($assetsRoot) {
                $relative = 'assets/images/' . ltrim(str_replace($assetsRoot, '', $file->getPathname()), DIRECTORY_SEPARATOR);
                $relative = str_replace('\\', '/', $relative);
                return [
                    'path' => $relative,
                    'url' => asset($relative),
                    'size' => $file->getSize(),
                    'last_modified' => $file->getMTime(),
                    'extension' => $file->getExtension(),
                    'source' => 'asset',
                ];
            });
        }

        return $storageFiles->concat($assetFiles)->sortByDesc('last_modified')->values();
    }

    private function resolveStorageUrl(string $path): string
    {
        return asset('storage/' . ltrim($path, '/'));
    }
}
