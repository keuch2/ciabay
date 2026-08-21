<?php

namespace Tests\Unit;

use App\Services\HtmlImport\CssScoper;
use PHPUnit\Framework\TestCase;

class CssScoperTest extends TestCase
{
    private function scope(string $css): string
    {
        return (new CssScoper('.html-import'))->scope($css);
    }

    public function test_root_and_body_collapse_into_wrapper(): void
    {
        $out = $this->scope(':root{--bg:#fff}body{color:#000;overflow-x:hidden}');

        $this->assertStringContainsString('.html-import{--bg:#fff}', $out);
        $this->assertStringContainsString('.html-import{color:#000;}', $out);
        $this->assertStringNotContainsString('overflow-x:hidden', $out);
        $this->assertStringContainsString('.html-import{line-height:normal;position:relative;overflow:clip}', $out);
    }

    public function test_html_rules_are_dropped(): void
    {
        $out = $this->scope('html{scroll-behavior:smooth}p{margin:0}');

        $this->assertStringNotContainsString('scroll-behavior', $out);
        $this->assertStringContainsString('.html-import p{margin:0}', $out);
    }

    public function test_universal_selector(): void
    {
        $out = $this->scope('*{box-sizing:border-box}');

        $this->assertStringContainsString('.html-import, .html-import *{box-sizing:border-box}', $out);
    }

    public function test_body_class_selectors_keep_class_on_body(): void
    {
        $out = $this->scope('body.view-cat .panels{height:104px}body.open{overflow:hidden}');

        $this->assertStringContainsString('body.view-cat .html-import .panels{height:104px}', $out);
        $this->assertStringContainsString('body.open .html-import{overflow:hidden}', $out);
    }

    public function test_nested_media_query(): void
    {
        $out = $this->scope('@media (max-width:900px){.hero{padding:0}body{font-size:14px}}');

        $this->assertStringContainsString('@media (max-width:900px){', $out);
        $this->assertStringContainsString('.html-import .hero{padding:0}', $out);
        $this->assertStringContainsString('.html-import{font-size:14px}', $out);
    }

    public function test_keyframes_are_prefixed_and_references_renamed(): void
    {
        $out = $this->scope('@keyframes pulse{0%{opacity:0}100%{opacity:1}}.btn{animation:pulse 2s infinite}.x{animation-name:pulse}');

        $this->assertStringContainsString('@keyframes hi-pulse{', $out);
        $this->assertStringContainsString('animation:hi-pulse 2s infinite', $out);
        $this->assertStringContainsString('animation-name:hi-pulse', $out);
        $this->assertStringNotContainsString('@keyframes pulse', $out);
    }

    public function test_keyframe_rename_does_not_touch_similar_names(): void
    {
        $out = $this->scope('@keyframes tick{to{opacity:1}}.a{animation:tick 1s}.b{animation:sticker 1s}');

        $this->assertStringContainsString('animation:hi-tick 1s', $out);
        $this->assertStringContainsString('animation:sticker 1s', $out);
    }

    public function test_fixed_blocks_get_z_index_bump(): void
    {
        $out = $this->scope('.lightbox{position:fixed;inset:0;z-index:300}.card{position:relative;z-index:5}.top{position:fixed;z-index:2000}');

        $this->assertStringContainsString('.html-import .lightbox{position:fixed;inset:0;z-index:1300}', $out);
        $this->assertStringContainsString('.html-import .card{position:relative;z-index:5}', $out);
        $this->assertStringContainsString('.html-import .top{position:fixed;z-index:2000}', $out);
    }

    public function test_sticky_top_zero_uses_header_var(): void
    {
        $out = $this->scope('.bar{position:sticky;top:0;z-index:60}.abs{position:absolute;top:0}');

        $this->assertStringContainsString('top:var(--site-header-h,0px)', $out);
        $this->assertStringContainsString('.html-import .abs{position:absolute;top:0}', $out);
    }

    public function test_font_face_with_data_uri_survives_intact(): void
    {
        $css = "@font-face{font-family:'Manrope';src:url(data:font/woff2;base64,d09GMgABCD==) format('woff2');font-weight:400}";
        $out = $this->scope($css . '.x{margin:0}');

        $this->assertStringContainsString($css, $out);
        $this->assertStringContainsString('.html-import .x{margin:0}', $out);
    }

    public function test_semicolon_inside_url_does_not_split_rules(): void
    {
        $out = $this->scope('.a{background:url("data:image/svg+xml;utf8,<svg/>");color:red}.b{margin:0}');

        $this->assertStringContainsString('.html-import .a{background:url("data:image/svg+xml;utf8,<svg/>");color:red}', $out);
        $this->assertStringContainsString('.html-import .b{margin:0}', $out);
    }

    public function test_comments_and_selector_lists(): void
    {
        $out = $this->scope("/* intro */\nh1, h2 ,.big{margin:0}\n/* fin */");

        $this->assertStringContainsString('.html-import h1, .html-import h2, .html-import .big{margin:0}', $out);
    }
}
