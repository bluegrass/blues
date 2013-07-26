<?php

namespace Bluegrass\Blues\Component\Tests\Sitemap;

use Bluegrass\Blues\Component\Sitemap\Node;

use Bluegrass\Blues\Component\Model\Web\Location\RouteBasedLocation;

class NodeTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        new Node("h-1","home", new RouteBasedLocation("test"));
        
        new Node("h-1","home", null);
    }
    
    public function testAddChild()
    {
        $home = new Node("h-1","home", null);
        
        $child = $home->addChild(new Node("h-1-1","home child", null));
        
        $this->assertEquals(
            $home,        
            $child->getParent(),
            "Se esperaba que el parent del hijo agregado esté asignado al home."
        );
    }
    
    public function testHasChildren()
    {
        $n1 = new Node( "h-1", "n1", null);
        $n2 = $n1->addChild( new Node( "h-1-1", "n2", null ) );
        
        $this->assertTrue(
            $n1->hasChildren(),
            "Se esperaba que el nodo contenga hijos."
        );
        
        $n1 = new Node( "h-1", "n1", null);
        
        $this->assertFalse(
            $n1->hasChildren(),
            "Se esperaba que el nodo no contenga hijos."
        );        
    }

}