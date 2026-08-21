<?php

namespace Tests\Unit;

use App\Services\HtmlImport\HtmlBalancer;
use PHPUnit\Framework\TestCase;

class HtmlBalancerTest extends TestCase
{
    public function test_balanced_html_is_untouched(): void
    {
        $html = '<main><div class="a"><p>hola</p></div><section><img src="x.jpg"><br></section></main>';

        $balancer = new HtmlBalancer();
        $this->assertSame($html, $balancer->balance($html));
        $this->assertSame(0, $balancer->droppedCloses());
        $this->assertSame(0, $balancer->appendedCloses());
    }

    public function test_stray_close_tag_is_removed(): void
    {
        // el </div> huérfano cerraría el wrapper .html-import a mitad de página
        $html = '<main><div>a</div></main></div><section>b</section>';

        $balancer = new HtmlBalancer();
        $this->assertSame('<main><div>a</div></main><section>b</section>', $balancer->balance($html));
        $this->assertSame(1, $balancer->droppedCloses());
    }

    public function test_unclosed_open_tags_are_closed_at_end(): void
    {
        $html = '<main><div><section>a</main>';

        $balancer = new HtmlBalancer();
        // </main> cierra implícitamente section y div; nada queda abierto
        $this->assertSame($html, $balancer->balance($html));

        $html2 = '<main><div>a</div>';
        $this->assertSame('<main><div>a</div></main>', $balancer->balance($html2));
        $this->assertSame(1, $balancer->appendedCloses());
    }

    public function test_self_closing_svg_content_is_ignored(): void
    {
        $html = '<div><svg viewBox="0 0 10 10"><path d="M0 0h10"/><circle cx="5" cy="5" r="4"/></svg></div>';

        $balancer = new HtmlBalancer();
        $this->assertSame($html, $balancer->balance($html));
    }

    public function test_attributes_with_gt_do_not_confuse_the_scan(): void
    {
        $html = '<div data-x="a > b"><span title=\'1 > 0\'>ok</span></div>';

        $balancer = new HtmlBalancer();
        $this->assertSame($html, $balancer->balance($html));
    }
}
