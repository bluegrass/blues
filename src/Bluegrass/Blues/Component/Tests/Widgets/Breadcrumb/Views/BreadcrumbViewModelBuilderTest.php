<?php

namespace Bluegrass\Blues\Component\Tests\Widgets\Breadcrumb\Views;

use Bluegrass\Blues\Bundle\BluesBundle\Model\Web\Location\UrlBasedLocation;
use Bluegrass\Blues\Component\Breadcrumb\Model\Breadcrumb as BreadcrumbModel;
use Bluegrass\Blues\Component\Breadcrumb\Model\Item;
use Bluegrass\Blues\Component\Widgets\Breadcrumb\BreadcrumbWidget;
use Bluegrass\Blues\Component\Widgets\Breadcrumb\Views\BreadcrumbViewModelBuilder;

class BreadcrumbViewModelBuilderTest extends \PHPUnit_Framework_TestCase
{
    
    protected function createWidget()
    {
        $model = new BreadcrumbModel();
        
        $url = $this->getMockBuilder('Bluegrass\Blues\Bundle\BluesBundle\Model\Web\Location\RouteBasedLocation')
                ->disableOriginalConstructor()->getMock();
        $url->expects($this->any())
                ->method('getParameters')
                ->will($this->returnValue(array()));
        $model->add(new Item('root', 'root', $url));
        
        $url = $this->getMockBuilder('Bluegrass\Blues\Bundle\BluesBundle\Model\Web\Location\RouteBasedLocation')
                ->disableOriginalConstructor()->getMock();        
        $url->expects($this->any())
                ->method('getParameters')
                ->will($this->returnValue(array('param1' => 'param1_value')));                
        $model->add(new Item('node_1', 'node_1', $url));
        
        $url = $this->getMockBuilder('Bluegrass\Blues\Bundle\BluesBundle\Model\Web\Location\RouteBasedLocation')
                ->disableOriginalConstructor()->getMock();
        $url->expects($this->any())
                ->method('getParameters')
                ->will($this->returnValue(array('param1' => 'param1_value', 'param2' => 'param2_value')));                
        $model->add(new Item('node_2', 'node_2', $url));
        
        return new BreadcrumbWidget($model);
    }
    
    protected function createUrlGeneratorMock()
    {
        $result = $this->getMock('Bluegrass\Blues\Bundle\BluesBundle\Model\Web\Location\UrlGeneratorInterface');
        $result->expects($this->any())
                ->method('generate')
                ->will(
                    $this->returnCallback(
                        function($location) {                        
                            return array(
                                'route' => $location->getName(),
                                'params' => $location->getParameters()
                            );                            
                        }
                    )                        
                );
        
        return $result;
    }
    
    protected function createViewModelBuilder()
    {
        return new BreadcrumbViewModelBuilder($this->createUrlGeneratorMock());
    }
    
    protected function encodeViewState($viewState)
    {
        return base64_encode(gzcompress(json_encode($viewState, JSON_FORCE_OBJECT)));
    }

    protected function decodeViewState($viewState)
    {
        return json_decode(gzuncompress(base64_decode($viewState)), true);
    }    
    
    public function testBuild()
    {
        //Obtener una instancia del breadcrumb widget.
        $widget = $this->createWidget();
        
        $builder = $this->createViewModelBuilder();
                
        //Generar viewModel.
        $view = $builder->build($widget);
                
        $items = $view->get('items');
        
        $this->assertEquals(
            3,
            count($items),
            "Se esperaba que la vista generada contenga 2 items."
        );

        $this->assertEquals(
            3,
            $view->get('count'),
            "Se esperaba que la vista generada contenga un atributo 'count' cuyo valor sea 3."
        );        
        
        $i = 0;
        $location = $items[$i]->get('url');
        $params = $location['params'];
        $expectedUrlBreadcrumbState = array(array('name' => 'root', 'params' => array()));
        $this->assertItemUrlParameters($i, array('bc_url' => $this->encodeViewState($expectedUrlBreadcrumbState)), $params);
        $this->assertItemUrlBreadcrumbState($i, $expectedUrlBreadcrumbState, $this->decodeViewState($params['bc_url']));
        
        $i = 1;
        $location = $items[$i]->get('url');
        $params = $location['params'];
        $expectedUrlBreadcrumbState = array(
            array('name' => 'root', 'params' => array()), 
            array('name' => 'node_1', 'params' => array('param1' => 'param1_value'))
        );
        $this->assertItemUrlParameters($i, array('param1' => 'param1_value', 'bc_url' => $this->encodeViewState($expectedUrlBreadcrumbState)), $params);
        $this->assertItemUrlBreadcrumbState($i, $expectedUrlBreadcrumbState, $this->decodeViewState($params['bc_url']));

        $i = 2;
        $location = $items[$i]->get('url');
        $params = $location['params'];
        $expectedUrlBreadcrumbState = array(
            array('name' => 'root', 'params' => array()), 
            array('name' => 'node_1', 'params' => array('param1' => 'param1_value')),
            array('name' => 'node_2', 'params' => array('param1' => 'param1_value', 'param2' => 'param2_value'))
        );        
        $this->assertItemUrlParameters($i, array('param1' => 'param1_value','param2' => 'param2_value', 'bc_url' => $this->encodeViewState($expectedUrlBreadcrumbState)), $params);
        $this->assertItemUrlBreadcrumbState($i, $expectedUrlBreadcrumbState, $this->decodeViewState($params['bc_url']));
        
    }
    
    protected function assertItemUrlBreadcrumbState($itemIndex, array $expected, array $state)
    {   
        $this->assertEquals(
            count($expected),
            count($state),
            "Se esperaba que el estado del breadcrumb asociado a la url del item de indice $itemIndex contenga la cantidad esperada de elementos."
        );                
                
        foreach ($expected as $key => $value) {
            $this->assertEquals(
                $value,
                $state[$key],
                "Se esperaba que estado del breadcrumb asociado a la url del item de indice $itemIndex tenga un elemento '$key' con valor '" . json_encode($value) . "'."
            );
        }    
    }
    
    protected function assertItemUrlParameters($itemIndex, array $expected, $params)
    {        
        
        $this->assertEquals(
            count($expected),
            count($params),
            "Se esperaba que el item de indice $itemIndex de la vista tenga una url con la cantidad esperada de parametros."
        );
        
        foreach ($expected as $key => $value) {
            $this->assertTrue(
                isset($params[$key]),
                "Se esperaba que el item de indice $itemIndex de la vista tenga una url con el parámetro '$key'."
            );        
        }
        
        //Comprobar que exista específicamente la clave bc_url
        $this->assertTrue(
            isset($params['bc_url']),
            "Se esperaba que el item de indice $itemIndex de la vista tenga una url con el parámetro 'bc_url'."
        );                
        
        $this->assertTrue(
            is_array((array)json_decode($params['bc_url'])),
            "Se esperaba que el parametro 'bc_url' de la url del item de indice $itemIndex contenga un arreglo codificado en json."
        );                
        
    }
    
    
}