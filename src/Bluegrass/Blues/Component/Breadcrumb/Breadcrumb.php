<?php

namespace Bluegrass\Blues\Component\Breadcrumb;

use Bluegrass\Blues\Bundle\BluesBundle\Model\Web\Location\UrlBasedLocation;
use Bluegrass\Blues\Bundle\BluesBundle\Model\Web\Location\UrlGeneratorInterface;
use Bluegrass\Blues\Bundle\BluesBundle\Model\Web\Location\WebLocation;
use Bluegrass\Blues\Bundle\BluesBundle\Model\Web\View\View;
use Bluegrass\Blues\Component\Breadcrumb\Model\Breadcrumb as BreadcrumbModel;
use Bluegrass\Blues\Component\Breadcrumb\Model\Item;
use Bluegrass\Blues\Component\Breadcrumb\Sitemap\DynamicLabelNodeProcessor;
use Bluegrass\Blues\Component\Sitemap\NodeInterface;
use Bluegrass\Blues\Component\Sitemap\SitemapManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Router;
use Symfony\Component\Routing\RouterInterface;


/**
 * Clase encargada de generar el camino que navegó el usuario para llegar a un
 * nodo del mapa de un sitio.
 * Esta implementación se basa en dos conceptos:
 *  - Camino estático
 *    - Se genera a partir de la estructura del Sitemap definido para el sitio.
 *  - Camino dinámico
 *    - Se genera a partir del histórico obtenido por las urls definidas en los
 *      parámetros recibidos por GET en el requerimiento. 
 *      El parámetro que recibe el breadcrumb debe ser un arreglo de arreglos de
 *      URLs en formato JSON.
 *      Cada elemento del arreglo de primer nivel se corresponde con un nodo del
 *      camino estático.
 *      Cada elemento de los arreglos de segundo nivel se corresponden con los
 *      nodos de camino dinámico de cada nodo estático.
 * 
 *  11/04/2013 : Se eliminó el concepto de camino dinámico por el momento.
 */
class Breadcrumb
{
    private $request;
    private $urlGenerator;
    private $model;
    private $router;
    
    public function __construct(RouterInterface $router, SitemapManagerInterface $sitemapManager, Request $request, UrlGeneratorInterface $urlGenerator)
    {
        $this->setRequest($request);
        $this->setUrlGenerator($urlGenerator);        
        $this->setRouter($router);
        $currentSitemapNode = $sitemapManager->getCurrentSitemapNode($request);
        $this->createModelFromRequest($currentSitemapNode, $request);        
    }
    
    protected function setRouter(RouterInterface $value)
    {
        $this->router = $value;
    }
    
    /**
     * 
     * @return Router
     */
    protected function getRouter()
    {
        return $this->router;
    }
    
    /**
     * Genera los nodos del breadcrumb a partir de un requerimiento.
     * 
     * Este método se encarga de reconstruir los nodos a partir del
     * requerimiento actual y de la información de nodos anteriores provista
     * como parámetro HTTP GET.
     * 
     * Este método también utiliza la información provista para procesar los
     * nodos del sitemap que tengan labels dinámicos.
     * @see Bluegrass\Blues\Component\Breadcrumb\Sitemap\DynamicLabelNodeInterface
     * 
     * @param \Bluegrass\Blues\Component\Sitemap\NodeInterface $currentSitemapNode
     * @param \Symfony\Component\HttpFoundation\Request $request
     */
    protected function createModelFromRequest(NodeInterface $currentSitemapNode, Request $request)
    {
        $prefix = 'bc'; //TODO: Especificar prefijo en otro lugar configurable.
        
        $this->setModel(new BreadcrumbModel());
        
        
        $items = array();       
                
        /* Procesar el nodo actual para actualizar su label en función
         * de los parámetros del requerimiento.
         */
        $requestParameters = $request->attributes->get('_route_params');
        $nodeProcessor = new DynamicLabelNodeProcessor($requestParameters);
        $nodeProcessor->process($currentSitemapNode);
        
        /* Generar breadcrumb estático a partir del sitemap */
        $current = $currentSitemapNode;                
        
        do {
            $item = array();
            
            if ($current->isNavigable())
                $item['url'] = $this->getUrlGenerator()->generate($current->getLocation());

            /* Procesar el nodo para actualizar su label en función
             * de los parámetros de la url.
             */
            $requestParameters = $this->getRouter()->match($item['url']);
            $nodeProcessor = new DynamicLabelNodeProcessor($requestParameters);
            $nodeProcessor->process($current);

            $item['label'] = $current->getLabel();
            
            array_push($items, $item);
            
            $current = $current->getParent();
        } while ($current != null);

        
        /* Generar nodos dinámicos del breadcrumb */
        $requestItems = array();
        if ($request->query->has($prefix . '.url')) {
            $requestItems = json_decode($request->query->get($prefix . '.url'));
        }
        
        /* El breadcrumb contiene las URLs de los nodos con los valores
         * actuales para cada parámetro. Por lo tanto se sobreescriben las
         * urls de los nodos del sitemap. */
        for ($i=0; $i < count($requestItems); $i++) {
            $item = $items[$i];
            $item['url'] = $requestItems[$i];

            $items[$i] = $item;
        }
        
        foreach ($items as $item) {
            $this->addItem($item['label'], new UrlBasedLocation($item['url']));
        }
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
    
    protected function setModel(BreadcrumbModel $value)
    {
        $this->model = $value;
    }
    
    /**
     * 
     * @return Breadcrumb
     */
    protected function getModel()
    {
        return $this->model;
    }
    
    protected function setRequest(Request $value)
    {
        $this->request = $value;
    }   
    
    /**
     * 
     * @return Request
     */
    protected function getRequest()
    {
        return $this->request;
    }
    
    /**
     * Genera una url para el item especificado.
     * La url generada contiene los parámetros necesarios para reconstruir
     * el breadcrumb.
     * 
     * @param Item $itemModel
     * @return string Url generada para el item especificado.
     */
    protected function getUrlForItem(Item $itemModel)
    {
        $prefix = 'bc'; //TODO: Hacerlo parametrizable
        $urls = array();
        $trail = $this->getModel()->getTrailFor($itemModel);
        $i=0;        
        foreach ($trail as $trailItem) {
            $urls[] =  $trailItem->getUrl();
            $i++;
        }
        
        $urls[] =  $itemModel->getUrl();
        
        $params[$prefix . '.url'] = json_encode($urls);
        
        return $this->getUrlGenerator()->generate(new UrlBasedLocation($itemModel->getUrl(), $params));
    }
    
    protected function createItemView(Item $itemModel)
    {
        $view = new View();
                
        $view->set('title', $itemModel->getTitle());
        $view->set('url', $this->getUrlForItem($itemModel));
        
        return $view;
    }
    
    public function createView()
    {                
        $view = new View();
        
        $view->set('theme', 'BluegrassBluesBreadcrumbBundle:Breadcrumb:breadcrumb.html.twig');
        $view->set('count', $this->getModel()->count() );
        
        $items = array();
        
        foreach ($this->getModel() as $itemModel) {
            $items[] = $this->createItemView($itemModel);
        }
        
        $view->set('items', $items);
        
        return $view;
    }
    
    public function addItem($title, WebLocation $location)
    {
        $url = $this->getUrlGenerator()->generate($location);
        
        $item = new Item($title, $url);
        $this->getModel()->add($item);
    }
}
