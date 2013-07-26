<?php

namespace Bluegrass\Blues\Component\Widget\View;

use Bluegrass\Blues\Component\View\ViewModel;

/**
 * Representa una estructura con la información necesaria para ser
 * representada en una vista de un widget.
 *
 * @author ldelia
 */
class WidgetViewModel extends ViewModel
{
    public function getTemplate()
    {
        return $this->get( 'template' );                
    }
    
    public function setTemplate( $template )
    {
        $this->set( 'template', $template );        
    }
    
    public function getBlockName()
    {
        return $this->get( 'blockName' );                    
    }
        
    public function setBlockName( $blockname )
    {
        $this->set( 'blockName', $blockname );       
    }
}

