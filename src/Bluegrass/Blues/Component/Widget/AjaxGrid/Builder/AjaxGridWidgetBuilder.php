<?php

namespace Bluegrass\Blues\Component\Widget\AjaxGrid\Builder;

use Bluegrass\Blues\Component\DataSource\DataSourceInterface;

use Bluegrass\Blues\Component\Model\Web\Location\WebLocation;

use Bluegrass\Blues\Component\Widget\Grid\Builder\GridWidgetBuilderInterface;
use Bluegrass\Blues\Component\Widget\Grid\View\GridViewModelBuilderInterface;
use Bluegrass\Blues\Component\Widget\Grid\Model\GridWidgetModelInterface;
use Bluegrass\Blues\Component\Widget\WidgetInterface;

use Bluegrass\Blues\Component\Widget\AjaxGrid\AjaxGridWidget;
use Bluegrass\Blues\Component\Widget\AjaxGrid\View\AjaxGridContentViewModelBuilderInterface;
/**
 * Clase encargada de crear instancias de AjaxGridWidget
 *
 * @author ldelia
 */
class AjaxGridWidgetBuilder implements AjaxGridWidgetBuilderInterface
{
    protected $decoratedGridWidgetBuilder;
    protected $viewModelBuilder;
    protected $contentViewModelBuilder;
    
    protected $dataAjaxRequestRoute;
    
    public function __construct( GridWidgetBuilderInterface $decoratedGridWidgetBuilder, GridViewModelBuilderInterface $viewModelBuilder, AjaxGridContentViewModelBuilderInterface $contentViewModelBuilder )
    {
        $this->setDecoratedGridWidgetBuilder($decoratedGridWidgetBuilder);
        $this->setViewModelBuilder($viewModelBuilder);
        $this->setContentViewModelBuilder($contentViewModelBuilder);
    }
    
    /**
     * 
     * @return GridWidgetBuilderInterface 
     */
    protected function getDecoratedGridWidgetBuilder()
    {
        return $this->decoratedGridWidgetBuilder;
    }

    protected function setDecoratedGridWidgetBuilder( GridWidgetBuilderInterface  $decoratedGridWidgetBuilder)
    {
        $this->decoratedGridWidgetBuilder = $decoratedGridWidgetBuilder;
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

    protected function setContentViewModelBuilder(AjaxGridContentViewModelBuilderInterface $contentViewModelBuilder)
    {
        $this->contentViewModelBuilder = $contentViewModelBuilder;
    }    
    
    public function addColumn( $id, \Closure $initializerCallback )
    {
        $this->getDecoratedGridWidgetBuilder()->addColumn($id, $initializerCallback);
        return $this;        
    }
    
    public function withModel( GridWidgetModelInterface $model )
    {
        $this->getDecoratedGridWidgetBuilder()->withModel($model);
        return $this;
    }

     public function withDataSource(DataSourceInterface $dataSource )
    {
        $this->getDecoratedGridWidgetBuilder()->withDataSource($dataSource );
        return $this;
    }

    protected function getDataAjaxRequestRoute()
    {
        return $this->dataAjaxRequestRoute;
    }

    public function withDataAjaxRequestRoute( WebLocation $route )
    {
        $this->dataAjaxRequestRoute = $route;
        return $this;
    }
    
    /**
     * Construye un AjaxGridWidget
     * 
     * @return WidgetInterface
     */
    function build()
    {
        if( is_null( $this->getDataAjaxRequestRoute() ) ){
            throw new \Exception("El AjaxGridWidgetBuilder necesita que se le especifique un dataAjaxRequestRoute para poder construir un AjaxGridWidget");
        }
        
        $gridWidget = $this->getDecoratedGridWidgetBuilder()->build();
        
        $ajaxGridWidget = new AjaxGridWidget( $gridWidget, $this->getViewModelBuilder(), $this->getContentViewModelBuilder(), $this->getDataAjaxRequestRoute() );
        
        return $ajaxGridWidget;
    }
}