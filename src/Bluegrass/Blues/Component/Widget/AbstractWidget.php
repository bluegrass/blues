<?php

namespace Bluegrass\Blues\Component\Widget;

use Bluegrass\Blues\Component\Widget\View\Builder\WidgetViewModelBuilderInterface;
use Bluegrass\Blues\Component\Widget\Model\WidgetModelInterface;
/**
 * @author ldelia
 */
class AbstractWidget implements WidgetInterface
{
    
    private $viewModelBuilder;
    private $model;

    public function __construct( WidgetModelInterface $model,  WidgetViewModelBuilderInterface $viewModelBuilder )
    {
        $this->setModel($model);
        $this->setViewModelBuilder($viewModelBuilder);
    }
    
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

    /**
     * 
     * @return WidgetModelInterface
     */
    protected function getModel()
    {
        return $this->model;
    }

    /**
     * 
     * @param WidgetModelInterface $model
     */
    protected function setModel( WidgetModelInterface $model)
    {
        $this->model = $model;
    }    
    
    /**
     * 
     * @return \Bluegrass\Blues\Component\View\ViewModel
     */
    public function buildViewModel()
    {      
        return $this->getViewModelBuilder()->build($this);
    }    
}

