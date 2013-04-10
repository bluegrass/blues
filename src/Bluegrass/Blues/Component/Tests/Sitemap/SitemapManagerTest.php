<?php

namespace Bluegrass\Blues\Component\Tests\Sitemap;

use Bluegrass\Blues\Component\Tests\Sitemap\Mocks\SitemapManagerMock;
use Symfony\Component\HttpFoundation\Request;

class SitemapManagerTest extends \PHPUnit_Framework_TestCase 
{    
    public function testGetCurrentSitemapNode()
    {
        $manager = new SitemapManagerMock();
        
        $request = new Request();
        $request->attributes->set('_route', 'node_2');
        $request->attributes->set('_route_params', array('param_1' => 'param_1_value'));
        
        $node = $manager->getCurrentSitemapNode($request);
        
        $this->assertNotNull(
            $node,
            "Se esperaba un nodo actual para el sitemap."
        );
    }
}
