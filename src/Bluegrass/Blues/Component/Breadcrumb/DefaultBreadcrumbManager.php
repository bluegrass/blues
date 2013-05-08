<?php

namespace Bluegrass\Blues\Component\Breadcrumb;

use Bluegrass\Blues\Bundle\BluesBundle\Model\Web\Location\UrlBasedLocation;
use Bluegrass\Blues\Bundle\BluesBundle\Model\Web\Location\UrlGeneratorInterface;
use Bluegrass\Blues\Component\Breadcrumb\Model\Item;
use Bluegrass\Blues\Component\Breadcrumb\BreadcrumbManagerInterface;
use Bluegrass\Blues\Component\Breadcrumb\Model\Breadcrumb;
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
     * @param string $url Url que se utilizará como base para obtener los
     * parámetros que modificarán la etiqueta.
     */
    protected function processNodeLabel(NodeInterface $node, $url)
    {        
        $requestParameters = $this->getRouter()->match($url);
        $nodeProcessor = new DynamicLabelNodeProcessor($requestParameters);
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
            $result->add(new Item($item['label'], new UrlBasedLocation($item['url'])));
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
            
            
            $item['url'] = $nodeUrls[$i];
            /* 
             * Procesar el nodo para actualizar su label en función
             * de una url.
             */
            $this->processNodeLabel($current, $item['url']);

            $item['label'] = $current->getLabel();
            
            $items[] = $item;
            
            $current = $current->getParent();
            $i++;
        };

        return $items;
    }
    
    /**
     * Obtiene las URLs históricas del breadcrumb.
     * 
     * Las URLs se obtienen del patrámetro GET bc.url
     * Este parámetro debería reenviarse en cada requerimiento para asegurar
     * que todas las acciones que utilicen breadcrumbs permitan el acceso a
     * urls anteriores.
     * 
     * @return array Arreglo de strings donde cada elemento contiene una URL.
     * Si el parámetro no está definido, devuelve un arreglo vacío.
     */
    protected function getHistoryUrls(Request $request)
    {
        $prefix = 'bc';
        /* 
         * Obtener las urls de los nodos históricos del breadcrumb.
        */
        $node_urls = array();
        if ($request->query->has($prefix . '.url')) {
            $node_urls = json_decode($request->query->get($prefix . '.url'));
            //Se agrega la url del requerimiento como último nodo.
            $node_urls[] = $request->getUri();            

        }
        
        return $node_urls;
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
        $node_urls = $this->getHistoryUrls($request);
        
        /*
         * Validar que la cantidad de nodos históricos sea igual a la cantidad
         * de nodos estáticos.
         */
        if (count($node_urls) != count($sitemapTrail)) {
            //Si la cantidad es diferente, ignorar los nodos históricos.            
            /* 
             * No hay urls históricas definidas. Generar las urls a partir de la
             * información de los nodos del sitemap.
             */
            foreach ($sitemapTrail as $node) {
                $url = '';
                
                if ($node->isNavigable())
                    $url = $this->getUrlGenerator()->generate($node->getLocation());
                
                $node_urls[] = $url;
            }
        }
        
        return $node_urls;
    }
    

    public function getBreadcrumb(Request $request, SitemapManagerInterface $sitemapManager) 
    {                          
        $trail = $this->getSitemapTrail($request, $sitemapManager);
        
        $nodeUrls = $this->getNodeUrls($request, $trail);
        
        $items = $this->createBreadcrumbNodesInfo($trail, $nodeUrls);
        
        return $this->createBreadcrumb($items);
    }
    
    
}

