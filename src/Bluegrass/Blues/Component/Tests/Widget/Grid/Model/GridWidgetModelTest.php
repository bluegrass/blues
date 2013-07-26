<?php

namespace Bluegrass\Blues\Component\Tests\Widget\Grid\Model;

use Bluegrass\Blues\Component\DataSource\ArrayDataSource;
use Bluegrass\Blues\Component\Widget\Grid\Model\GridWidgetModel;
use Bluegrass\Blues\Component\Widget\Grid\Model\Column\GridWidgetColumnModel;

class GridWidgetModelTest extends \PHPUnit_Framework_TestCase
{
    protected function getArrayData()
    {
        $data = array();
        for($i = 1; $i<=25; $i++){
            $data[]  = array( 'valueA' => 'valueA'.$i, 'valueB' => 'valueB'.$i );
        }
        return $data;
    }
    
    public function testGetDataWithoutColumns()
    {
        $arrayData = $this->getArrayData();
        
        $grid =new GridWidgetModel( new ArrayDataSource( $arrayData ) );        
        $data = $grid->getData();
        
        $this->assertEquals(
                25,
                count( $data ),
                'Se esperaba que la grilla tenga todos los valores del array.'
        );        
        
        $this->assertEquals(
                $arrayData[ 0 ],
                $data[ 0 ],
                'Se esperaba que la grilla tenga en cualquiera de sus posiciones, el mismo valor que en el array.'
        );        
        
    }
    
    public function testGetDataWithColumns()
    {
        $arrayData = $this->getArrayData();
        
        $grid =new GridWidgetModel( new ArrayDataSource( $arrayData ) );        
        $grid->addColumn( new GridWidgetColumnModel( "valueA" ) );
        $grid->addColumn( new GridWidgetColumnModel( "valueB" ) );
        $data = $grid->getData();
        
        $this->assertEquals(
                25,
                count( $data ),
                'Se esperaba que la grilla tenga todos los valores del array'
        );        
        
        $this->assertEquals(
                $arrayData[ 0 ],
                $data[ 0 ],
                'Se esperaba que la grilla tenga en cualquiera de sus posiciones, el mismo valor que en el array.'
        );
        
    }    
}