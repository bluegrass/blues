<?php

namespace Bluegrass\Blues\Bridge\Widget\Kendo\Grid\View;

use Bluegrass\Blues\Component\Widget\View\WidgetViewModel;

use Bluegrass\Blues\Component\Widget\Grid\GridWidgetInterface;
use Bluegrass\Blues\Component\Widget\Grid\View\GridViewModelBuilderInterface;

use Bluegrass\Blues\Component\Widget\WidgetInterface;

/**
 * Implementa la lógica necesaria para construir una Vista
 *
 * @author ldelia
 */
class KendoGridViewModelBuilder implements GridViewModelBuilderInterface
{        
    public function build(WidgetInterface $widget) 
    {
        if (!($widget instanceof GridWidgetInterface))
            throw new \Exception("Este constructor de ViewModels solo admite Widgets que implementen la interfaz GridWidgetInterface");
                
        return $this->buildInternal($widget);
    }
    
    protected function buildInternal(GridWidgetInterface $widget)
    {
        $viewModel = new WidgetViewModel();
        $viewModel->setTemplate('@BluegrassBluesWidget/kendo/kendo.html.twig' );
        $viewModel->setBlockName( 'bluegrass_blues_grid_widget' );
        
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
        
        /**
         * Configuro los items del ViewModel
         */
        $items = array();                
        foreach ($widget as $itemModel) 
        {
            $cells = array();
            foreach ($widget->getColumns() as $column) 
            {
                $cells[ $column->getName() ] = $column->buildCellViewModel( $itemModel );
            }                    
            $items[] = array( 'cells' => $cells );
        }        
        $viewModel->set('rows', $items);
               
        return $viewModel;
    }        
}
