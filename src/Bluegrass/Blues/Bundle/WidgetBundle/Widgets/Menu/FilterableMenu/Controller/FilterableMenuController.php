<?php

namespace Bluegrass\Blues\Bundle\WidgetBundle\Widgets\Menu\FilterableMenu\Controller;

use Bluegrass\Blues\Component\Menu\MenuManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FilterableMenuController extends Controller
{
    protected $menuManager;
    
    /**
     * 
     * @return MenuManagerInterface
     */
    protected function getMenuManager()
    {
        return $this->menuManager;
    }

    protected function setMenuManager( MenuManagerInterface $menuManager)
    {
        $this->menuManager = $menuManager;
    }           
}
