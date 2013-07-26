<?php

namespace Bluegrass\Blues\Component\Widget\Menu\Builder;

use Bluegrass\Blues\Component\Widget\Builder\AbstractWidgetBuilder;

use Bluegrass\Blues\Component\Widget\Menu\MenuWidget;
use Bluegrass\Blues\Component\Widget\Menu\Model\MenuWidgetModelInterface;
use Bluegrass\Blues\Component\Widget\Menu\View\MenuViewModelBuilderInterface;

/**
 * Clase encargada de crear instancias de MenuWidget
 *
 * @author ldelia
 */
class MenuWidgetBuilder extends AbstractWidgetBuilder implements MenuWidgetBuilderInterface
{    
    public function __construct( MenuViewModelBuilderInterface $viewModelBuilder )
    {
        $this->setViewModelBuilder($viewModelBuilder);
    }
    
    public function withModel( MenuWidgetModelInterface $widgetModel )
    {
        $this->setModel($widgetModel);
        return $this;
    }
    
    public function build()
    {
        if( is_null( $this->getModel() ) ){
            throw new \Exception("El MenuWidgetBuilder necesita que se le especifique un MenuWidgetModel para poder construir un MenuWidget");
        }
        
        return new MenuWidget( $this->getModel(), $this->getViewModelBuilder() );
    }
}

