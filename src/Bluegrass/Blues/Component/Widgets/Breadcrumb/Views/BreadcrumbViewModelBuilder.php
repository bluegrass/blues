<?php

namespace Bluegrass\Blues\Component\Widgets\Breadcrumb\Views;

use Bluegrass\Blues\Bundle\BluesBundle\Model\Web\Location\UrlBasedLocation;
use Bluegrass\Blues\Bundle\BluesBundle\Model\Web\Location\UrlGeneratorInterface;
use Bluegrass\Blues\Component\Breadcrumb\Model\Item;
use Bluegrass\Blues\Component\Views\ViewModel;
use Bluegrass\Blues\Component\Widgets\Breadcrumb\BreadcrumbWidget;
use Bluegrass\Blues\Component\Widgets\Views\WidgetViewModelBuilderInterface;
use Bluegrass\Blues\Component\Widgets\WidgetInterface;
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
     * histórico del breadcrumb a las URLs de cada nodo. Si no se especifica
     * un generador de urls, directamente se utiliza el método getUrl de
     * UrlBasedLocation.
     * 
     * @param \Bluegrass\Blues\Bundle\BluesBundle\Model\Web\Location\UrlGeneratorInterface $urlGenerator 
     */
    public function __construct(UrlGeneratorInterface $urlGenerator = null)
    {
        $this->setUrlGenerator($urlGenerator);
    }
    
    public function build(WidgetInterface $widget) 
    {
        if (!($widget instanceof BreadcrumbWidget))
            throw new Exception("Este constructor de ViewModels solo admite instancias de Bluegrass\Blues\Component\Widgets\Breadcrumb\Breadcrumb");
                
        return $this->buildInternal($widget);
    }
    
    protected function setUrlGenerator(UrlGeneratorInterface $value = null)
    {
        $this->urlGenerator = $value;
    }
    
    /**
     * 
     * @return Bluegrass\Blues\Bundle\BluesBundle\Model\Web\Location\UrlGeneratorInterface
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
        }
        
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
        $urls = array();
        $trail = $widget->getTrailFor($itemModel);
        $i=0;        
        foreach ($trail as $trailItem) {
            $urls[] =  $trailItem->getUrl()->getUrl();
            $i++;
        }
        
        $urls[] =  $itemModel->getUrl()->getUrl();
        
        $params[$prefix . '.url'] = json_encode($urls);
        
        $location = new UrlBasedLocation($itemModel->getUrl()->getUrl(), $params);

        /*
         * Si el UrlGenerator no está definido entonces tomar la url 
         * directamente del UrlBasedLocation.  
         */
        if ($this->getUrlGenerator() !== null) 
            return $this->getUrlGenerator()->generate($location);
        else
            return $location->getUrl();
    }
    
}
