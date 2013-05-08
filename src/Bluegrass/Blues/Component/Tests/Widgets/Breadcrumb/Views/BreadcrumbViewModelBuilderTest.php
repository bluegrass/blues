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
        
        $url = $this->getMockBuilder('Bluegrass\Blues\Bundle\BluesBundle\Model\Web\Location\UrlBasedLocation')
                ->disableOriginalConstructor()->getMock();
        $url->expects($this->any())
                ->method('getUrl')
                ->will($this->returnValue('root_url'));                
        $model->add(new Item('root', $url));
        
        $url = $this->getMockBuilder('Bluegrass\Blues\Bundle\BluesBundle\Model\Web\Location\UrlBasedLocation')
                ->disableOriginalConstructor()->getMock();        
        $url->expects($this->any())
                ->method('getUrl')
                ->will($this->returnValue('node_1_url?param1=param1_value'));                
        $model->add(new Item('node_1', $url));
        
        $url = $this->getMockBuilder('Bluegrass\Blues\Bundle\BluesBundle\Model\Web\Location\UrlBasedLocation')
                ->disableOriginalConstructor()->getMock();
        $url->expects($this->any())
                ->method('getUrl')
                ->will($this->returnValue('node_2_url?param1=param1_value&param2=param2_value'));                
        $model->add(new Item('node_2', $url));
        
        return new BreadcrumbWidget($model);
    }
    
    
    protected function createViewModelBuilder()
    {
        return new BreadcrumbViewModelBuilder();
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
        $location = new UrlBasedLocation($items[$i]->get('url'));
        $params = $location->getParameters();        
        $expectedUrlBreadcrumbState = array('root_url');
        $this->assertItemUrlParameters($i, array('bc.url' => json_encode($expectedUrlBreadcrumbState)), $params);                               
        $this->assertItemUrlBreadcrumbState($i, $expectedUrlBreadcrumbState, json_decode($params['bc.url']));
        
        $i = 1;
        $location = new UrlBasedLocation($items[$i]->get('url'));
        $params = $location->getParameters();        
        $expectedUrlBreadcrumbState = array('root_url', 'node_1_url?param1=param1_value');
        $this->assertItemUrlParameters($i, array('param1' => 'param1_value', 'bc.url' => json_encode($expectedUrlBreadcrumbState)), $params);
        $this->assertItemUrlBreadcrumbState($i, $expectedUrlBreadcrumbState, json_decode($params['bc.url']));

        $i = 2;
        $location = new UrlBasedLocation($items[$i]->get('url'));
        $params = $location->getParameters();                
        $expectedUrlBreadcrumbState = array('root_url', 'node_1_url?param1=param1_value', 'node_2_url?param1=param1_value&param2=param2_value');
        $this->assertItemUrlParameters($i, array('param1' => 'param1_value','param2' => 'param2_value', 'bc.url' => json_encode($expectedUrlBreadcrumbState)), $params);
        $this->assertItemUrlBreadcrumbState($i, $expectedUrlBreadcrumbState, json_decode($params['bc.url']));
        
    }
    
    protected function assertItemUrlBreadcrumbState($itemIndex, array $expected, $state)
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
                "Se esperaba que estado del breadcrumb asociado a la url del item de indice $itemIndex tenga un elemento '$key' con valor '$value'."
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
        
        //Comprobar que exista específicamente la clave bc.url
        $this->assertTrue(
            isset($params['bc.url']),
            "Se esperaba que el item de indice $itemIndex de la vista tenga una url con el parámetro 'bc.url'."
        );                
        
        $this->assertTrue(
            is_array(json_decode($params['bc.url'])),
            "Se esperaba que el parametro 'bc.url' de la url del item de indice $itemIndex contenga un arreglo codificado en json."
        );                
        
    }
    
    
}