<?php

namespace Bluegrass\Blues\Component\Widget\Grid;

use Bluegrass\Blues\Component\Widget\AbstractWidget;
use Bluegrass\Blues\Component\Widget\Grid\Model\GridWidgetModelInterface;
use Bluegrass\Blues\Component\Widget\Grid\Column\GridWidgetColumnInterface;
use Bluegrass\Blues\Component\Widget\Grid\View\GridViewModelBuilderInterface;

/**
 * Componente visual para la representación de un Grid.
 *
 * @author ldelia
 */
class GridWidget extends AbstractWidget implements GridWidgetInterface, \IteratorAggregate, \Countable
{
    private $columns;
    
    private $page;
    private $pageSize;
    
    public function __construct( GridWidgetModelInterface $model,  GridViewModelBuilderInterface $viewModelBuilder )
    {
        parent::__construct($model, $viewModelBuilder);
        
        $this->setColumns(new \ArrayObject());

        $this->setPageSize(10); // Tanto grillas que paginan con ajax, como grillas que paginan con javascript necesitan saber el tamaño de pagina
        $this->setPage(1); // Tanto grillas que paginan con ajax, como grillas que paginan con javascript por defecto arrancan en la primer pagina
    }    
    
    public function getPageSize()
    {
        return $this->pageSize;
    }

    public function setPageSize($pageSize)
    {
        $this->pageSize = $pageSize;
                
        $model = $this->getModel(); 
        /* @var $model GridWidgetModelInterface */
        $model->setPageSize($pageSize);                
    }    
    
    public function getPage()
    {
        return $this->page;
    }

    public function setPage($page)
    {
        $this->page = $page;
        $model = $this->getModel(); 
        /* @var $model GridWidgetModelInterface */
        $model->setPage($page);        
    }    

    public function getColumns()
    {
        return $this->columns->getIterator();
    }
    
    protected function setColumns( $columns )
    {
        $this->columns = $columns;
    }
    
    public function addColumn(GridWidgetColumnInterface $column)
    {
        $this->columns[] = $column;                
        
        $this->getModel()->addColumn( $column->getModel() );
    }
    
    public function addOrderBy( $field, $dir )
    {
        $this->getModel()->addOrderBy( $field, $dir );
    }
    
    public function getIterator() 
    {
        return $this->getModel()->getData();
    }

    public function getPageIterator() 
    {
        return $this->getModel()->getPageData();
    }
    
    public function count()
    {
        return $this->getModel()->count();
    }            
}
