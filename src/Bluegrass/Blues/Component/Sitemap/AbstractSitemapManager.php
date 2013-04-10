<?php

namespace Bluegrass\Blues\Component\Sitemap;

use Symfony\Component\HttpFoundation\Request;

abstract class AbstractSitemapManager implements SitemapManagerInterface
{
    private $sitemap;
    
    public function __construct()
    {
        $this->setSitemap($this->buildSitemap());
    }
    
    protected function setSitemap(Sitemap $value)
    {
        $this->sitemap = $value;
    }
    
    /**
     * 
     * @return Sitemap
     */
    public function getSitemap()
    {
        return $this->sitemap;
    }
    
    public function getCurrentSitemapNode(Request $request)
    {
        $routeName = $request->get('_route');
        $routeParameters = $request->get('_route_params');

        $it = new RouteSitemapNodeFilterIterator($this->getSitemap()->getIterator(), $routeName, $routeParameters);
                        
        $nodes = new \ArrayObject(iterator_to_array($it, false));
        
        if ($nodes->count() > 1)
            throw new \Exception("Se encontró mas de un nodo en el sitemap que coincide con el requerimiento HTTP.");
        
        if ($nodes->count() == 0)
            return null;
        else
            return $nodes[0];
        
    }    
    
    protected abstract function buildSitemap();
    
}

