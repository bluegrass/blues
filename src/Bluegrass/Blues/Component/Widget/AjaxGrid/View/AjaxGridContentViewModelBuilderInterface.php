<?php

namespace Bluegrass\Blues\Component\Widget\AjaxGrid\View;

use Bluegrass\Blues\Component\View\ViewModel;
use Bluegrass\Blues\Component\Widget\WidgetInterface;


/**
 *
 * @author ldelia
 */
interface AjaxGridContentViewModelBuilderInterface
{
    /**
     * Construye un modelo para una vista a partir de un widget.
     * 
     * @param WidgetInterface $widget
     * @return ViewModel 
     */
    function build(WidgetInterface $widget);    
}
