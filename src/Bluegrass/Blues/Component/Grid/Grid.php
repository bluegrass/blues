<?php

namespace Bluegrass\Blues\Component\Grid;

use Bluegrass\Blues\Component\DataSource\IDataSource;

/**
 * Grilla genérica para mostrar información de manera tabular
 * 
 * @author gcaseres
 */
class Grid
{
    private $dataSource;    
    private $columns;
    private $columnOrder = array();

    public function __construct(IDataSource $dataSource)
    {
        $this->setDataSource($dataSource);
        $this->setColumns(new \ArrayObject());
    }    
              
    protected function setDataSource(IDataSource $value)
    {
        $this->dataSource = $value;
    }
    
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
    
    public function setColumn(Column $column)
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

    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * Devuelve la información de la grilla en forma de matriz según las 
     * columnas definidas.
     * 
     * Este método invoca al DataSource asociado a la grilla.
     * 
     * @return array Información a mostrar de la grilla.
     */
    public function getData()
    {
        $rows = $this->getDataSource()->getData();

        foreach ($rows as $key => $row) {
            foreach ($this->getColumns() as $column) {
                $id = $column->getName();
                $rows[$key][$id] = $column->processValue($row);
            }
        }
        return $rows;
    }
}