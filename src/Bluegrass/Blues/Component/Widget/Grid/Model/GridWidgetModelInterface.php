<?php

namespace Bluegrass\Blues\Component\Widget\Grid\Model;

use Bluegrass\Blues\Component\Widget\Model\WidgetModelInterface;

/**
 *
 * @author ldelia
 */
interface GridWidgetModelInterface extends WidgetModelInterface
{
    public function getData();
    
    public function getPageData();
    
    public function setPage($page);
    
    public function setPageSize($size);
    
    public function addOrderBy( $field, $dir );
}