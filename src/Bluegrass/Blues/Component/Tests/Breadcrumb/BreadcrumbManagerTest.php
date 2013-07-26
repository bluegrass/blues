<?php

use Bluegrass\Blues\Component\Breadcrumb\DefaultBreadcrumbManager;
use Bluegrass\Blues\Component\Tests\SitemapManagerMock;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ParameterBag;
use Bluegrass\Blues\Component\Model\Web\Location\RouteBasedLocation;

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
        $urlGenerator = $this->getMock('Bluegrass\Blues\Component\Model\Web\Location\UrlGeneratorInterface');
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
                ->method('getName')
                ->will($this->returnValue('root'));
        $root->expects($this->any())
                ->method('getLocation')
                ->will($this->returnValue($location));
        $root->expects($this->any())
                ->method('isNavigable')
                ->will($this->returnValue(true));
        
        $location = new RouteBasedLocation('node_1_route', array('param1' => 'param1_value'));
        $node_1 = $this->getMock('\Bluegrass\Blues\Component\Breadcrumb\Sitemap\DynamicLabelNodeInterface');
        $node_1->expects($this->any())
                ->method('getParent')
                ->will($this->returnValue($root));
        $node_1->expects($this->any())
                ->method('getLabel')
                ->will($this->returnValue('node_1'));
        $node_1->expects($this->any())
                ->method('getName')
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
                ->method('getName')
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
    
    /**
     * Genera un requerimiento sin ViewState.
     * 
     * @return \Symfony\Component\HttpFoundation\Request
     */
    protected function createRequestMockWithoutViewState()
    {
        //$request = $this->getMockBuilder('\Symfony\Component\HttpFoundation\Request')->disableOriginalConstructor()->getMock();
        $request = Request::create('');
        $request->query = new ParameterBag(array(
            'param2' => 'param2_value'
        ));

        return $request;
    }

    /**
     * Genera un requerimiento con un ViewState incorrecto.
     * Se espera que al utilizar un ViewState con nodos que no respeten la
     * estructura del Sitemap, directamente se descarte el ViewState.
     * 
     * @return \Symfony\Component\HttpFoundation\Request
     */
    protected function createRequestMockWithIncorrectViewState()
    {
        $request = Request::create('');
        $request->query = new ParameterBag(array(
            'param2' => 'param2_value',
            'bc_url' => $this->encodeViewState(array(array('name' => 'node_1', 'params' => array('param1' => 'param1_value_modified'))))
        ));

        return $request;
    }

    
    /**
     * Genera un requerimiento con un ViewState válido que debería tenerse
     * en cuenta por el BreadcrumbManager a la hora de generar el Breadcrumb.
     * 
     * @return \Symfony\Component\HttpFoundation\Request
     */
    protected function createRequestMockWithValidViewState()
    {
        $request = Request::create('');
        $request->query = new ParameterBag(array(
            'param2' => 'param2_value',
            'bc_url' => $this->encodeViewState(array(array('name' => 'root', 'params' => array()), array('name' => 'node_1', 'params' => array('param1' => 'param1_value_modified'))))
        ));

        return $request;
    }
    
    protected function routerMatch($url)
    {
        throw new \Exception($url);
    }
    
    public function testGetBreadcrumbWithoutViewState()
    {              
        
        $sitemapManager = $this->createSitemapManagerMock();                
        $request = $this->createRequestMockWithoutViewState();
        
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
                'root_route',
                $breadcrumb->get(0)->getWebLocation()->getName(),
                'Se esperaba que el primer item del breadcrumb tenga la ruta "root_route"'
        );

        $this->assertEquals(
                'node_1',
                $breadcrumb->get(1)->getTitle(),
                'Se esperaba que el segundo item del breadcrumb tenga el título "node_1"'
        );
        $this->assertEquals(
                'node_1_route',
                $breadcrumb->get(1)->getWebLocation()->getName(),
                'Se esperaba que el segundo item del breadcrumb tenga la url "node_1_route"'
        );
        
                
        $this->assertEquals(
                array('param1' => 'param1_value'),
                $breadcrumb->get(1)->getWebLocation()->getParameters(),
                'Se esperaba que el segundo item del breadcrumb tenga un parámetro param1 con valor param1_value"'
        );

        $this->assertEquals(
                'node_1_1',
                $breadcrumb->get(2)->getTitle(),
                'Se esperaba que el tercer item del breadcrumb tenga el título "node_1_1"'
        );
        $this->assertEquals(
                'node_1_1_route',
                $breadcrumb->get(2)->getWebLocation()->getName(),
                'Se esperaba que el tercer item del breadcrumb tenga la url "node_1_1_route"'
        );
        
        $this->assertEquals(
                array('param2' => 'param2_value'),
                $breadcrumb->get(2)->getWebLocation()->getParameters(),
                'Se esperaba que el tercer item del breadcrumb tenga un parámetro param2 con valor param2_value'
        );
        
    }
    
        
    public function testGetBreadcrumbWithIncorrectViewState()
    {              
        
        $sitemapManager = $this->createSitemapManagerMock();                
        $request = $this->createRequestMockWithIncorrectViewState();
        
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
                'root_route',
                $breadcrumb->get(0)->getWebLocation()->getName(),
                'Se esperaba que el primer item del breadcrumb tenga la ruta "root_route"'
        );

        $this->assertEquals(
                'node_1',
                $breadcrumb->get(1)->getTitle(),
                'Se esperaba que el segundo item del breadcrumb tenga el título "node_1"'
        );
        $this->assertEquals(
                'node_1_route',
                $breadcrumb->get(1)->getWebLocation()->getName(),
                'Se esperaba que el segundo item del breadcrumb tenga la url "node_1_route"'
        );
        
        
        
        $this->assertEquals(
                array('param1' => 'param1_value'),
                $breadcrumb->get(1)->getWebLocation()->getParameters(),
                'Se esperaba que el segundo item del breadcrumb tenga un parámetro param1 con valor param1_value"'
        );

        $this->assertEquals(
                'node_1_1',
                $breadcrumb->get(2)->getTitle(),
                'Se esperaba que el tercer item del breadcrumb tenga el título "node_1_1"'
        );
        $this->assertEquals(
                'node_1_1_route',
                $breadcrumb->get(2)->getWebLocation()->getName(),
                'Se esperaba que el tercer item del breadcrumb tenga la url "node_1_1_route"'
        );
        
        $this->assertEquals(
                array('param2' => 'param2_value'),
                $breadcrumb->get(2)->getWebLocation()->getParameters(),
                'Se esperaba que el tercer item del breadcrumb tenga un parámetro param2 con valor param2_value'
        );
        
    }    
    
    protected function encodeViewState($viewState)
    {
        return base64_encode(gzcompress(json_encode($viewState, JSON_FORCE_OBJECT)));
    }
  
    
        
    public function testGetBreadcrumbWithValidViewState()
    {              
        
        $sitemapManager = $this->createSitemapManagerMock();                
        $request = $this->createRequestMockWithValidViewState();
        
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
                'root_route',
                $breadcrumb->get(0)->getWebLocation()->getName(),
                'Se esperaba que el primer item del breadcrumb tenga la ruta "root_route"'
        );

        $this->assertEquals(
                'node_1',
                $breadcrumb->get(1)->getTitle(),
                'Se esperaba que el segundo item del breadcrumb tenga el título "node_1"'
        );
        $this->assertEquals(
                'node_1_route',
                $breadcrumb->get(1)->getWebLocation()->getName(),
                'Se esperaba que el segundo item del breadcrumb tenga la url "node_1_route"'
        );
        
        
        $this->assertEquals(
                array('param1' => 'param1_value_modified'),
                $breadcrumb->get(1)->getWebLocation()->getParameters(),
                'Se esperaba que el segundo item del breadcrumb tenga un parámetro param1 con valor param1_value_modified, pues el valor lo setea el ViewState."'
        );

        $this->assertEquals(
                'node_1_1',
                $breadcrumb->get(2)->getTitle(),
                'Se esperaba que el tercer item del breadcrumb tenga el título "node_1_1"'
        );
        $this->assertEquals(
                'node_1_1_route',
                $breadcrumb->get(2)->getWebLocation()->getName(),
                'Se esperaba que el tercer item del breadcrumb tenga la url "node_1_1_route"'
        );
        
        $this->assertEquals(
                array('param2' => 'param2_value'),
                $breadcrumb->get(2)->getWebLocation()->getParameters(),
                'Se esperaba que el tercer item del breadcrumb tenga un parámetro param2 con valor param2_value'
        );
        
    }        
}
