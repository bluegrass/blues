<?php

namespace Bluegrass\Blues\Component\Widget\Menu\Model;

use Bluegrass\Blues\Component\Menu\MenuItemIteratorInterface;

class MenuWidgetModel implements MenuWidgetModelInterface
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
     * 
     * @return MenuItemIteratorInterface
     */
    public function getIterator()
    {
        return $this->getMenuIterator();
    }
}

