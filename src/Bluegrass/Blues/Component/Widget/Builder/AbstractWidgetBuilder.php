<?php

namespace Bluegrass\Blues\Component\Widget\Builder;

use Bluegrass\Blues\Component\Widget\Model\WidgetModelInterface;
use Bluegrass\Blues\Component\Widget\View\Builder\WidgetViewModelBuilderInterface;

/**
 *
 * @author ldelia
 */
abstract class AbstractWidgetBuilder implements WidgetBuilderInterface
{
    private $viewModelBuilder = null;
    private $model = null;
    
    abstract public function build();
    
    /**
     * 
     * @return WidgetViewModelBuilderInterface
     */
    protected function getViewModelBuilder()
    {
        return $this->viewModelBuilder;
    }

    protected function setViewModelBuilder( WidgetViewModelBuilderInterface $viewModelBuilder)
    {
        $this->viewModelBuilder = $viewModelBuilder;
    }    
    
    public function setModel( WidgetModelInterface $widgetModel)
    {
        $this->model = $widgetModel;
    }
    
    /**
     * 
     * @return WidgetModelInterface
     */
    protected function getModel()
    {
        return $this->model;
    }    
}

