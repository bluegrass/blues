<?php

namespace Bluegrass\Blues\Component\Widget\AjaxGrid;

use Bluegrass\Blues\Component\Model\Web\Location\WebLocation;

use Bluegrass\Blues\Component\Widget\Grid\View\GridViewModelBuilderInterface;
use Bluegrass\Blues\Component\Widget\Grid\Column\GridWidgetColumnInterface;
use Bluegrass\Blues\Component\Widget\Grid\GridWidgetInterface;
use Bluegrass\Blues\Component\Widget\AjaxGrid\View\AjaxGridContentViewModelBuilderInterface;

/**
 * Componente visual para la representación de un Grid que visualiza sus páginas mediante Ajax.
 *
 * @author ldelia
 */
class AjaxGridWidget implements AjaxGridWidgetInterface, \IteratorAggregate, \Countable
{
    protected $decoratedGridWidget;
    protected $viewModelBuilder;
    protected $contentViewModelBuilder;
    protected $dataAjaxRequestRoute;
        
    public function __construct( GridWidgetInterface $decoratedGridWidget , GridViewModelBuilderInterface $viewModelBuilder , AjaxGridContentViewModelBuilderInterface $contentViewModelBuilder, WebLocation $dataAjaxRequestRoute )
    {
        $this->setDecoratedGridWidget($decoratedGridWidget);
        $this->setViewModelBuilder($viewModelBuilder);
        $this->setContentViewModelBuilder($contentViewModelBuilder);
        $this->setDataAjaxRequestRoute($dataAjaxRequestRoute);
    }    
    
    /**
     * 
     * @return GridViewModelBuilderInterface
     */
    protected function getViewModelBuilder()
    {
        return $this->viewModelBuilder;
    }

    protected function setViewModelBuilder( GridViewModelBuilderInterface $viewModelBuilder)
    {
        $this->viewModelBuilder = $viewModelBuilder;
    }    

    /**
     * 
     * @return AjaxGridContentViewModelBuilderInterface 
     */
    protected function getContentViewModelBuilder()
    {
        return $this->contentViewModelBuilder;
    }

    protected function setContentViewModelBuilder( AjaxGridContentViewModelBuilderInterface  $contentViewModelBuilder)
    {
        $this->contentViewModelBuilder = $contentViewModelBuilder;
    }    

    /**
     * 
     * @return WebLocation
     */
    public function getDataAjaxRequestRoute()
    {
        return $this->dataAjaxRequestRoute;
    }

    public function setDataAjaxRequestRoute(WebLocation $dataAjaxRequestRoute)
    {
        $this->dataAjaxRequestRoute = $dataAjaxRequestRoute;
    }    

    /**
     * 
     * @return GridWidgetInterface
     */
    protected function getDecoratedGridWidget()
    {
        return $this->decoratedGridWidget;
    }

    protected function setDecoratedGridWidget( GridWidgetInterface $decoratedGridWidget)
    {
        $this->decoratedGridWidget = $decoratedGridWidget;
    }    

    public function setPageSize( $pageSize )
    {
        $this->getDecoratedGridWidget()->setPageSize( $pageSize );
    }
    
    public function getPageSize()
    {
        return $this->getDecoratedGridWidget()->getPageSize();
    }
    
    public function getPage()
    {
        return $this->getDecoratedGridWidget()->getPage();
    }

    public function setPage( $page )
    {
        $this->getDecoratedGridWidget()->setPage( $page );
    }
    
    public function count()
    {
        return $this->getDecoratedGridWidget()->count();
    }    

    public function getIterator()
    {
        return $this->getDecoratedGridWidget()->getIterator();
    }    

    public function getPageIterator()
    {
        return $this->getDecoratedGridWidget()->getPageIterator();
    }    
    
    /**
     * @return Bluegrass\Blues\Component\Widget\Grid\Column\GridWidgetColumnInterface []
     */
    public function getColumns()
    {
        return $this->getDecoratedGridWidget()->getColumns();
    }
    
    public function addColumn( GridWidgetColumnInterface $column)
    {
        $this->getDecoratedGridWidget()->addColumn($column);
    }
    
    public function addOrderBy( $field, $dir )
    {
        $this->getDecoratedGridWidget()->addOrderBy( $field, $dir );
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
    public function buildContentViewModel()
    {      
        return $this->getContentViewModelBuilder()->build($this);
    }            
}