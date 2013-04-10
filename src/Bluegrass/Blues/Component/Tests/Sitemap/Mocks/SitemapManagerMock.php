<?php

namespace Bluegrass\Blues\Component\Tests\Sitemap\Mocks;

use Bluegrass\Blues\Component\Sitemap\Sitemap;
use Bluegrass\Blues\Bundle\BluesBundle\Model\Web\Location\RouteBasedLocation;
use Bluegrass\Blues\Component\Sitemap\AbstractSitemapManager;

class SitemapManagerMock extends AbstractSitemapManager
{
    protected function buildSitemap()
    {
        $sitemap = new Sitemap("root", new RouteBasedLocation("root"));
        $node_1 = $sitemap->getRoot()->addChild("node_1", new RouteBasedLocation("node_1"));
        $node_2 = $sitemap->getRoot()->addChild("node_2", new RouteBasedLocation("node_2", array("param_1" => "param_1_value")));
        $node_2_1 = $node_2->addChild("node_2_1", new RouteBasedLocation("node_2_1", array("param_1" => "param_1_value")));
        
        return $sitemap;
    }
}