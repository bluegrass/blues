<?php

namespace Bluegrass\Blues\Component\Widgets\FilterableMenu\Model;


use Bluegrass\Blues\Component\Menu\MenuItemInterface;
use Bluegrass\Blues\Component\Menu\MenuItem;
use Bluegrass\Blues\Component\Menu\MenuItemIterator;
use Bluegrass\Blues\Component\Widgets\Menu\Model\MenuWidgetModelInterface;

/**
 * Clase model del widget encargada de filtrar el menú por una palabra clave
 */
class FilterableMenuWidgetModel implements MenuWidgetModelInterface
{
    private $menu;    
    private $filterableMenuIterator;
           
    /**
     * 
     * @param MenuItemInterface $menu
     */
    public function __construct(  MenuItemInterface $menu )
    {
        $this->setMenu($menu);
        $this->setFilterableMenuIterator( null );
    }

    /**
     * 
     * @return MenuItemInterface
     */
    public function getMenu()
    {
        return $this->menu;
    }

    /**
     * 
     * @param MenuItemInterface $menu
     */
    private function setMenu( MenuItemInterface $menu)
    {
        $this->menu = $menu;
    }    
    
    /**
     * 
     * @return FilterableMenuItemIterator
     */
    private function getFilterableMenuIterator()
    {
        return $this->filterableMenuIterator;
    }

    /**
     * 
     * @param FilterableMenuItemIterator $filterableMenuIterator
     */
    private function setFilterableMenuIterator( FilterableMenuItemIterator $filterableMenuIterator = null )
    {
        $this->filterableMenuIterator = $filterableMenuIterator;
    }
    
    /**
     * Filtra los items que cumplen un filtro dado
     * @param string $filterPattern
     */
    public function filter( $filterPattern )
    {        
        $it = new \RecursiveIteratorIterator($this->getMenu()->getIterator(), \RecursiveIteratorIterator::SELF_FIRST);
        
        $flat = new \ArrayObject();
        foreach( $it as $item ){
            $flat->append($item);
        }
                
        $filterableMenuIterator  = new FilterableMenuItemIterator( new MenuItemIterator( $flat ) );
        $filterableMenuIterator->setFilterPattern($filterPattern);
        
        $this->setFilterableMenuIterator($filterableMenuIterator);
    }
    
    /**
     * 
     * @return \RecursiveIterator
     */
    public function getIterator()
    {
        if ( is_null ( $this->getFilterableMenuIterator() ) ){
            return $this->getMenu()->getIterator();
        }else{            
            return $this->getFilterableMenuIterator();
        }
    }
}

