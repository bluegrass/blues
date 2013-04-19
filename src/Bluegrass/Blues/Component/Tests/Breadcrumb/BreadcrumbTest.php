<?php

namespace Bluegrass\Blues\Component\Tests\Breadcrumb;

use Bluegrass\Blues\Bundle\BluesBundle\Model\Web\Location\UrlBasedLocation;
use Bluegrass\Blues\Component\Breadcrumb\Breadcrumb;
use Bluegrass\Blues\Component\Tests\RouterMock;
use Bluegrass\Blues\Component\Tests\SitemapManagerMock;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\RequestContext;
use Bluegrass\Blues\Bundle\BluesBundle\Model\Web\Location\UrlGenerator as WebLocationUrlGenerator;

class BreadcrumbTest extends \PHPUnit_Framework_TestCase
{
    
    protected function createBreadcrumb()
    {
        /*
         * Se instancias las dependencias claves del breadcrumb.
         */
        $requestContext = new RequestContext();        
        $router = new RouterMock();
        $router->setContext($requestContext);        
        $urlGenerator = new UrlGenerator($router->getRouteCollection(), $requestContext);
        
        /*
         * Se genera un requerimiento para un nodo en particular del sitemap
         * (que se corresponde con una ruta).
         */
        $request = new Request();
        $request->attributes->set('_route', 'node_2');
        $request->attributes->set('_route_params', array('param_1' => 'param_1_value'));        
        $request->query->set('bc.url', json_encode(array('root_url?param=1')));
        
        
        //Creación del breadcrumb
        $breadcrumb = new Breadcrumb($router, new SitemapManagerMock(), $request, new WebLocationUrlGenerator($urlGenerator));
        
        return $breadcrumb;
    }
    
    public function testCreate()
    {
        $this->createBreadcrumb();
    }
    
    public function testCreateView()
    {
        //Obtener una instancia del breadcrumb.
        $breadcrumb = $this->createBreadcrumb();
        
        //Generar la vista.
        $view = $breadcrumb->createView();
                
        $items = $view->get('items');
        
        $this->assertEquals(
            2,
            count($items),
            "Se esperaba que la vista generada contenga 2 items."
        );
                
        $location = new UrlBasedLocation($items[0]->get('url'));
        $params = $location->getParameters();
        
        $this->assertTrue(
            isset($params['param']),
            "Se esperaba que el primer item de la vista tenga una url con parámetro 'param' en su query-string."
        );

        $this->assertEquals(
            "1",
            $params['param'],
            "El valor del parámetro 'param' de la url de la vista del primer item no es el esperado."
        );
        
        $this->assertTrue(
            isset($params['bc.url']),
            "Se esperaba que el primer item de la vista tenga una url con parámetro 'bc.url' en su query-string."
        );

        $this->assertEquals(
            json_encode(array('root_url?param=1')),
            $params['bc.url'],
            "El valor del parámetro 'bc.url' de la url de la vista del primer item no es el esperado."
        );
        

        
    }
}