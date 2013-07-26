<?php

namespace Bluegrass\Blues\Bridge\Widget\Kendo\AjaxGrid\View;

use Bluegrass\Blues\Component\Model\Web\Location\UrlGeneratorInterface;

use Bluegrass\Blues\Component\Widget\View\WidgetViewModel;

use Bluegrass\Blues\Component\Widget\AjaxGrid\AjaxGridWidgetInterface;
use Bluegrass\Blues\Component\Widget\Grid\View\GridViewModelBuilderInterface;

use Bluegrass\Blues\Component\Widget\WidgetInterface;

/**
 * Implementa la lógica necesaria para construir una Vista
 *
 * @author ldelia
 */
class KendoAjaxGridViewModelBuilder implements GridViewModelBuilderInterface
{        
    protected $urlGenerator;
    
    public function __construct(  UrlGeneratorInterface $urlGenerator)
    {
        $this->setUrlGenerator($urlGenerator);
    }
    
    protected function getUrlGenerator()
    {
        return $this->urlGenerator;
    }

    protected function setUrlGenerator($urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    public function build(WidgetInterface $widget) 
    {
        if (!($widget instanceof AjaxGridWidgetInterface))
            throw new \Exception("Este constructor de ViewModels solo admite Widgets que implementen la interfaz AjaxGridWidgetInterface");
                
        return $this->buildInternal($widget);
    }
    
    protected function buildInternal(AjaxGridWidgetInterface $widget)
    {
        $viewModel = new WidgetViewModel();
        $viewModel->setTemplate('@BluegrassBluesWidget/kendo/kendo.html.twig' );
        $viewModel->setBlockName( 'bluegrass_blues_ajaxgrid_widget' );
        
        $viewModel->set('dataAjaxRequestUrl', $widget->getDataAjaxRequestRoute()->generateUrlWith( $this->getUrlGenerator() , UrlGeneratorInterface::ABSOLUTE_PATH ) );
        $viewModel->set('pageSize', $widget->getPageSize());
        $viewModel->set('count', $widget->count());

        /**
         * Configuro las columnas del ViewModel
         */        
        $columns = array();                
        foreach ($widget->getColumns() as $column) 
        {
            $columns[] = $column->buildViewModel();
        }        
        $viewModel->set('columns', $columns);
        
        return $viewModel;
    }        
}
