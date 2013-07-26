<?php

namespace Bluegrass\Blues\Component\Widget\View\Builder;

use Bluegrass\Blues\Component\View\ViewModel;
use Bluegrass\Blues\Component\Widget\WidgetInterface;

/**
 * Interfaz que deben implementar las clases encargadas de construir un modelo
 * para una vista a partir de un widget.
 * 
 * @author gcaseres
 */
interface WidgetViewModelBuilderInterface 
{
    /**
     * Construye un modelo para una vista a partir de un widget.
     * 
     * @param WidgetInterface $widget
     * @return ViewModel 
     */
    function build(WidgetInterface $widget);
}

