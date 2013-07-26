<?php

namespace Bluegrass\Blues\Component\Widget\FilterableMenu\Model;

use Bluegrass\Blues\Component\Menu\MenuItemIterator;
use Bluegrass\Blues\Component\Widget\Menu\Model\MenuWidgetModelInterface;
use Bluegrass\Blues\Component\Menu\MenuItemIteratorInterface;

/**
 * Clase model del widget encargada de filtrar el menú por una palabra clave
 */
class FilterableMenuWidgetModel implements MenuWidgetModelInterface
{ 
    private $menuIterator;
           
    /**
     * 
     * @param MenuItemIteratorInterface $menuIterator
     */
    public function __construct(  MenuItemIteratorInterface $menuIterator )
    {
        $this->setMenuIterator($menuIterator);
    }
            
    /**
     * 
     * @return MenuItemIteratorInterface
     */
    protected function getMenuIterator()
    {
        return $this->menuIterator;
    }

    protected function setMenuIterator( MenuItemIteratorInterface $menuIterator)
    {
        $this->menuIterator = $menuIterator;
    }    
    
    /**
     * Filtra los items que cumplen un filtro dado
     * @param string $filterPattern
     */
    public function filter( $filterPattern )
    {        
        $it = new \RecursiveIteratorIterator($this->getMenuIterator(), \RecursiveIteratorIterator::SELF_FIRST);
        
        $flat = new \ArrayObject();
        foreach( $it as $item ){
            $flat->append($item);
        }
                
        $filterableMenuIterator  = new FilterableMenuItemIterator( new MenuItemIterator( $flat ) );
        $filterableMenuIterator->setFilterPattern($filterPattern);
        
        $this->setMenuIterator($filterableMenuIterator);
    }
    
    /**
     * 
     * @return MenuItemIteratorInterface 
     */
    public function getIterator()
    {
        return $this->getMenuIterator();
    }
}

