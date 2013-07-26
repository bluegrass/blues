<?php

namespace Bluegrass\Blues\Bridge\Widget\HTML\Grid\View;

use Bluegrass\Blues\Component\Widget\View\WidgetViewModel;
use Bluegrass\Blues\Component\View\ViewModel;

use Bluegrass\Blues\Component\Widget\Grid\GridWidget;
use Bluegrass\Blues\Component\Widget\Grid\Column\GridWidgetColumnInterface;
use Bluegrass\Blues\Component\Widget\Grid\View\GridViewModelBuilderInterface;

use Bluegrass\Blues\Component\Widget\WidgetInterface;

/**
 * Implementa la lógica necesaria para construir una Vista
 *
 * @author ldelia
 */
class HTMLGridViewModelBuilder implements GridViewModelBuilderInterface
{        
    public function build(WidgetInterface $widget) 
    {
        if (!($widget instanceof GridWidget))
            throw new \Exception("Este constructor de ViewModels solo admite instancias de Bluegrass\Blues\Component\Widget\Grid\GridWidget");
                
        return $this->buildInternal($widget);
    }
    
    protected function buildInternal(GridWidget $widget)
    {
        $viewModel = new WidgetViewModel();
        $viewModel->setTemplate('@BluegrassBluesWidget/html.html.twig' );
        $viewModel->setBlockName( 'bluegrass_blues_grid_widget' );
        
        $viewModel->set('count', $widget->count());

        /**
         * Configuro las columnas del ViewModel
         */        
        $columns = array();                
        foreach ($widget->getColumns() as $column) {
            $columns[] = $this->buildColumnViewModel($widget, $column);                        
        }        
        $viewModel->set('columns', $columns);
        
        /**
         * Configuro los items del ViewModel
         */
        $items = array();                
        foreach ($widget as $itemModel) {
            $items[] = $this->buildItemViewModel($widget, $itemModel);                        
        }        
        $viewModel->set('rows', $items);
               
        return $viewModel;
    }
    
    protected function buildColumnViewModel(GridWidget $widget, GridWidgetColumnInterface $column)
    {
        $view = new ViewModel();
                
        $view->set('name', $column->getName());
        $view->set('label', $column->getLabel());
        
        return $view;        
    }    
    
    protected function buildItemViewModel(GridWidget $widget, $itemModel)
    {
        $view = new ViewModel();
                
        $view->set('data', $itemModel);
        
        return $view;        
    }    
}
