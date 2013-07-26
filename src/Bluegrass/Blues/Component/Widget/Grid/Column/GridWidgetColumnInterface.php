<?php

namespace Bluegrass\Blues\Component\Widget\Grid\Column;

/**
 *
 * @author ldelia
 */
interface GridWidgetColumnInterface
{
    public function getName();
    
    public function getLabel();
    
    public function getModel();
    
    /**
     * 
     * @return \Bluegrass\Blues\Component\View\ViewModel
     */
    public function buildViewModel();
    
    /**
     * @todo buildCellViewModel debe recibir $data o $value
     */    
    /**
     * 
     * @return \Bluegrass\Blues\Component\View\ViewModel
     */    
    public function buildCellViewModel( $data );
}
