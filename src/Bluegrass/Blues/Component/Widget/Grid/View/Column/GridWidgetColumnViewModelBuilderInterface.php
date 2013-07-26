<?php

namespace Bluegrass\Blues\Component\Widget\Grid\View\Column;

use Bluegrass\Blues\Component\Widget\Grid\Column\GridWidgetColumnInterface;
use Bluegrass\Blues\Component\View\ViewModel;

/**
 *
 * @author ldelia
 */
interface GridWidgetColumnViewModelBuilderInterface
{
    
    /**
     * Construye un modelo para una vista a partir de un gridWidgetColumn.
     * 
     * @param GridWidgetColumnInterface $gridWidgetColumn
     * @return ViewModel 
     */
    function build(GridWidgetColumnInterface $gridWidgetColumn);
    
}
