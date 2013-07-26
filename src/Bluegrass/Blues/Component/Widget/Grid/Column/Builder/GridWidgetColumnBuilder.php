<?php

namespace Bluegrass\Blues\Component\Widget\Grid\Column\Builder;

use Bluegrass\Blues\Component\Widget\Grid\Column\GridWidgetColumn;
use Bluegrass\Blues\Component\Widget\Grid\Model\Column\GridWidgetColumnModel;
use Bluegrass\Blues\Component\Widget\Grid\View\Column\GridWidgetColumnViewModelBuilderInterface;
use Bluegrass\Blues\Component\Widget\Grid\View\Column\GridWidgetColumnCellViewModelBuilderInterface;

/**
 * @todo analizar si es correcto que las clases concretas esten vacias...
 */

/**
 * Clase encargada de crear instancias de Column
 *
 * @author ldelia
 */
abstract class GridWidgetColumnBuilder implements GridWidgetColumnBuilderInterface
{
    private $label;
    private $name;
    
    private $viewModelBuilder;
    private $cellViewModelBuilder;

    protected $defaultViewModelBuilder;
    protected $defaultCellViewModelBuilder;
    
    
    public function __construct( GridWidgetColumnViewModelBuilderInterface $defaultViewModelBuilder, GridWidgetColumnCellViewModelBuilderInterface $defaultCellViewModelBuilder )
    {
        $this->setViewModelBuilder( null );
        $this->setCellViewModelBuilder( null );
        
        $this->setDefaultViewModelBuilder($defaultViewModelBuilder);
        $this->setDefaultCellViewModelBuilder($defaultCellViewModelBuilder);        
    }
    
    public function getLabel()
    {
        return $this->label;
    }

    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }    

    /**
     * 
     * @return GridWidgetColumnCellViewModelBuilderInterface 
     */
    public function getDefaultCellViewModelBuilder()
    {
        return $this->defaultCellViewModelBuilder;
    }

    protected function setDefaultCellViewModelBuilder( GridWidgetColumnCellViewModelBuilderInterface  $defaultCellViewModelBuilder )
    {
        $this->defaultCellViewModelBuilder = $defaultCellViewModelBuilder;
    }    
    
    protected function setDefaultViewModelBuilder( GridWidgetColumnViewModelBuilderInterface $defaultViewModelBuilder )
    {
        $this->defaultViewModelBuilder = $defaultViewModelBuilder;
    }    
    
    /**
     * 
     * @return GridWidgetColumnViewModelBuilderInterface
     */
    public function getDefaultViewModelBuilder()
    {
        return $this->defaultViewModelBuilder;
    }
    
    /**
     * 
     * @return GridWidgetColumnCellViewModelBuilderInterface
     */
    public function getCellViewModelBuilder()
    {
        if( is_null($this->cellViewModelBuilder)  ){
            return $this->getDefaultCellViewModelBuilder();
        }else{
            return $this->cellViewModelBuilder;            
        }
    }

    public function setCellViewModelBuilder( GridWidgetColumnCellViewModelBuilderInterface $cellViewModelBuilder = null)
    {
        $this->cellViewModelBuilder = $cellViewModelBuilder;
    }    
    
    /**
     * 
     * @return GridWidgetColumnViewModelBuilderInterface
     */
    public function getViewModelBuilder()
    {
        if( is_null($this->viewModelBuilder)  ){
            return $this->getDefaultViewModelBuilder();
        }else{
            return $this->viewModelBuilder;            
        }
    }

    public function setViewModelBuilder( GridWidgetColumnViewModelBuilderInterface $viewModelBuilder = null )
    {
        $this->viewModelBuilder = $viewModelBuilder;
        return $this;
    }
    
    public function build()
    {
        $model = new GridWidgetColumnModel( $this->getName() );
        $column = new GridWidgetColumn( $this->getName(), $this->getLabel(), $model, $this->getViewModelBuilder() , $this->getCellViewModelBuilder() );
        return $column;
    }
}

