<?php

namespace Bluegrass\Blues\Bridge\Widget\Kendo\AjaxGrid\View;

use Bluegrass\Blues\Component\Widget\WidgetInterface;

use Bluegrass\Blues\Component\Widget\AjaxGrid\AjaxGridWidgetInterface;
use Bluegrass\Blues\Component\Widget\AjaxGrid\View\AjaxGridContentViewModelBuilderInterface;
use Bluegrass\Blues\Component\Widget\AjaxGrid\View\AjaxGridWidgetContentViewModel;

/**
 * Implementa la lógica necesaria para construir una Vista de datos remotos
 *
 * @author ldelia
 */
class KendoAjaxGridContentViewModelBuilder implements AjaxGridContentViewModelBuilderInterface
{        
    public function build(WidgetInterface $widget) 
    {
        if (!($widget instanceof AjaxGridWidgetInterface))
            throw new \Exception("Este constructor de ViewModels solo admite Widgets que implementen la interfaz AjaxGridWidgetInterface");
                
        return $this->buildInternal($widget);
    }
    
    protected function buildInternal(AjaxGridWidgetInterface $widget)
    {
        $viewModel = new AjaxGridWidgetContentViewModel();
        $viewModel->setTemplate('@BluegrassBluesWidget/kendo/kendo.html.twig' );      
        
        $viewModel->setCount( $widget->count() );

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
        $rows = array();                
        foreach ($widget->getPageIterator() as $itemModel) 
        {
            $cells = array();
            foreach ($widget->getColumns() as $column) 
            {
                $cells[ $column->getName() ] = $column->buildCellViewModel( $itemModel );
            }                    
            $rows[] = array( 'cells' => $cells );
        }        
        $viewModel->setRows($rows);

        return $viewModel;        
    }        
}
