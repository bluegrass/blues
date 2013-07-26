<?php

namespace Bluegrass\Blues\Bundle\WidgetBundle\Controller;

use Bluegrass\Blues\Component\Menu\MenuManagerInterface;

use Bluegrass\Blues\Component\Widget\Menu\Model\MenuWidgetModel;
use Bluegrass\Blues\Component\Widget\FilterableMenu\Model\FilterableMenuWidgetModel;

use Bluegrass\Blues\Bundle\WidgetBundle\Widgets\Menu\FilterableMenu\Controller\FilterableMenuController as Controller;


class FilterableMenuController extends Controller
{
    public function __construct( $container, MenuManagerInterface $menuManager )
    {
        $this->container = $container;
        $this->setMenuManager($menuManager);
    }
    
    public function filterAction( $filterPattern = '' )
    {
        $menu = $this->getMenuManager()->getMenu();
        
        $filterableMenuWidget = $this->get('bluegrass.widget.filterablemenu.builder')->withModel( new FilterableMenuWidgetModel( $menu->getIterator() ) )->build();
        $filterableMenuWidget->filter( $filterPattern );        
        
        $menuWidget = $this->get('bluegrass.widget.menu.builder')->withModel( new MenuWidgetModel( $filterableMenuWidget->getIterator() ) )->build();        
        
        return $this->render('BluegrassBluesWidgetBundle:FilterableMenu:filter.html.twig', array( 'menu' => $menuWidget->buildViewModel() ));
    }
}
