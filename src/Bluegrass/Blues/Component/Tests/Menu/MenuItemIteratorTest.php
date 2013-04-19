<?php

namespace Bluegrass\Blues\Component\Tests\Menu;

use Bluegrass\Blues\Component\Menu\MenuItem;
use Bluegrass\Blues\Component\Menu\MenuItemIterator;

class MenuItemIteratorTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        new MenuItemIterator(new \ArrayObject());
    }
    
    public function testIterate()
    {
        $menu = new MenuItem("home", "home", null);
        
        $n1 = $menu->addChild("n1", null);
        $n2 = $n1->addChild("n1.n1", null);
        $n3 = $n1->addChild("n1.n2", null);                
        
        $it = new \RecursiveIteratorIterator($menu->getIterator(), \RecursiveIteratorIterator::SELF_FIRST);
                        
        $it->rewind();
        
        $this->assertEquals(
            $menu,
            $it->current(),
            "Se esperaba que el primer elemento del iterador sea la raiz."
        );
        $it->next();
        $this->assertEquals(
            $n1,
            $it->current(),
            "Se esperaba que el segundo elemento del iterador sea el primer hijo de la raiz."
        );        
        $it->next();
        $this->assertEquals(
            $n2,
            $it->current(),
            "Se esperaba que el tercer elemento del iterador sea el primer hijo del primer hijo de la raiz."
        );                
        $it->next();
        $this->assertEquals(
            $n3,
            $it->current(),
            "Se esperaba que el cuarto elemento del iterador sea el segundo hijo del primer hijo de la raiz."
        );                        
        
        $it->next();
        $this->assertFalse(
            $it->valid(),
            "Se esperaba que el luego del cuarto elemento el iterador quede inválido."
        );                                
    }
    

}