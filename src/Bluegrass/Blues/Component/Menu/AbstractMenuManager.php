<?php

namespace Bluegrass\Blues\Component\Menu;

use Bluegrass\Blues\Component\Menu\Iterators\RouteItemFilterIterator;
use Knp\Menu\MenuItem;
use Knp\Menu\FactoryInterface;
use Knp\Menu\Iterator\RecursiveItemIterator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

abstract class AbstractMenuManager implements MenuManagerInterface
{
    private $router;
    private $menu;
    
    public function __construct(Request $request, FactoryInterface $menuFactory)
    {
        //$this->setRouter($router);
        
        $this->setMenu($this->buildMenu($menuFactory));
        
        $this->setMenuCurrentItems($request);
        
        
    }

    
    protected function setRouter(RouterInterface $value)
    {
        $this->router = $value;
    }
    
    /**
     * 
     * @return Symfony\Component\Routing\RouterInterface
     */
    protected function getRouter()
    {
        return $this->router;
    }
    
    
    protected function setMenu(MenuItem $value)
    {
        $this->menu = $value;
    }
    
    /**
     * 
     * @return Knp\Menu\MenuItem
     */
    public function getMenu()
    {
        return $this->menu;
    }
    
    
    /**
     * Establece los items actuales (current) del menú para el requerimiento especificado.
     * 
     * @param \Symfony\Component\HttpFoundation\Request $request
     */
    protected function setMenuCurrentItems(Request $request)
    {        
        $routeName = $request->attributes->get('_route');
        $routeParameters = $request->attributes->get('_route_params');
        
        $iterator = new RouteItemFilterIterator(
                new \RecursiveIteratorIterator(
                        new RecursiveItemIterator(
                                $this->getMenu()->getIterator()
                                ), 
                        \RecursiveIteratorIterator::SELF_FIRST), 
                $routeName, 
                $routeParameters
        );
        
                
        //TODO: El iterator debería devolver toda la rama para evitar el segundo while.
        
        foreach ($iterator as $iteratorItem) {
            $item = $iteratorItem;
        }
        
        while (!$item->isRoot()) {
            $item->setCurrent(true);
            $item = $item->getParent();
        }
                
    }
    
    /**
     * 
     * @param \Symfony\Component\HttpFoundation\Request $request
     */
    public function getCurrentBreadcrumbItems(Request $request)
    {
        
        //$iterator = new CurrentItemFilterIterator($this->getMenu());
        
    }
    
    /**
     * 
     * @return Knp\Menu\MenuItem
     */
    protected abstract function buildMenu(FactoryInterface $factory);
}
