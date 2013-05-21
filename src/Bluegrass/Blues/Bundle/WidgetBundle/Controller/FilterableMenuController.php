<?php

namespace Bluegrass\Blues\Bundle\WidgetBundle\Controller;

use Bluegrass\Blues\Component\Widgets\FilterableMenu\FilterableMenuWidget;
use Bluegrass\Blues\Component\Menu\MenuManagerInterface;

use Bluegrass\Blues\Component\Widgets\Menu\MenuWidget;

use Bluegrass\Blues\Bundle\WidgetBundle\Widgets\Menu\FilterableMenu\Controller\FilterableMenuController as Controller;
use Bluegrass\Blues\Component\Widgets\FilterableMenu\Model\FilterableMenuWidgetModel;

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
        
        $filterableMenuWidget = new FilterableMenuWidget( new FilterableMenuWidgetModel( $menu ) );        
        $filterableMenuWidget->filter( $filterPattern );
        
        $menuWidget = new MenuWidget( $filterableMenuWidget->getModel() );        
        return $this->render('BluegrassBluesWidgetBundle:FilterableMenu:filter.html.twig', array( 'menu' => $menuWidget->buildView() ));
    }
}
