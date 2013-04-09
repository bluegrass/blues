<?php

namespace Bluegrass\Blues\Component\Tests\Sitemap;

use Bluegrass\Blues\Component\Sitemap\Sitemap;

class SitemapTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        new Sitemap("home", null, false);
    }
    

}