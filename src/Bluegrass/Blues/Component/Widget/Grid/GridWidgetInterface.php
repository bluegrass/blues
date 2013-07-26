<?php

namespace Bluegrass\Blues\Component\Widget\Grid;

use Bluegrass\Blues\Component\Widget\WidgetInterface;
use Bluegrass\Blues\Component\Widget\Grid\Column\GridWidgetColumnInterface;

/**
 *
 * @author ldelia
 */
interface GridWidgetInterface extends WidgetInterface
{
    public function getPage();
    
    public function getPageSize();
    
    public function count();
    
    public function getIterator();    
    
    public function getPageIterator();    
    
    /**
     * @return Bluegrass\Blues\Component\Widget\Grid\Column\GridWidgetColumnInterface []
     */
    public function getColumns();
    
    public function addColumn( GridWidgetColumnInterface $column);
    
    /**
     * 
     * @param type $field
     * @param type $dir [ SORT_ASC, SORT_DESC ]
     */
    public function addOrderBy( $field, $dir );
}
