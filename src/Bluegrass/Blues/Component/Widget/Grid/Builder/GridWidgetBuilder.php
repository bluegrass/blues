<?php

namespace Bluegrass\Blues\Component\Widget\Grid\Builder;

use Bluegrass\Blues\Component\DataSource\DataSourceInterface;

use Bluegrass\Blues\Component\Widget\Builder\AbstractWidgetBuilder;

use Bluegrass\Blues\Component\Widget\Grid\GridWidget;
use Bluegrass\Blues\Component\Widget\Grid\Model\GridWidgetModelInterface;
use Bluegrass\Blues\Component\Widget\Grid\Model\GridWidgetModel;
use Bluegrass\Blues\Component\Widget\Grid\View\GridViewModelBuilderInterface;

use Bluegrass\Blues\Component\Widget\Grid\Column\Builder\Factory\GridWidgetColumnBuilderFactoryInterface;

/**
 * Clase encargada de crear instancias de GridWidget
 *
 * @author ldelia
 */
class GridWidgetBuilder extends AbstractWidgetBuilder implements GridWidgetBuilderInterface
{
    private $columns;
    private $gridWidgetColumnBuilderFactory;
    
    public function __construct( GridViewModelBuilderInterface $viewModelBuilder, GridWidgetColumnBuilderFactoryInterface $gridWidgetColumnBuilderFactory )
    {
        $this->setViewModelBuilder($viewModelBuilder);
        $this->setColumns( new \ArrayObject() );
        $this->setGridWidgetColumnBuilderFactory($gridWidgetColumnBuilderFactory);
    }
 
    /**
     * 
     * @return \ArrayObject
     */
    protected function getColumns()
    {
        return $this->columns;
    }

    protected function setColumns($columns)
    {
        $this->columns = $columns;
    }    
    
    /**
     * 
     * @return GridWidgetColumnBuilderFactoryInterface
     */
    protected function getGridWidgetColumnBuilderFactory()
    {
        return $this->gridWidgetColumnBuilderFactory;
    }

    protected function setGridWidgetColumnBuilderFactory( GridWidgetColumnBuilderFactoryInterface $gridWidgetColumnBuilderFactory)
    {
        $this->gridWidgetColumnBuilderFactory = $gridWidgetColumnBuilderFactory;
    }    
    
    public function withModel( GridWidgetModelInterface $model )
    {
        $this->setModel($model);
        return $this;
    }
    
    public function withDataSource(DataSourceInterface $dataSource )
    {
        $this->setModel( new GridWidgetModel( $dataSource ) );
        return $this;        
    }
    
    public function addColumn( $id, \Closure $initializerCallback )
    {        
        $columnBuilder = $this->getGridWidgetColumnBuilderFactory()->getBuilder( $id );
        
        $initializerCallback( $columnBuilder );
        
        $column = $columnBuilder->build();
        
        $this->getColumns()->append($column);
        
        return $this;
    }
    
    public function build()
    {
        if( is_null( $this->getModel() ) ){
            throw new \Exception("El GridWidgetBuilder necesita que se le especifique un objecto que implemente GridWidgetModelInterface para poder construir un GridWidget");
        }
        
        $gridWidget = new GridWidget( $this->getModel(), $this->getViewModelBuilder() );
        
        foreach ( $this->getColumns() as $column ){
            $gridWidget->addColumn($column);
        } 
        
        return $gridWidget;
    }
}