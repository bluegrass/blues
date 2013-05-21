<?php

namespace Bluegrass\Blues\Component\Widgets\FilterableMenu;

use Bluegrass\Blues\Component\Views\ViewModel;

use Bluegrass\Blues\Component\Widgets\Menu\MenuWidget;
use Bluegrass\Blues\Component\Widgets\Menu\Model\MenuWidgetModel;
use Bluegrass\Blues\Component\Widgets\FilterableMenu\Model\FilterableMenuWidgetModel;
use Bluegrass\Blues\Component\Widgets\WidgetInterface;
use Bluegrass\Blues\Component\Menu\MenuItemIterator;

class FilterableMenuWidget implements WidgetInterface
{
    
    private $model;
    private $menuWidget;
    
    /**
     * 
     * @param FilterableMenuWidgetModel $filterableMenuWidgetModel
     */
    public function __construct( FilterableMenuWidgetModel $filterableMenuWidgetModel )
    {
        $this->setModel( $filterableMenuWidgetModel );                 
        $this->setMenuWidget( new MenuWidget( new MenuWidgetModel( $filterableMenuWidgetModel->getMenu() ) ) );
    }
    
    /**
     * 
     * @return MenuWidget
     */
    private function getMenuWidget()
    {
        return $this->menuWidget;
    }

    private function setMenuWidget($menuWidget)
    {
        $this->menuWidget = $menuWidget;
    }    
    
    /**
     * 
     * @return FilterableMenuWidgetModel
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * 
     * @param FilterableMenuWidgetModel $model
     */
    public function setModel( FilterableMenuWidgetModel $model)
    {
        $this->model = $model;
    }    
    
    public function filter( $filterPattern )
    {
        if( $filterPattern != "" ){
            $this->getModel()->filter($filterPattern);                        
        }        
    }    
        
    /**
     * 
     * @return MenuItemIterator
     */
    public function getIterator()
    {
        return $this->getModel()->getIterator();
    }    
    
    /**
     * 
     * @return \Bluegrass\Blues\Component\Views\ViewModel
     */
    public function buildView()
    {      
        $view = new ViewModel();
        $view->set( 'blockName', 'bluegrass_blues_filterablemenu_widget' );
        $view->set( 'menuWidget', $this->getMenuWidget()->buildView() );
        return $view;
    }
}

