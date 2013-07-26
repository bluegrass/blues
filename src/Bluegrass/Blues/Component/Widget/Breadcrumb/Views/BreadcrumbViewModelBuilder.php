<?php

namespace Bluegrass\Blues\Component\Widget\Breadcrumb\Views;

use Bluegrass\Blues\Component\Model\Web\Location\RouteBasedLocation;
use Bluegrass\Blues\Component\Model\Web\Location\UrlGeneratorInterface;
use Bluegrass\Blues\Component\Breadcrumb\Model\Item;
use Bluegrass\Blues\Component\View\ViewModel;
use Bluegrass\Blues\Component\Widget\Breadcrumb\BreadcrumbWidget;
use Bluegrass\Blues\Component\Widget\View\Builder\WidgetViewModelBuilderInterface;
use Bluegrass\Blues\Component\Widget\WidgetInterface;
use Exception;

/**
 * Implementa la lógica necesaria para construir una Vista
 *
 * @author gcaseres
 */
class BreadcrumbViewModelBuilder implements WidgetViewModelBuilderInterface
{
    private $urlGenerator;
    
    
    /**
     * Inicializa una instancia de un constructor de viewmodels para breadcrumbs.
     * 
     * Esta implementación utiliza parámetros HTTP para asociar el contenido
     * histórico del breadcrumb a las URLs de cada nodo. 
     * 
     * @param \Bluegrass\Blues\Bundle\BluesBundle\Model\Web\Location\UrlGeneratorInterface $urlGenerator 
     */
    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->setUrlGenerator($urlGenerator);
    }
    
    public function build(WidgetInterface $widget) 
    {
        if (!($widget instanceof BreadcrumbWidget))
            throw new Exception("Este constructor de ViewModels solo admite instancias de Bluegrass\Blues\Component\Widget\Breadcrumb\Breadcrumb");
                
        return $this->buildInternal($widget);
    }
    
    protected function setUrlGenerator(UrlGeneratorInterface $value)
    {
        $this->urlGenerator = $value;
    }
    
    /**
     * 
     * @return UrlGeneratorInterface
     */
    protected function getUrlGenerator()
    {
        return $this->urlGenerator;
    }
    
    protected function buildInternal(BreadcrumbWidget $widget)
    {
        $viewModel = new ViewModel();
        
        $viewModel->set('count', $widget->count());
     
        $items = array();
                
        foreach ($widget as $itemModel) {
            $items[] = $this->buildItemViewModel($widget, $itemModel);                        
            $last = $itemModel;
        }
        

        $viewModel->set('viewstate', $this->getViewStateForItem($widget, $last));
        
        $viewModel->set('items', $items);
        
        
        return $viewModel;
    }
    
    protected function buildItemViewModel(BreadcrumbWidget $widget, Item $itemModel)
    {
        $view = new ViewModel();
                
        $view->set('title', $itemModel->getTitle());
        $view->set('url', $this->getUrlForItem($widget, $itemModel));
        
        return $view;        
    }
    
    protected function getViewStateForItem(BreadcrumbWidget $widget, Item $itemModel)
    {
        $trail = $widget->getTrailFor($itemModel);
        $i=0;
        
        $urlNodes = array();
        foreach ($trail as $trailItem) {
            $name = $trailItem->getName();
            $params = $trailItem->getWebLocation()->getParameters();
            
            $urlNode = array('name' => $name, 'params' => $params);
            
            $urlNodes[] = $urlNode;
            
            $i++;
        }
                
        //Agregar datos del nodo actual
        $urlNodes[] = array('name' => $itemModel->getName(), 'params' => $itemModel->getWebLocation()->getParameters());
        
        return base64_encode(gzcompress(json_encode($urlNodes, JSON_FORCE_OBJECT)));
    }
    
    /**
     * Genera una url para el item especificado.
     * La url generada contiene los parámetros necesarios para reconstruir
     * el breadcrumb.
     * 
     * @param Item $itemModel
     * @return string Url generada para el item especificado.
     */
    protected function getUrlForItem(BreadcrumbWidget $widget, Item $itemModel)
    {
        $prefix = 'bc'; //TODO: Hacerlo parametrizable

        $params = array();
        $params[$prefix . '_url'] = $this->getViewStateForItem($widget, $itemModel);
        
        $location = new RouteBasedLocation($itemModel->getWebLocation()->getName(), array_merge($itemModel->getWebLocation()->getParameters(), $params));

        return $this->getUrlGenerator()->generate($location);
    }
    
}
