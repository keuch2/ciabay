<?php

namespace App\Services\HtmlImport;

/**
 * Scopea el CSS de una maqueta standalone bajo un wrapper, para que conviva
 * con styles.css del sitio (mismo criterio que las plantillas hard-coded
 * tipo nidera-page.css / vence-tudo-page.css):
 *
 *  - :root / body / html   -> selector del wrapper (las custom properties
 *                             y estilos de body pasan a vivir ahí)
 *  - *                     -> wrapper, wrapper *
 *  - body.clase X          -> body.clase wrapper X  (clases que el JS de la
 *                             maqueta togglea sobre el <body> real)
 *  - resto                 -> prefijado con el wrapper
 *  - @keyframes nombre     -> prefijo (y rename de las referencias en
 *                             animation / animation-name)
 *  - reglas html {...}     -> descartadas (overflow/scroll-behavior de
 *                             documento no aplican dentro del wrapper)
 *
 * Ajustes de convivencia con el layout (deterministas):
 *  - bloques con position:fixed y z-index < 1000 -> z-index +1000 (quedan
 *    por encima del header sticky del sitio)
 *  - position:sticky con top:0 -> top:var(--site-header-h,0px) (la variable
 *    la setea el runtime de la vista html-import midiendo el header)
 *  - el wrapper arranca con line-height:normal;position:relative;overflow:clip
 *    y se le quita cualquier overflow-x:hidden heredado de body/html
 */
class CssScoper
{
    public const KEYFRAME_PREFIX = 'hi-';

    public function __construct(
        private readonly string $wrapper = '.html-import',
    ) {
    }

    public function scope(string $css): string
    {
        $keyframes = [];
        $scoped = $this->scopeBlock($css, '', $keyframes);

        foreach ($keyframes as $name) {
            $scoped = preg_replace(
                '/(animation(?:-name)?\s*:[^;}]*?)(?<![\w-])' . preg_quote($name, '/') . '(?![\w-])/',
                '$1' . self::KEYFRAME_PREFIX . $name,
                $scoped,
            );
        }

        return $this->wrapper . "{line-height:normal;position:relative;overflow:clip}\n" . $scoped . "\n";
    }

    /**
     * @param list<string> $keyframes
     */
    private function scopeBlock(string $css, string $indent, array &$keyframes): string
    {
        $out = [];

        foreach ($this->splitRules($css) as [$prelude, $body]) {
            if ($body === null) {
                // at-rule sin bloque (@import, @charset...)
                $out[] = $indent . $prelude . ';';
                continue;
            }

            if (str_starts_with($prelude, '@keyframes')) {
                $name = trim(substr($prelude, strlen('@keyframes')));
                $keyframes[] = $name;
                $out[] = $indent . '@keyframes ' . self::KEYFRAME_PREFIX . $name . '{' . $body . '}';
                continue;
            }

            if (str_starts_with($prelude, '@font-face')) {
                // su interior son declaraciones, no reglas: va verbatim
                $out[] = $indent . '@font-face{' . $body . '}';
                continue;
            }

            if (str_starts_with($prelude, '@')) {
                // @media / @supports: scopear el interior recursivamente
                $inner = $this->scopeBlock($body, $indent . '  ', $keyframes);
                $out[] = $indent . $prelude . "{\n" . $inner . "\n" . $indent . '}';
                continue;
            }

            if (trim($prelude) === 'html') {
                continue;
            }

            $selectors = [];
            $isWrapperRule = false;
            foreach (explode(',', $prelude) as $selector) {
                $scopedSelector = $this->scopeSelector($selector);
                if ($scopedSelector === $this->wrapper) {
                    $isWrapperRule = true;
                }
                if (! in_array($scopedSelector, $selectors, true)) {
                    $selectors[] = $scopedSelector;
                }
            }

            $out[] = $indent . implode(', ', $selectors) . '{' . $this->adjustDeclarations($body, $isWrapperRule) . '}';
        }

        return implode("\n", $out);
    }

