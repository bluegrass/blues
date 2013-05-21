<?php

namespace Bluegrass\Blues\Component\Widgets\Menu;

use Bluegrass\Blues\Component\Widgets\Menu\Model\MenuWidgetModelInterface;
use Bluegrass\Blues\Component\Widgets\WidgetInterface;
use Bluegrass\Blues\Component\Widgets\Menu\Views\MenuViewModelBuilder;

class MenuWidget implements WidgetInterface
{
    private $model;
    
    /**
     * 
     * @param \Bluegrass\Blues\Component\Widgets\Menu\Model\MenuWidgetModelInterface $menuWidgetModel
     */
    public function __construct( MenuWidgetModelInterface $menuWidgetModel )
    {
        $this->setModel( $menuWidgetModel );        
    }
    
    /**
     * 
     * @return MenuWidgetModelInterface
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * 
     * @param MenuWidgetModelInterface $model
     */
    public function setModel( MenuWidgetModelInterface $model)
    {
        $this->model = $model;
    }    
    
    public function buildView()
    {      
        $menuViewModelBuilder = new MenuViewModelBuilder( $this->getModel()->getIterator() );
        return $menuViewModelBuilder->buildView();
    }
}

