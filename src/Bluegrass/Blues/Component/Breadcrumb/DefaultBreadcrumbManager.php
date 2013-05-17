<?php

namespace Bluegrass\Blues\Component\Breadcrumb;

use Bluegrass\Blues\Bundle\BluesBundle\Model\Web\Location\RouteBasedLocation;
use Bluegrass\Blues\Bundle\BluesBundle\Model\Web\Location\UrlGeneratorInterface;
use Bluegrass\Blues\Component\Breadcrumb\BreadcrumbManagerInterface;
use Bluegrass\Blues\Component\Breadcrumb\Model\Breadcrumb;
use Bluegrass\Blues\Component\Breadcrumb\Model\Item;
use Bluegrass\Blues\Component\Breadcrumb\Sitemap\DynamicLabelNodeProcessor;
use Bluegrass\Blues\Component\Sitemap\NodeInterface;
use Bluegrass\Blues\Component\Sitemap\SitemapManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Router;
use Symfony\Component\Routing\RouterInterface;

/**
 * Implementación por defecto de un administrador de breadcrumbs.
 * 
 * Esta implementación soporta el uso de nodos de etiquetas dinámicas basados
 * en los parámetros de las rutas definidas en el sitemap.
 *
 * @author gcaseres
 */
class DefaultBreadcrumbManager implements BreadcrumbManagerInterface
{
    private $urlGenerator;
    
