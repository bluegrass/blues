<?php

namespace Bluegrass\Blues\Component\Widget\Grid\View\Column;

use Bluegrass\Blues\Component\Widget\Grid\Column\GridWidgetColumnInterface;
use Bluegrass\Blues\Component\View\ViewModel;

/**
 *
 * @author ldelia
 */
interface GridWidgetColumnCellViewModelBuilderInterface
{
    
    /**
     * @todo build debe recibir $data o $value
     */        
    /**
     * Construye un modelo para una vista de una celda a partir de un gridWidgetColumn.
     * 
     * @param GridWidgetColumnInterface $gridWidgetColumn
     * @return ViewModel 
     */
    function build(GridWidgetColumnInterface $gridWidgetColumn, $data);
    
}
