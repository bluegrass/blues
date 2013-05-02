<?php

namespace Bluegrass\Blues\Component\Widgets\Views;

use Bluegrass\Blues\Component\Views\ViewModel;
use Bluegrass\Blues\Component\Widgets\WidgetInterface;

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

