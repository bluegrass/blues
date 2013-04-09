<?php

namespace Bluegrass\Blues\Component\Tests\Sitemap;

use Bluegrass\Blues\Component\Sitemap\Node;

use Bluegrass\Blues\Bundle\BluesBundle\Model\Web\Location\UrlBasedLocation;

class NodeTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        new Node("home", new UrlBasedLocation("test"));
        
        new Node("home", null);
    }
    
    public function testAddChild()
    {
        $home = new Node("home", null);
        
        $child = $home->addChild(new Node("home", null));
        
        $this->assertEquals(
            $home,        
            $child->getParent(),
            "Se esperaba que el parent del hijo agregado esté asignado al home."
        );
    }
    
    public function testHasChildren()
    {
        $n1 = new Node("n1", null);
        $n2 = $n1->addChild("n2", null);
        
        $this->assertTrue(
            $n1->hasChildren(),
            "Se esperaba que el nodo contenga hijos."
        );
        
        $n1 = new Node("n1", null);
        
        $this->assertFalse(
            $n1->hasChildren(),
            "Se esperaba que el nodo no contenga hijos."
        );        
    }

}