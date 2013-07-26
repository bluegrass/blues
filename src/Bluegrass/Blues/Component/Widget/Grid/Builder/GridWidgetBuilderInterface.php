<?php

namespace Bluegrass\Blues\Component\Widget\Grid\Builder;

use Bluegrass\Blues\Component\DataSource\DataSourceInterface;
use Bluegrass\Blues\Component\Widget\Builder\WidgetBuilderInterface;
use Bluegrass\Blues\Component\Widget\Grid\Model\GridWidgetModelInterface;

/**
 *
 * @author ldelia
 */
interface GridWidgetBuilderInterface extends WidgetBuilderInterface
{
    
    /**
     * @return GridWidgetBuilderInterface
     */    
    public function addColumn( $id, \Closure $initializerCallback );
        
    /**
     * @return GridWidgetBuilderInterface
     * @param GridWidgetModelInterface $model
     */
    public function withModel( GridWidgetModelInterface $model );
    
    public function withDataSource(DataSourceInterface $dataSource );
}