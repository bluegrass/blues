<?php

namespace Bluegrass\Blues\Bridge\Widget\Kendo\Grid\View\Column\MoneyColumn;

use Bluegrass\Blues\Component\Widget\Grid\View\Column\GridWidgetColumnCellViewModelBuilderInterface;

use Bluegrass\Blues\Component\Widget\Grid\Column\GridWidgetColumnInterface;
use Bluegrass\Blues\Component\View\ViewModel;

/**
 * Implementa la lógica necesaria para construir una Vista
 *
 * @author ldelia
 */
class KendoGridMoneyColumnCellViewModelBuilder implements GridWidgetColumnCellViewModelBuilderInterface
{        
    /**
     * Construye un modelo para una vista de una celda a partir de un gridWidgetColumn.
     * 
     * @param GridWidgetColumnInterface $gridWidgetColumn
     * @return ViewModel 
     */
    function build(GridWidgetColumnInterface $column, $data)
    {
        $value = $data[ $column->getName() ];
        
        /**
         * @todo Analizar si es correcto este código aquí. Pensar que quizas, este tipo de validaciones son comunes a kendo, extjs, etc...
         */
        if(!is_numeric($value) ){
            throw new \Exception( "El tipo de columna 'Money' intentó procesar el valor no numérico: '$value'" );
        }
        
        $viewModel = new ViewModel();
        $viewModel->set('template', '@BluegrassBluesWidget/kendo/grid/column/money_column/cell.json.twig');
        $viewModel->set('name', $column->getName());
        $viewModel->set('value', $value );
        return $viewModel;
    }
}
