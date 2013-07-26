<?php

namespace Bluegrass\Blues\Component\Widget\Grid\Column\Builder\Factory;

use Bluegrass\Blues\Component\Widget\Grid\View\Column\GridWidgetColumnViewModelBuilderInterface;

/**
 *
 * @author ldelia
 */
interface GridWidgetColumnBuilderFactoryInterface
{
    /**
     * 
     * @param string $id
     * @return GridWidgetColumnViewModelBuilderInterface
     */    
    public function getBuilder( $id );
}
