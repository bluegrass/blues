<?php

namespace Bluegrass\Blues\Component\Grid;

use Bluegrass\Blues\Component\DataSource\IDataSource;
use Bluegrass\Blues\Component\Grid\Exception\InvalidPageNumberException;

/**
 * Grilla genérica para mostrar información de manera tabular con funciones de paginación
 * 
 * @author gcaseres
 */
class PagingGrid extends Grid
{
    private $currentPage;
    private $rowsPerPage;        
    
    public function __construct(IDataSource $dataSource)
    {
        parent::__construct($dataSource);
        
        $this->setRowsPerPage(10);
        $this->setCurrentPage(1);        
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
        $rows = $this->getDataSource()->getData($this->getCurrentPage(), $this->getRowsPerPage());

        foreach ($rows as $key => $row) {
            foreach ($this->getColumns() as $column) {
                $id = $column->getName();

                $rows[$key][$id] = $column->processValue($row);
            }
        }

        return $rows;
    }
    
    public function setCurrentPage($value)
    {
        if( $value > $this->getPageCount() ){
            throw new InvalidPageNumberException('Se intentó acceder a la página ' . $value . ', pero la grilla paginada tiene como máximo ' . $this->getPageCount());
        }else{
            $this->currentPage = $value;    
        }        
    }

    public function getCurrentPage()
    {
        return $this->currentPage;
    }

    public function getPageCount()
    {
        return ceil($this->getDataSource()->getCount() / $this->getRowsPerPage());
    }

    public function setRowsPerPage($value)
    {
        $this->rowsPerPage = $value;
    }

    public function getRowsPerPage()
    {
        return $this->rowsPerPage;
    }        
}
