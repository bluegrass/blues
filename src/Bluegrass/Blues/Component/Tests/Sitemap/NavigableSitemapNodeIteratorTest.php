<?php

namespace Bluegrass\Blues\Component\Tests\Sitemap;

use Bluegrass\Blues\Bundle\BluesBundle\Model\Web\Location\RouteBasedLocation;
use Bluegrass\Blues\Component\Sitemap\NavigableSitemapNodeIterator;
use Bluegrass\Blues\Component\Sitemap\Node;
use Bluegrass\Blues\Component\Sitemap\Sitemap;
use RecursiveIteratorIterator;

class NavigableSitemapNodeIteratorTest extends \PHPUnit_Framework_TestCase
{    
    public function testIterate()
    {
        $sitemap = new Sitemap("home", new RouteBasedLocation("test"));
        
        $n1 = $sitemap->getRoot()->addChild(new Node("n1", new RouteBasedLocation("test")));
        $n2 = $n1->addChild(new Node("n2", new RouteBasedLocation("test")));
        $n3 = $n1->addChild(new Node("n3", null));        
                        
        $it = new RecursiveIteratorIterator(new NavigableSitemapNodeIterator($sitemap->getIterator()), RecursiveIteratorIterator::SELF_FIRST);
               
        $it->rewind();
        
        $this->assertEquals(
            $sitemap->getRoot(),
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
        $this->assertFalse(
            $it->valid(),
            "Se esperaba que el luego del tercer elemento el iterador quede inválido."
        );                                
    }
    

}