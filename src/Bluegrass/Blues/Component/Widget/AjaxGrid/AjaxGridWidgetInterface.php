<?php

namespace Bluegrass\Blues\Component\Widget\AjaxGrid;

use Bluegrass\Blues\Component\Widget\Grid\GridWidgetInterface;
use Bluegrass\Blues\Component\Model\Web\Location\WebLocation;

/**
 *
 * @author ldelia
 */
interface AjaxGridWidgetInterface extends GridWidgetInterface
{        
    /**
     * @return WebLocation
     */
    public function getDataAjaxRequestRoute();    
    
    /**
     * 
     * @return \Bluegrass\Blues\Component\View\ViewModel
     */
    public function buildContentViewModel();    
}
