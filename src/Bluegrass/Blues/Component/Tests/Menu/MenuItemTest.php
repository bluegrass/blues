<?php

namespace Bluegrass\Blues\Component\Tests\Menu;

use Bluegrass\Blues\Component\Menu\MenuItem;

use Bluegrass\Blues\Bundle\BluesBundle\Model\Web\Location\RouteBasedLocation;

class MenuItemTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        new MenuItem("home", "Home", new RouteBasedLocation("test"));
        
        new MenuItem("home",  "Home", null);
    }
    
    public function testAddChild()
    {
        $home = new MenuItem("home", "Home", null);        
        $child = $home->addChild("people", "Personas", null);
        
        $this->assertEquals(
            $home,        
            $child->getParent(),
            "Se esperaba que el parent del hijo agregado esté asignado al home."
        );
    }
    
    public function testHasChildren()
    {
        $n1 = new MenuItem("n1", "n1", null);
        $n2 = $n1->addChild("n2", "n2", null);
        
        $this->assertTrue(
            $n1->hasChildren(),
            "Se esperaba que el nodo contenga hijos."
        );
        
        $n1 = new MenuItem("n1", "n1", null);
        
        $this->assertFalse(
            $n1->hasChildren(),
            "Se esperaba que el nodo no contenga hijos."
        );        
    }

}