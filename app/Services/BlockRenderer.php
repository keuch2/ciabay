<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Block;
use Illuminate\Support\Facades\View;

class BlockRenderer
{
    public static function render(Block $block): string
    {
        $viewName = 'blocks.' . $block->type;

        if (! View::exists($viewName)) {
            if (app()->environment('local')) {
                return '<div class="block-placeholder" style="padding:2rem;background:#fef3c7;border:1px dashed #d97706;margin:1rem 0;text-align:center;color:#92400e;">
                    <p><strong>Bloque sin template:</strong> ' . e($block->type) . '</p>
                    <pre style="font-size:0.75rem;text-align:left;margin-top:0.5rem;">' . e(json_encode($block->data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) . '</pre>
                </div>';
            }

            return '';
        }

        return View::make($viewName, [
            'block' => $block,
            'data' => $block->data ?? [],
        ])->render();
    }

    /**
     * Block types that render outside the <main class="main-content"> wrapper.
     * Hero and agriculture sections sit flush against the viewport edges in the
     * prototype and are not part of the main content min-height region.
     */
    private const OUTSIDE_MAIN = [
        'hero-carousel',
        'hero-overlay',
        'page-hero',
        'redcase-hero',
        'agriculture-title',
        'agriculture-image',
    ];

    public static function renderAll($blocks): string
    {
        $out = '';
        $inMain = false;

        foreach ($blocks as $block) {
            $isInside = ! in_array($block->type, self::OUTSIDE_MAIN, true);

            if ($isInside && ! $inMain) {
                $out .= "\n".'<main class="main-content">'."\n";
                $inMain = true;
            } elseif (! $isInside && $inMain) {
                $out .= "\n".'</main>'."\n";
                $inMain = false;
            }

            $out .= static::render($block)."\n";
        }

        if ($inMain) {
            $out .= "\n".'</main>'."\n";
        }

        return $out;
    }
}
