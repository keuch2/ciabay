<?php

namespace App\Services\HtmlImport;

/**
 * Repara desbalances de tags en el body de una maqueta importada.
 *
 * Una maqueta standalone tolera tags desbalanceados: un </div> de más se
 * ignora al nivel de <body>, y un <div> sin cerrar lo cierra el parser al
 * final del documento. Pero el importador envuelve el body en
 * <div class="html-import">, y ahí un cierre de más CIERRA EL WRAPPER a
 * mitad de página (todo lo que sigue pierde el scope del CSS), y una
 * apertura sin cerrar se tragaría el cierre del wrapper (los estilos se
 * derramarían sobre el footer del sitio).
 *
 * Replica la recuperación del parser HTML: elimina los tags de cierre que
 * no cierran nada, y agrega al final los cierres que falten.
 */
class HtmlBalancer
{
    private const VOID_ELEMENTS = [
        'area', 'base', 'br', 'col', 'embed', 'hr', 'img', 'input',
        'link', 'meta', 'param', 'source', 'track', 'wbr',
    ];

    private int $droppedCloses = 0;

    private int $appendedCloses = 0;

    public function balance(string $html): string
    {
        $this->droppedCloses = 0;
        $this->appendedCloses = 0;

        preg_match_all('#<(/?)([a-zA-Z][a-zA-Z0-9-]*)((?:[^>"\']|"[^"]*"|\'[^\']*\')*)>#', $html, $matches, PREG_OFFSET_CAPTURE | PREG_SET_ORDER);

        /** @var list<string> $stack tags abiertos */
        $stack = [];
        /** @var list<array{int, int}> $toRemove [offset, largo] de cierres huérfanos */
        $toRemove = [];

        foreach ($matches as $m) {
            $isClose = $m[1][0] === '/';
            $tag = strtolower($m[2][0]);
            $attrs = $m[3][0];

            if (! $isClose) {
                if (in_array($tag, self::VOID_ELEMENTS, true) || str_ends_with(rtrim($attrs), '/')) {
                    continue; // void o self-closing (svg): no abre scope
                }
                $stack[] = $tag;
                continue;
            }

            $at = array_keys($stack, $tag, true);
            if ($at === []) {
                // cierre sin apertura: el parser lo ignoraría a nivel body,
                // pero acá cerraría el wrapper — se elimina
                $toRemove[] = [$m[0][1], strlen($m[0][0])];
                $this->droppedCloses++;
                continue;
            }

            // cierra el más cercano; lo que quede por encima se cierra implícito
            array_splice($stack, end($at));
        }

        foreach (array_reverse($toRemove) as [$offset, $length]) {
            $html = substr_replace($html, '', $offset, $length);
        }

        // aperturas sin cerrar: cerrarlas para que no se traguen el cierre del wrapper
        foreach (array_reverse($stack) as $tag) {
            $html .= "</{$tag}>";
            $this->appendedCloses++;
        }

        return $html;
    }

    public function droppedCloses(): int
    {
        return $this->droppedCloses;
    }

    public function appendedCloses(): int
    {
        return $this->appendedCloses;
    }
}
