<?php

namespace Bluegrass\Blues\Component\Tests\Widget\Grid;

use Bluegrass\Blues\Component\DataSource\ArrayDataSource;

use Bluegrass\Blues\Component\Widget\Grid\Model\GridWidgetModel;
use Bluegrass\Blues\Component\Widget\Grid\Model\Column\GridWidgetColumnModel;

use Bluegrass\Blues\Component\Widget\Grid\Column\GridWidgetColumn;
use Bluegrass\Blues\Component\Widget\Grid\GridWidget;

class GridWidgetTest extends \PHPUnit_Framework_TestCase
{    
    protected function getArrayData()
    {
        $data = array();
        for($i = 1; $i<=25; $i++){
            $data[]  = array( 'valueA' => 'valueA'.$i, 'valueB' => 'valueB'.$i );
        }
        return $data;
    }
    
    protected function getGridViewModelBuilder()
    {
        return $this->getMock('Bluegrass\Blues\Bridge\Widget\Kendo\Grid\View\KendoGridViewModelBuilder', array('build'));        
    }

    protected function getGridWidgetColumnViewModelBuilder()
    {
        return $this->getMock( 'Bluegrass\Blues\Bridge\Widget\Kendo\Grid\View\Column\StringColumn\KendoGridStringColumnViewModelBuilder' );
    }
    
    protected function getGridWidgetColumnCellViewModelBuilder()
    {
        return $this->getMock( 'Bluegrass\Blues\Bridge\Widget\Kendo\Grid\View\Column\StringColumn\KendoGridStringColumnCellViewModelBuilder' );
    }
    
    public function testCreation()
    {
        $arrayData = $this->getArrayData();
        
        $gridModel =new GridWidgetModel( new ArrayDataSource( $arrayData ) );
        
        $gridWidget = new GridWidget( $gridModel, $this->getGridViewModelBuilder() );
        $gridWidget->addColumn( new GridWidgetColumn( "valueA", "Valor A", new GridWidgetColumnModel( "valueA" ), $this->getGridWidgetColumnViewModelBuilder(), $this->getGridWidgetColumnCellViewModelBuilder() ) );
        $gridWidget->addColumn( new GridWidgetColumn( "valueB", "Valor B", new GridWidgetColumnModel( "valueB" ), $this->getGridWidgetColumnViewModelBuilder(), $this->getGridWidgetColumnCellViewModelBuilder() ) );
    }    
}