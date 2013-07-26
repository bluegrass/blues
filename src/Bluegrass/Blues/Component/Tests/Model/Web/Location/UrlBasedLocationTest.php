<?php

namespace Bluegrass\Blues\Component\Tests\Model\Web\Location;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Bluegrass\Blues\Component\Model\Web\Location\UrlBasedLocation;

class UrlBasedLocationTest extends WebTestCase
{
    public function testParameters()
    {
        $location = new UrlBasedLocation('http://localhost/symfony-2.2/web/app_dev.php/demo/hello/World?p1=1&p2=2'); 
        $this->assertEquals( array('p1'=>1, 'p2' => 2) , $location->getParameters()  );
        
        $location = new UrlBasedLocation('http://localhost/symfony-2.2/web/app_dev.php/demo/hello/World?p1=1&p2=2', array( 'p1'=>5 , "p3" => 3 ) ); 
        $this->assertEquals( array('p1'=>5, 'p2' => 2, 'p3' => 3) , $location->getParameters()  );
        
        $location = new UrlBasedLocation('http://localhost/symfony-2.2/web/app_dev.php/demo/hello/World' ); 
        $this->assertEquals( array() , $location->getParameters()  );        
    }    
    
     public function testUrl()
    {
        $location = new UrlBasedLocation('http://localhost/symfony-2.2/web/app_dev.php/demo/hello/World?p1=1&p2=2'); 
        $this->assertEquals( 'http://localhost/symfony-2.2/web/app_dev.php/demo/hello/World?p1=1&p2=2' , $location->getUrl()  );
        
        $location = new UrlBasedLocation('http://localhost/symfony-2.2/web/app_dev.php/demo/hello/World?p1=1&p2=2', array( 'p1'=>5 , "p3" => 3 ) ); 
        $this->assertEquals( 'http://localhost/symfony-2.2/web/app_dev.php/demo/hello/World?p1=5&p2=2&p3=3' , $location->getUrl()  );
        
        $location = new UrlBasedLocation('http://localhost/symfony-2.2/web/app_dev.php/demo/hello/World' ); 
        $this->assertEquals( 'http://localhost/symfony-2.2/web/app_dev.php/demo/hello/World' , $location->getUrl()  );        
    }    
    
     public function testPath()
    {
        $location = new UrlBasedLocation('http://localhost/symfony-2.2/web/app_dev.php/demo/hello/World?p1=1&p2=2'); 
        $this->assertEquals( 'http://localhost/symfony-2.2/web/app_dev.php/demo/hello/World' , $location->getPath()  );
        
        $location = new UrlBasedLocation('http://localhost/symfony-2.2/web/app_dev.php/demo/hello/World?p1=1&p2=2', array( 'p1'=>5 , "p3" => 3 ) ); 
        $this->assertEquals( 'http://localhost/symfony-2.2/web/app_dev.php/demo/hello/World' , $location->getPath()  );
        
        $location = new UrlBasedLocation('http://localhost/symfony-2.2/web/app_dev.php/demo/hello/World' ); 
        $this->assertEquals( 'http://localhost/symfony-2.2/web/app_dev.php/demo/hello/World' , $location->getPath()  );        
    }    
    
}
