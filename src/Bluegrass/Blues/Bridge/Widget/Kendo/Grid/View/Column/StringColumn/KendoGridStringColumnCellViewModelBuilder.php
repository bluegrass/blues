<?php

namespace Bluegrass\Blues\Bridge\Widget\Kendo\Grid\View\Column\StringColumn;

use Bluegrass\Blues\Component\Widget\Grid\View\Column\GridWidgetColumnCellViewModelBuilderInterface;

use Bluegrass\Blues\Component\Widget\Grid\Column\GridWidgetColumnInterface;
use Bluegrass\Blues\Component\View\ViewModel;

/**
 * Implementa la lógica necesaria para construir una Vista
 *
 * @author ldelia
 */
class KendoGridStringColumnCellViewModelBuilder implements GridWidgetColumnCellViewModelBuilderInterface
{        
    /**
     * Construye un modelo para una vista de una celda a partir de un gridWidgetColumn.
     * 
     * @param GridWidgetColumnInterface $gridWidgetColumn
     * @return ViewModel 
     */
    function build(GridWidgetColumnInterface $column, $data)
    {
        $viewModel = new ViewModel();
        $viewModel->set('template', '@BluegrassBluesWidget/kendo/grid/column/string_column/cell.json.twig');
        $viewModel->set('name', $column->getName());
        $viewModel->set('value', $data[ $column->getName() ] );
        return $viewModel;
    }
}
