<?php

namespace Bluegrass\Blues\Component\Widgets\Menu\Model;

use Bluegrass\Blues\Component\Menu\MenuItemInterface;
use Bluegrass\Blues\Component\Menu\MenuItemIterator;

class MenuWidgetModel implements MenuWidgetModelInterface
{
    private $menu;
           
    /**
     * 
     * @param MenuItemInterface $menu
     */
    public function __construct(  MenuItemInterface $menu )
    {
        $this->setMenu($menu);
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
     * @return MenuItemIterator
     */
    public function getIterator()
    {
        return $this->getMenu()->getIterator();
    }
}

