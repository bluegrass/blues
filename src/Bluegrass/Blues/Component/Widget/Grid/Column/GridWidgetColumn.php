<?php

namespace Bluegrass\Blues\Component\Widget\Grid\Column;

use Bluegrass\Blues\Component\Widget\Grid\Model\Column\GridWidgetColumnModelInterface;
use Bluegrass\Blues\Component\Widget\Grid\View\Column\GridWidgetColumnViewModelBuilderInterface;
use Bluegrass\Blues\Component\Widget\Grid\View\Column\GridWidgetColumnCellViewModelBuilderInterface;
/**
 *
 * @author ldelia
 */
class GridWidgetColumn implements GridWidgetColumnInterface
{
    private $name;
    private $label;
    private $model;
    private $viewModelBuilder;
    private $cellViewModelBuilder;

    public function __construct($name, $label, GridWidgetColumnModelInterface $model, GridWidgetColumnViewModelBuilderInterface $viewModelBuilder, GridWidgetColumnCellViewModelBuilderInterface $cellViewModelBuilder )
    {
        $this->setName($name);
        $this->setLabel($label);
        $this->setModel($model);
        $this->setViewModelBuilder($viewModelBuilder);
        $this->setCellViewModelBuilder($cellViewModelBuilder);
    }

    /**
     * 
     * @return GridWidgetColumnViewModelBuilderInterface
     */
    public function getViewModelBuilder()
    {
        return $this->viewModelBuilder;
    }

    public function setViewModelBuilder( GridWidgetColumnViewModelBuilderInterface $viewModelBuilder)
    {
        $this->viewModelBuilder = $viewModelBuilder;
    }
    
    /**
     * 
     * @return GridWidgetColumnCellViewModelBuilderInterface
     */
    public function getCellViewModelBuilder()
    {
        return $this->cellViewModelBuilder;
    }

    public function setCellViewModelBuilder( GridWidgetColumnCellViewModelBuilderInterface $cellViewModelBuilder)
    {
        $this->cellViewModelBuilder = $cellViewModelBuilder;
    }    
    
    protected function setName($value)
    {
        $this->name = $value;
    }

    public function getName()
    {
        return $this->name;
    }

    protected function setLabel($value)
    {
        $this->label = $value;
    }

    public function getLabel()
    {
        return $this->label;
    }    
    
    /**
     * 
     * @return GridWidgetColumnModelInterface
     */
    public function getModel()
    {
        return $this->model;
    }

    protected function setModel( GridWidgetColumnModelInterface $model)
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
    
    /**
     * 
     * @return \Bluegrass\Blues\Component\View\ViewModel
     */
    public function buildCellViewModel( $data )
    {
        return $this->getCellViewModelBuilder()->build($this, $data);
    }        
}

