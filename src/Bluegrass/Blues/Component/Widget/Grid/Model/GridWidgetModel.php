<?php

namespace Bluegrass\Blues\Component\Widget\Grid\Model;

use Bluegrass\Blues\Component\DataSource\DataSourceInterface;
use Bluegrass\Blues\Component\Widget\Grid\Model\Column\GridWidgetColumnModelInterface;

/**
 * Modelo de Grilla
 * 
 */
class GridWidgetModel implements \Countable, GridWidgetModelInterface   
{
    private $dataSource;    
    private $columns;
    private $columnOrder = array();
    
    private $page;
    private $pageSize;

    public function __construct(DataSourceInterface $dataSource)
    {
        $this->setDataSource($dataSource);
        $this->setColumns(new \ArrayObject());
    }    
    
    public function getPage()
    {
        return $this->page;
    }

    public function setPage($page)
    {
        $this->page = $page;
    }    
    
    public function getPageSize()
    {
        return $this->pageSize;
    }

    public function setPageSize($size)
    {
        $this->pageSize = $size;
    }    
              
    protected function setDataSource(DataSourceInterface $value)
    {
        $this->dataSource = $value;
    }
    
    /**
     * 
     * @return DataSourceInterface
     */
    protected function getDataSource()
    {
        return $this->dataSource;
    }         

    protected function setColumnOrder(array $value = array())
    {
        $this->columnOrder = $value;
    }
    
    protected function getColumnOrder()
    {
        $columnOrder = $this->columnOrder;
        if (count($columnOrder) == 0)
            $columnOrder = array_keys($this->getColumns()->getArrayCopy());
        
        return $columnOrder;
    }
    
    public function setColumn(GridWidgetColumnModelInterface $column)
    {        
        $this->getColumns()->offsetSet($column->getName(), $column);
        return $this;
    }

    public function getColumn($name)
    {
        return $this->getColumns()->offsetGet($name);
    }

    public function hasColumn($name)
    {
        return $this->getColumns()->offsetExists($name);
    }
    
    protected function setColumns(\ArrayObject $value)
    {
        $this->columns = $value;
    }

    /**
     * 
     * @return \ArrayObject
     */
    public function getColumns()
    {
        return $this->columns;
    }
    
    public function addColumn( GridWidgetColumnModelInterface $column)
    {
        if( $this->hasColumn($column->getName()) ){
            throw new \Exception("La grilla ya cuenta con una columna con nombre " . $column->getName());
        }
        $this->getColumns()->append($column);
    }
    
    public function addOrderBy( $field, $dir )
    {
        $this->getDataSource()->addOrderBy($field, $dir);
    }

    /**
     * Devuelve la información de la grilla en forma de matriz según las 
     * columnas definidas.
     * 
     * @return \ArrayIterator Información a mostrar de la grilla.
     */
    public function getData()
    {
        $rows = $this->getDataSource()->getData();

        return new \ArrayIterator($rows);
    }

    /**
     * Devuelve la información de la página actual de la    grilla en forma de matriz según las 
     * columnas definidas.
     * 
     * @return \ArrayIterator Información a mostrar de la grilla.
     */    
    public function getPageData()
    {
        $rows = $this->getDataSource()->getData( $this->getPage(), $this->getPageSize() );

        return new \ArrayIterator($rows);
    }
    
    public function count()
    {
        return $this->getDataSource()->count();
    }
}