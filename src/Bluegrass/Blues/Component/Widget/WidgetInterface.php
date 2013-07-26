<?php

namespace Bluegrass\Blues\Component\Widget;

/**
 * Interfaz abstracta que representa a toda componente visual (widget).
 * 
 * @author gcaseres
 */
interface WidgetInterface 
{
    /**
     * 
     * @return \Bluegrass\Blues\Component\View\ViewModel
     */
    public function buildViewModel();    
}
