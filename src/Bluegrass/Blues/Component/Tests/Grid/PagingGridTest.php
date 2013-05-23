<?php

namespace Bluegrass\Blues\Component\Tests\Grid;

use Bluegrass\Blues\Component\DataSource\ArrayDataSource;
use Bluegrass\Blues\Component\Grid\PagingGrid;
use Bluegrass\Blues\Component\Grid\Column;

class PagingGridTest extends \PHPUnit_Framework_TestCase
{
    protected function getArrayData()
    {
        $data = array();
        for($i = 1; $i<=25; $i++){
            $data[]  = array( 'valueA' => 'valueA'.$i, 'valueB' => 'valueB'.$i );
        }
        return $data;
    }
    
    public function testPages()
    {
        $arrayData = $this->getArrayData();
        
        $grid =new PagingGrid( new ArrayDataSource( $arrayData ) );        

        $this->assertEquals(
                3,
                $grid->getPageCount(),
                'Se esperaba que la grilla tenga solo 3 páginas'
        );        
        
        $data = $grid->getData();
        
        $this->assertEquals(
                10,
                count( $data ),
                'Se esperaba que la primer página tenga '.$grid->getRowsPerPage().' valores.'
        );        
        
        $grid->setCurrentPage(2);
        
        $data = $grid->getData();
        
        $this->assertEquals(
                10,
                count( $data ),
                'Se esperaba que la segunda página tenga '.$grid->getRowsPerPage().' valores.'
        );                
        
        $grid->setCurrentPage(3);
        
        $data = $grid->getData();
        
        $this->assertEquals(
                5,
                count( $data ),
                'Se esperaba que la tercer página tenga '.$grid->getRowsPerPage().' valores.'
        );                
        
        $this->setExpectedException(
          'Bluegrass\Blues\Component\Grid\Exception\InvalidPageNumberException'
        );
        $grid->setCurrentPage(4);        
    }
}