    private function scopeSelector(string $selector): string
    {
        $selector = trim($selector);

        if (in_array($selector, [':root', 'body', 'html'], true)) {
            return $this->wrapper;
        }

        // body.clase ... / body:estado ... : la clase vive en el <body> real
        if (preg_match('/^body([.:][^\s]*)(.*)$/s', $selector, $m)) {
            $rest = trim($m[2]);

            return $rest === ''
                ? 'body' . $m[1] . ' ' . $this->wrapper
                : 'body' . $m[1] . ' ' . $this->wrapper . ' ' . $rest;
        }

        if ($selector === '*') {
            return $this->wrapper . ', ' . $this->wrapper . ' *';
        }

        if (str_starts_with($selector, '*:')) {
            return $this->wrapper . substr($selector, 1) . ', ' . $this->wrapper . ' ' . $selector;
        }

        if (str_starts_with($selector, ':')) {
            // ::selection, :focus-visible sueltos, etc.
            return $this->wrapper . ' ' . $selector;
        }

        return $this->wrapper . ' ' . $selector;
    }

    private function adjustDeclarations(string $body, bool $isWrapperRule): string
    {
        if ($isWrapperRule) {
            // el wrapper ya lleva overflow:clip; un overflow-x:hidden heredado
            // de body/html rompería position:sticky interno
            $body = preg_replace('/overflow-x\s*:\s*hidden\s*;?/', '', $body);

            // Maqueta "app de pantalla completa": body{height:100%;overflow:hidden}
            // depende de la cadena html→body{height:100%}, que dentro del layout
            // colapsa a auto (y los height:100% internos a 0). Se traduce a
            // altura de viewport menos el header del sitio, así los porcentajes
            // internos vuelven a resolver. Un height:100% suelto (sin
            // overflow:hidden) se deja: computa a auto y es inofensivo en
            // maquetas de scroll normal.
            if (preg_match('/overflow\s*:\s*hidden/', $body) && preg_match('/(?<![\w-])height\s*:\s*100%/', $body)) {
                $body = preg_replace(
                    '/(?<![\w-])height\s*:\s*100%/',
                    'height:calc(100vh - var(--site-header-h,0px));height:calc(100svh - var(--site-header-h,0px))',
                    $body,
                );
            }
        }

        if (preg_match('/position\s*:\s*fixed/', $body)) {
            $body = preg_replace_callback('/z-index\s*:\s*(\d+)/', function (array $m) {
                $z = (int) $m[1];

                return $z < 1000 ? 'z-index:' . ($z + 1000) : $m[0];
            }, $body);
        }

        if (preg_match('/position\s*:\s*sticky/', $body)) {
            $body = preg_replace('/(^|[;{\s])top\s*:\s*0(px)?\s*(;|$)/', '$1top:var(--site-header-h,0px)$3', $body);
        }

        return $body;
    }

    /**
     * Separa el CSS en reglas de primer nivel balanceando llaves.
     * Los comentarios entre reglas se descartan.
     *
     * @return list<array{0: string, 1: ?string}> [prelude, cuerpo|null]
     */
    private function splitRules(string $css): array
    {
        $rules = [];
        $i = 0;
        $n = strlen($css);

        while ($i < $n) {
            // saltar espacios y comentarios
            while ($i < $n) {
                if (ctype_space($css[$i])) {
                    $i++;
                } elseif (substr($css, $i, 2) === '/*') {
                    $end = strpos($css, '*/', $i + 2);
                    $i = $end === false ? $n : $end + 2;
                } else {
                    break;
                }
            }
            if ($i >= $n) {
                break;
            }

            $j = $i;
            $depth = 0;
            $parens = 0;
            while ($j < $n) {
                $c = $css[$j];
                if ($c === '"' || $c === "'") {
                    // string: saltar hasta la comilla de cierre
                    $end = strpos($css, $c, $j + 1);
                    $j = $end === false ? $n : $end;
                } elseif ($c === '(') {
                    $parens++;
                } elseif ($c === ')') {
                    $parens = max(0, $parens - 1);
                } elseif ($c === '{') {
                    $depth++;
                } elseif ($c === '}') {
                    $depth--;
                    if ($depth === 0) {
                        break;
                    }
                } elseif ($c === ';' && $depth === 0 && $parens === 0) {
                    // un ; dentro de url(data:...;base64,...) no separa reglas
                    break;
                }
                $j++;
            }

            $chunk = substr($css, $i, $j - $i + 1);
            $bracePos = strpos($chunk, '{');
            if ($bracePos !== false) {
                $rules[] = [trim(substr($chunk, 0, $bracePos)), substr($chunk, $bracePos + 1, -1)];
            } else {
                $rules[] = [rtrim(trim($chunk), ';'), null];
            }

            $i = $j + 1;
        }

        return $rules;
    }
}
