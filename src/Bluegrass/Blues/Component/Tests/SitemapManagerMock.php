<?php

namespace Bluegrass\Blues\Component\Tests;

use Bluegrass\Blues\Component\Model\Web\Location\RouteBasedLocation;
use Bluegrass\Blues\Component\Sitemap\AbstractSitemapManager;
use Bluegrass\Blues\Component\Sitemap\Node;
use Bluegrass\Blues\Component\Sitemap\Sitemap;

class SitemapManagerMock extends AbstractSitemapManager
{
    protected function buildSitemap()
    {
        $sitemap = new Sitemap( "h-1", "home", new RouteBasedLocation("root"));
        $node_1 = $sitemap->getRoot()->addChild(new Node( "h-1-1", "node_1", new RouteBasedLocation("node_1")));
        $node_2 = $sitemap->getRoot()->addChild(new DynamicLabelNodeMock(new Node( "h-1-2", "node_2", new RouteBasedLocation("node_2", array("param_1" => "param_1_value")))));
        $node_2_1 = $node_2->addChild(new Node( "h-1-2-1", "node_2_1", new RouteBasedLocation("node_2_1", array("param_1" => "param_1_value"))));
        
        return $sitemap;
    }
}