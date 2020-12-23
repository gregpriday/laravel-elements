<?php

namespace SiteOrigin\Elements\Tests\Unit;

use SiteOrigin\Elements\Tests\TestCase;

class ImageTest extends TestCase
{
    public function test_render_basic_tag()
    {
        $r = view('show-image')->render();
        $this->assertStringContainsString('<img ', $r);
    }

}