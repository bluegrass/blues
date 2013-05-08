<?php

use Bluegrass\Blues\Component\Breadcrumb\DefaultBreadcrumbManager;
use Bluegrass\Blues\Component\Tests\SitemapManagerMock;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ParameterBag;
use Bluegrass\Blues\Bundle\BluesBundle\Model\Web\Location\RouteBasedLocation;

/**
 *
 * @author gcaseres
 */
class BreadcrumbManagerTest extends \PHPUnit_Framework_TestCase
{
    protected function getSitemapManager()
    {
        return new SitemapManagerMock();
    }
        
    protected function createRouterMock()
    {
        $router = $this->getMock('Symfony\Component\Routing\RouterInterface');               
        $router->expects($this->any())
                ->method('match')
                ->will($this->returnCallback(
                        function($url) {
                            return array();
                        }
                ));

        return $router;
    }
    
    protected function createUrlGeneratorMock()
    {
        $urlGenerator = $this->getMock('Bluegrass\Blues\Bundle\BluesBundle\Model\Web\Location\UrlGeneratorInterface');
        $urlGenerator->expects($this->any())
                ->method('generate')
                ->will($this->returnCallback(
                        function ($location) {
                            switch ($location->getName()) {
                                case 'root_route':
                                    return 'root_url';
                                case 'node_1_route':
                                    return 'node_1_url';
                                case 'node_1_1_route':
                                    return 'node_1_1_url';
                            }
                        }
                ));

        return $urlGenerator;
    }
    
    protected function createBreadcrumbManager(Request $request)
    {
        $router = $this->createRouterMock();
        $urlGenerator = $this->createUrlGeneratorMock();
                       
        return new DefaultBreadcrumbManager($urlGenerator, $router);        
    }
    
    protected function createSitemapManagerMock()
    {
        $location = new RouteBasedLocation('root_route');                
        $root = $this->getMock('\Bluegrass\Blues\Component\Sitemap\NodeInterface');
        $root->expects($this->any())
                ->method('getParent')
                ->will($this->returnValue(null));
        $root->expects($this->any())
                ->method('getLabel')
                ->will($this->returnValue('root'));
        $root->expects($this->any())
                ->method('getLocation')
                ->will($this->returnValue($location));
        $root->expects($this->any())
                ->method('isNavigable')
                ->will($this->returnValue(true));
        
        $location = new RouteBasedLocation('node_1_route');
        $node_1 = $this->getMock('\Bluegrass\Blues\Component\Breadcrumb\Sitemap\DynamicLabelNodeInterface');
        $node_1->expects($this->any())
                ->method('getParent')
                ->will($this->returnValue($root));
        $node_1->expects($this->any())
                ->method('getLabel')
                ->will($this->returnValue('node_1'));
        $node_1->expects($this->once())
                ->method('process');
        $node_1->expects($this->any())
                ->method('getLocation')
                ->will($this->returnValue($location));
        $node_1->expects($this->any())
                ->method('isNavigable')
                ->will($this->returnValue(true));
        
        $location = new RouteBasedLocation('node_1_1_route');
        $node_1_1 = $this->getMock('\Bluegrass\Blues\Component\Sitemap\NodeInterface');
        $node_1_1->expects($this->any())
                ->method('getParent')
                ->will($this->returnValue($node_1));
        $node_1_1->expects($this->any())
                ->method('getLabel')
                ->will($this->returnValue('node_1_1'));
        $node_1_1->expects($this->any())
                ->method('getLocation')
                ->will($this->returnValue($location));
        $node_1_1->expects($this->any())
                ->method('isNavigable')
                ->will($this->returnValue(true));

        
        $sitemapManager = $this->getMock('\Bluegrass\Blues\Component\Sitemap\SitemapManagerInterface');
        $sitemapManager->expects($this->any())
                ->method('getCurrentSitemapNode')
                ->will($this->returnValue($node_1_1));

        return $sitemapManager;
    }
    
    protected function createRequestMock()
    {
        $request = $this->getMock('\Symfony\Component\HttpFoundation\Request');
        $request->query = new ParameterBag(array(
            'bc.url' => json_encode(array('root_url', 'node_1_url?param1=param1_value', 'node_1_1_url'))
        ));

        return $request;
    }
    
    protected function routerMatch($url)
    {
        throw new \Exception($url);
    }
    
    public function testGetBreadcrumb()
    {              
        $sitemapManager = $this->createSitemapManagerMock();                
        $request = $this->createRequestMock();
        
        $breadcrumbManager = $this->createBreadcrumbManager($request);        
                
        $breadcrumb = $breadcrumbManager->getBreadcrumb($request, $sitemapManager);
        
        $this->assertEquals(
                3, 
                $breadcrumb->count(),
                'Se esperaba que el breadcrumb obtenido tenga 3 elementos.'
        );
        
        $this->assertEquals(
                'root',
                $breadcrumb->get(0)->getTitle(),
                'Se esperaba que el primer item del breadcrumb tenga el título "root"'
        );        
        $this->assertEquals(
                'root_url',
                $breadcrumb->get(0)->getUrl()->getUrl(),
                'Se esperaba que el primer item del breadcrumb tenga la url "root_url"'
        );

        $this->assertEquals(
                'node_1',
                $breadcrumb->get(1)->getTitle(),
                'Se esperaba que el segundo item del breadcrumb tenga el título "node_1"'
        );
        $this->assertEquals(
                'node_1_url?param1=param1_value',
                $breadcrumb->get(1)->getUrl()->getUrl(),
                'Se esperaba que el segundo item del breadcrumb tenga la url "node_1_url"'
        );

        $this->assertEquals(
                'node_1_1',
                $breadcrumb->get(2)->getTitle(),
                'Se esperaba que el tercer item del breadcrumb tenga el título "node_1_1"'
        );
        $this->assertEquals(
                'node_1_1_url',
                $breadcrumb->get(2)->getUrl()->getUrl(),
                'Se esperaba que el tercer item del breadcrumb tenga la url "node_1_1_url"'
        );
        
    }
}
