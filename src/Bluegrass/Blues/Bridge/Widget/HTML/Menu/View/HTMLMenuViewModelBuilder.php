<?php

namespace Bluegrass\Blues\Bridge\Widget\HTML\Menu\View;

use Bluegrass\Blues\Component\Menu\MenuItem;

use Bluegrass\Blues\Component\Widget\View\WidgetViewModel;
use Bluegrass\Blues\Component\View\ViewModel;

use Bluegrass\Blues\Component\Widget\WidgetInterface;
use Bluegrass\Blues\Component\Widget\Menu\MenuWidget;
use Bluegrass\Blues\Component\Widget\Menu\View\MenuViewModelBuilderInterface;

/**
 *
 * @author ldelia
 */
class HTMLMenuViewModelBuilder implements MenuViewModelBuilderInterface
{
    /**
     * 
     * @param \Bluegrass\Blues\Component\Menu\MenuItem $item
     * @return \Bluegrass\Blues\Component\View\ViewModel
     */
    protected function createViewModelForMenuItem( MenuItem $item )
    {
        $view = new ViewModel();
        $view->set( 'name', $item->getName() );
        $view->set( 'label', $item->getLabel() );
        $view->set( 'current', $item->isCurrent() );
        $view->set( 'children', array() );
        
        return $view;
    }
    
    protected function createViewModelForMenuItemIterator(\RecursiveIterator $rit )
    {                
        $itemsViews = array();
        $rit->rewind();

        while ($rit->valid())
        {
            $item = $rit->current();
            
            $view = $this->createViewModelForMenuItem($item);
        
            if( $rit->hasChildren() ){
                $childrenView = $this->createViewModelForMenuItemIterator( $rit->getChildren() );
                $view->set( 'children', $childrenView );       
            }            
        
             $itemsViews[] = $view;
             $rit->next();
        }        
        return $itemsViews;
    }    
    
    /**
     * 
     * @return \Bluegrass\Blues\Component\View\ViewModel
     */
    public function build( WidgetInterface $widget )
    {        
        if (!($widget instanceof MenuWidget))
            throw new \Exception("Este constructor de ViewModels solo admite instancias de Bluegrass\Blues\Component\Widget\Menu\MenuWidget");
                
        return $this->buildInternal($widget);
    }

    /**
     * 
     * @return WidgetViewModel
     */    
    protected function buildInternal( MenuWidget $menuWidget )
    {          
        $rit = $menuWidget->getIterator();
        
        $viewModel = new WidgetViewModel();
        $viewModel->setTemplate('@BluegrassBluesWidget/html.html.twig' );
        $viewModel->setBlockName( 'bluegrass_blues_menu_widget' );
        $viewModel->set( 'items', $this->createViewModelForMenuItemIterator( $rit ) );
        return $viewModel;                
    }
}

