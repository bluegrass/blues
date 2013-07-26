<?php

namespace Bluegrass\Blues\Component\Widget\FilterableMenu\Builder;

use Bluegrass\Blues\Component\Widget\Builder\AbstractWidgetBuilder;

use Bluegrass\Blues\Component\Widget\FilterableMenu\Model\FilterableMenuWidgetModel;
use Bluegrass\Blues\Component\Widget\FilterableMenu\View\FilterableMenuViewModelBuilderInterface;
use Bluegrass\Blues\Component\Widget\FilterableMenu\FilterableMenuWidget;

use Bluegrass\Blues\Component\Widget\Menu\Model\MenuWidgetModel;
use Bluegrass\Blues\Component\Widget\Menu\Builder\MenuWidgetBuilderInterface;

/**
 * Clase encargada de crear instancias de FilterableMenuWidget
 *
 * @author ldelia
 */
class FilterableMenuWidgetBuilder extends AbstractWidgetBuilder implements FilterableMenuWidgetBuilderInterface
{    
    private $menuWidgetBuilder;   
    
    public function __construct( FilterableMenuViewModelBuilderInterface $viewModelBuilder, MenuWidgetBuilderInterface $menuWidgetBuilder )
    {
        $this->setViewModelBuilder($viewModelBuilder);
        
        $this->setMenuWidgetBuilder($menuWidgetBuilder);
    }

    /**
     * 
     * @return MenuWidgetBuilderInterface
     */
    private function getMenuWidgetBuilder()
    {
        return $this->menuWidgetBuilder;
    }

    private function setMenuWidgetBuilder( MenuWidgetBuilderInterface $menuWidgetBuilder)
    {
        $this->menuWidgetBuilder = $menuWidgetBuilder;
    }
    
    /**
     * 
     * @param FilterableMenuWidgetModel $menuWidgetModel
     * @return FilterableMenuWidgetBuilder
     */
    public function withModel( FilterableMenuWidgetModel $model )
    {
        $this->setModel($model);
        return $this;
    }
    
    /**
     * 
     * @return FilterableMenuWidget
     * @throws \Exception
     */
    public function build()
    {
        if( is_null( $this->getModel() ) ){
            throw new \Exception("El FilterableMenuWidgetBuilder necesita que se le especifique un FilterableMenuWidgetModel para poder construir un FilterableMenuWidget");
        }

        $menuWidget = $this->getMenuWidgetBuilder()->withModel( new MenuWidgetModel( $this->getModel()->getIterator() ) )->build();                
        
        $filterableMenuWidget = new FilterableMenuWidget( $this->getModel() , $this->getViewModelBuilder() );
        $filterableMenuWidget->setMenuWidget($menuWidget);
        
        return $filterableMenuWidget;
    }
}