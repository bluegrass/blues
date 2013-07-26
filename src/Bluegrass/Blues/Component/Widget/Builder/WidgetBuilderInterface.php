<?php

namespace Bluegrass\Blues\Component\Widget\Builder;

use Bluegrass\Blues\Component\Widget\WidgetInterface;

/**
 * Interfaz que deben implementar las clases encargadas de construir un modelo
 * para una vista a partir de un widget.
 * 
 * @author gcaseres
 */
interface WidgetBuilderInterface 
{
    /**
     * Construye un widget
     * 
     * @return WidgetInterface
     */
    function build();
}