    public function __construct(UrlGeneratorInterface $urlGenerator, RouterInterface $router) 
    {
        $this->setUrlGenerator($urlGenerator);
        $this->setRouter($router);
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
     * Procesa la etiqueta de un nodo del breadcrumb para que se muestre en 
     * función de los parámetros de la URL a la que hace referencia.
     *  
     * @param NodeInterface $node
     * @param RouteBasedLocation $location WebLocation que se utilizará como 
     * base para obtener los parámetros que modificarán la etiqueta.
     */
    protected function processNodeLabel(NodeInterface $node, RouteBasedLocation $location)
    {        

        //$requestParameters = $this->getRouter()->match($url);
        $nodeProcessor = new DynamicLabelNodeProcessor($location->getParameters());
        $nodeProcessor->process($node);    
    }
   
    /**
     * Genera un breadcrumb a partir de la información de los nodos
     * que debe contener.
     * 
     * @param array $nodesInfo Arreglo asociativo con información sobre los
     * nodos del breadcrumb a generar. Se esperan las claves 'url' y 'label'.
     * 
     * @result Bluegrass\Blues\Component\Breadcrumb\Model\Breadcrumb Breadcrumb
     * generado.
     */
    protected function createBreadcrumb(array $nodesInfo)
    {
        $result = new Breadcrumb(); 
        
        //Agregar los items al breadcrumb
        foreach ($nodesInfo as $item) {
            $result->add(new Item($item['name'], $item['label'], $item['location']));
        }
        
        return $result;        
    }
    
    
    /**
     * Genera un arreglo con la información que deberán tener los nodos del
     * breadcrumb.
     * 
     * @param array $sitemapNodes Arreglo que contiene los nodos de sitemap
     * que conforman el breadcrumb.
     * 
     * @param array $nodeUrls Arreglo de strings que contiene las urls completas
     * para cada uno de los nodos.
     * 
     * @return array Arreglo con información consolidada para cada uno de los
     * nodos del breadcrumb. Cada elemento del arreglo es un arreglo asociativo
     * con claves 'url' y 'label'.
     */
    protected function createBreadcrumbNodesInfo($sitemapNodes, $nodeUrls)
    {
        /* 
         * Obtener información completa para generar los nodos del breadcrumb.
         */        
        $items = array();
        $i=0;
        foreach ($sitemapNodes as $current) {
            $item = array();
            
            
            $item['location'] = $nodeUrls[$i];
            /* 
             * Procesar el nodo para actualizar su label en función
             * de una url.
             * Solo se procesan los nodos que tienen un location (son navegables)
             */
            $this->processNodeLabel($current, $item['location']);

            $item['label'] = $current->getLabel();
            $item['name'] = $current->getName();
            
            $items[] = $item;
            
            $current = $current->getParent();
            $i++;
        };

        return $items;
    }
    
    /**
     * Obtiene los parámetros de estado del breadcrumb.
     * 
     * El estado se obtiene del parámetro GET bc_url
     * Este parámetro debería reenviarse en cada requerimiento para asegurar
     * que todas las acciones que utilicen breadcrumbs permitan el acceso al
     * estado del breadcrumb de acuerdo a la manera que accedió el usuario a
     * cada nodo.
     * 
     * @return array Arreglo de arreglos donde cada elemento contiene los
     * parámetros.
     * Si no está definido 'bc_url', devuelve un arreglo vacío.
     */
    protected function getViewStateParams(Request $request)
    {
        $prefix = 'bc';
        /* 
         * Obtener los parámetros históricos de los nodos del breadcrumb.
        */
        try {
            $nodes_params = array();
            if ($request->query->has($prefix . '_url')) {
                $nodes_params = json_decode(gzuncompress(base64_decode($request->query->get($prefix . '_url'))), true);
            }
        } catch (\Exception $e) {
            return null;
        }
        
        $result = array();        
        foreach ($nodes_params as $node_params) { 
            $result[] = $node_params;
        }
        
        return $result;
    }
    
    /**
     * Obtiene un arreglo de nodos de sitemap que simboliza el camino estático
     * para el requerimiento especificado.
     * 
     * @param Request $request
     * @param SitemapManagerInterface $sitemapManager
     * 
     * @return array Nodos del sitemap que representan un camino estático.
     */
    protected function getSitemapTrail(Request $request, SitemapManagerInterface $sitemapManager)
    {
        $currentSitemapNode = $sitemapManager->getCurrentSitemapNode($request);
        
        /*
         * Obtener el breadcrumb estático a partir de los nodos del sitemap.
         */
        $current = $currentSitemapNode;
                
        $trail = array();
        while ($current != null) {
            array_unshift($trail, $current);            
            $current = $current->getParent();
        }
        

        return $trail;
    }
    
    /**
     * Obtiene un arreglo con las URLs que deberá tener cada uno de los nodos
     * del breadcrumb a partir de un camino de nodos de sitemap.
     * 
     * @param Request $request Requerimiento
     * actual.
     * @param array $sitemapTrail Arreglo de nodos de sitemap que simboliza
     * el camino estático para el breadcrumb actual.
     * 
     * @return array Arreglo de strings donde cada string representa la URL de
     * cada uno de los nodos del breadcrumb.
     */
    protected function getNodeUrls(Request $request, $sitemapTrail)
    {
        $nodes_params = $this->getViewStateParams($request);
        $nodes_locations = array();

        $fallback = true;
        
        /*
         * Se recorre cada nodo del sitemap.
         * Al mismo tiempo avanza sobre los nodos del ViewState y verifica que
         * el nombre del nodo del ViewState sea equivalente al nombre del nodo
         * del Sitemap.
         * Mientras se cumpla esta condición, utiliza los parámetros residentes
         * en el ViewState para cada nodo.
         * 
         * En caso que se acaben los nodos del ViewState, se sigue avanzando pero
         * se toman los valores por defecto para los parámetros definidos en los
         * nodos del Sitemap.
         * 
         * Si en algún momento uno de los nodos del Sitemap contiene un nombre
         * diferente al ViewState, se activa el flag "fallback" y se vuelve
         * a regenerar la lista de URLs pero tomando solo los valores del Sitemap.
         */
        for ($i=0; $i < count($sitemapTrail); $i++) {
            $fallback = false;
            if ($i < count($nodes_params) && $nodes_params[$i]['name'] == $sitemapTrail[$i]->getName()) {
                $nodes_locations[$i] = new RouteBasedLocation($sitemapTrail[$i]->getLocation()->getName(), $nodes_params[$i]['params']);
            } else {
                if ($i >= count($nodes_params)) {
                    $nodes_locations[] = new RouteBasedLocation($sitemapTrail[$i]->getLocation()->getName(), $sitemapTrail[$i]->getLocation()->getParameters());
                } else {
                    $fallback = true;
                    break;
                }
            }
        }        

        if ($fallback) {                     
            /* 
             * No hay urls históricas definidas o no es posible generar el breadcrumb
             * a partir de las mismas. Generar las urls de los nodos a partir de la
             * información de los nodos del sitemap.
             */            
            foreach ($sitemapTrail as $node) {
                $nodes_locations[] = new RouteBasedLocation($node->getLocation()->getName(), $node->getLocation()->getParameters());
            }
        }
        
        
        //Agregar al nodo final (el actual) los parámetros del requerimiento
        $current = $nodes_locations[count($nodes_locations) - 1];        
        $request_params = $request->query->all();
        unset($request_params['bc_url']); //Quitar el parámetro de estado del breadcrumb.
        $nodes_locations[count($nodes_locations) - 1] = new RouteBasedLocation($current->getName(), array_merge($current->getParameters(), $request_params));
                
        return $nodes_locations;
    }
    

    public function getBreadcrumb(Request $request, SitemapManagerInterface $sitemapManager) 
    {                          
        $trail = $this->getSitemapTrail($request, $sitemapManager);
        
        $nodeUrls = $this->getNodeUrls($request, $trail);
        
        $items = $this->createBreadcrumbNodesInfo($trail, $nodeUrls);
        
        return $this->createBreadcrumb($items);
    }
    
    
}

