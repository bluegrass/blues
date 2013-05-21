<?php

namespace Bluegrass\Blues\Component\Widgets\Menu\Views;

use Bluegrass\Blues\Component\Menu\MenuItemIterator;
use Bluegrass\Blues\Component\Menu\MenuItem;
use Bluegrass\Blues\Component\Views\ViewModel;
/**
 *
 * @author ldelia
 */
class MenuViewModelBuilder
{
    private $iterator;
        
    /**
     * 
     * @param \RecursiveIterator $iterator
     */
    public function __construct( \RecursiveIterator $iterator)
    {
        $this->setIterator($iterator);
    }

    /**
     * 
     * @return \RecursiveIterator
     */
    protected function getIterator()
    {
        return $this->iterator;
    }

    /**
     * 
     * @param \RecursiveIterator $iterator
     */
    protected function setIterator( \RecursiveIterator $iterator)
    {
        $this->iterator = $iterator;
    }
    
    /**
     * 
     * @param \Bluegrass\Blues\Component\Menu\MenuItem $item
     * @return \Bluegrass\Blues\Component\Views\ViewModel
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
     * @return \Bluegrass\Blues\Component\Views\ViewModel
     */
    public function buildView()
    {        
        $rit = $this->getIterator();
        
        $view = new ViewModel();
        $view->set( 'blockName', 'bluegrass_blues_menu_widget' );
        $view->set( 'items', $this->createViewModelForMenuItemIterator( $rit ) );
        return $view;        
    }
}

