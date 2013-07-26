<?php

namespace Bluegrass\Blues\Component\Widget\AjaxGrid\View;

use Bluegrass\Blues\Component\View\ViewModel;

/**
 * @author ldelia
 */
class AjaxGridWidgetContentViewModel extends ViewModel
{
    public function getTemplate()
    {
        return $this->get( 'template' );                
    }
    
    public function setTemplate( $template )
    {
        $this->set( 'template', $template );        
    }

    public function getRows()
    {
        return $this->get( 'rows' );                
    }
    
    public function setRows( $rows )
    {
        $this->set( 'rows', $rows );                
    }
    
    public function getCount()
    {
        return $this->get( 'count' );                
    }
    
    public function setCount( $count )
    {
        $this->set( 'count', $count );                
    }    
}

