<?php

namespace Bluegrass\Blues\Component\Tests\DataSource;

use Bluegrass\Blues\Component\DataSource\ArrayDataSource;

class ArrayDataSourceTest extends \PHPUnit_Framework_TestCase
{
    protected function getArrayData()
    {
        $data = array();
        for($i = 1; $i<=25; $i++){
            $data[]  = array( 'value' => 'value'.$i );
        }
        return $data;
    }
    
    public function testCreate()
    {
        new ArrayDataSource( $this->getArrayData() );
    }

    public function testGetData()
    {
        $arrayData = $this->getArrayData();
        
        $ads = new ArrayDataSource( $arrayData );
        $adsData = $ads->getData();

        $this->assertEquals(
                count( $arrayData ),        
                count( $adsData ),
                "Se esperaba que el datasource retorne la misma cantidad de valores que el array de entrada."
        );
        
        $adsData = $ads->getData(1, 10);
        
        $this->assertEquals(
                10,        
                count( $adsData ),
                "Se esperaba que el datasource retorne la página 1 con 10 valores."
        );
        
        $this->assertContains(
                array('value' => 'value1'),        
                $adsData,
                "Se esperaba que el valor se encuentre en la pagina de datos 1."
        );
        $this->assertContains(
                array('value' => 'value10'),        
                $adsData,
                "Se esperaba que el valor se encuentre en la pagina de datos 1."
        );
        
        $adsData = $ads->getData(2, 10);
        
        $this->assertEquals(
                10,        
                count( $adsData ),
                "Se esperaba que el datasource retorne la página 2 con 10 valores."
        );
        
        $this->assertContains(
                array('value' => 'value11'),        
                $adsData,
                "Se esperaba que el valor se encuentre en la pagina de datos 2."
        );
        $this->assertContains(
                array('value' => 'value20'),        
                $adsData,
                "Se esperaba que el valor se encuentre en la pagina de datos 2."
        );

        $adsData = $ads->getData(3, 10);
        
        $this->assertEquals(
                5,        
                count( $adsData ),
                "Se esperaba que el datasource retorne la página 3 con 5 valores."
        );
        
        $this->assertContains(
                array('value' => 'value21'),        
                $adsData,
                "Se esperaba que el valor se encuentre en la pagina de datos 3."
        );
        $this->assertContains(
                array('value' => 'value25'),        
                $adsData,
                "Se esperaba que el valor se encuentre en la pagina de datos 3."
        );
        
    }    
}