<?php

namespace Bluegrass\Blues\Bundle\BluesBundle\Tests\Model\Web\Location;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UrlBasedLocationTest extends WebTestCase
{
    public function testParameters()
    {
        $location = new \Bluegrass\Blues\Bundle\BluesBundle\Model\Web\Location\UrlBasedLocation('http://localhost/symfony-2.2/web/app_dev.php/demo/hello/World?p1=1&p2=2'); 
        $this->assertEquals( array('p1'=>1, 'p2' => 2) , $location->getParameters()  );
        
        $location = new \Bluegrass\Blues\Bundle\BluesBundle\Model\Web\Location\UrlBasedLocation('http://localhost/symfony-2.2/web/app_dev.php/demo/hello/World?p1=1&p2=2', array( 'p1'=>5 , "p3" => 3 ) ); 
        $this->assertEquals( array('p1'=>5, 'p2' => 2, 'p3' => 3) , $location->getParameters()  );
        
        $location = new \Bluegrass\Blues\Bundle\BluesBundle\Model\Web\Location\UrlBasedLocation('http://localhost/symfony-2.2/web/app_dev.php/demo/hello/World' ); 
        $this->assertEquals( array() , $location->getParameters()  );        
    }    
    
     public function testUrl()
    {
        $location = new \Bluegrass\Blues\Bundle\BluesBundle\Model\Web\Location\UrlBasedLocation('http://localhost/symfony-2.2/web/app_dev.php/demo/hello/World?p1=1&p2=2'); 
        $this->assertEquals( 'http://localhost/symfony-2.2/web/app_dev.php/demo/hello/World?p1=1&p2=2' , $location->getUrl()  );
        
        $location = new \Bluegrass\Blues\Bundle\BluesBundle\Model\Web\Location\UrlBasedLocation('http://localhost/symfony-2.2/web/app_dev.php/demo/hello/World?p1=1&p2=2', array( 'p1'=>5 , "p3" => 3 ) ); 
        $this->assertEquals( 'http://localhost/symfony-2.2/web/app_dev.php/demo/hello/World?p1=5&p2=2&p3=3' , $location->getUrl()  );
        
        $location = new \Bluegrass\Blues\Bundle\BluesBundle\Model\Web\Location\UrlBasedLocation('http://localhost/symfony-2.2/web/app_dev.php/demo/hello/World' ); 
        $this->assertEquals( 'http://localhost/symfony-2.2/web/app_dev.php/demo/hello/World' , $location->getUrl()  );        
    }    
    
     public function testPath()
    {
        $location = new \Bluegrass\Blues\Bundle\BluesBundle\Model\Web\Location\UrlBasedLocation('http://localhost/symfony-2.2/web/app_dev.php/demo/hello/World?p1=1&p2=2'); 
        $this->assertEquals( 'http://localhost/symfony-2.2/web/app_dev.php/demo/hello/World' , $location->getPath()  );
        
        $location = new \Bluegrass\Blues\Bundle\BluesBundle\Model\Web\Location\UrlBasedLocation('http://localhost/symfony-2.2/web/app_dev.php/demo/hello/World?p1=1&p2=2', array( 'p1'=>5 , "p3" => 3 ) ); 
        $this->assertEquals( 'http://localhost/symfony-2.2/web/app_dev.php/demo/hello/World' , $location->getPath()  );
        
        $location = new \Bluegrass\Blues\Bundle\BluesBundle\Model\Web\Location\UrlBasedLocation('http://localhost/symfony-2.2/web/app_dev.php/demo/hello/World' ); 
        $this->assertEquals( 'http://localhost/symfony-2.2/web/app_dev.php/demo/hello/World' , $location->getPath()  );        
    }    
    
}
