<?php

namespace Bluegrass\Blues\Bridge\Widget\Kendo\Grid\View\Column\DateColumn;

use Bluegrass\Blues\Component\Widget\Grid\View\Column\GridWidgetColumnViewModelBuilderInterface;

use Bluegrass\Blues\Component\Widget\Grid\Column\GridWidgetColumnInterface;
use Bluegrass\Blues\Component\View\ViewModel;

/**
 * Implementa la lógica necesaria para construir una Vista de una columna Date
 *
 * @author ldelia
 */
class KendoGridDateColumnViewModelBuilder implements GridWidgetColumnViewModelBuilderInterface
{        
    /**
     * Construye un modelo para una vista a partir de un gridWidgetColumn.
     * 
     * @param GridWidgetColumnInterface $gridWidgetColumn
     * @return ViewModel 
     */
    function build(GridWidgetColumnInterface $column)
    {
        $viewModel = new ViewModel();
        $viewModel->set('template', '@BluegrassBluesWidget/kendo/grid/column/date_column/column.json.twig');
        $viewModel->set('name', $column->getName());
        $viewModel->set('label', $column->getLabel());
        return $viewModel;
    }
}
