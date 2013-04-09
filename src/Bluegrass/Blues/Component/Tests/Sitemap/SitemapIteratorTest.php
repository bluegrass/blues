<?php

namespace Bluegrass\Blues\Component\Tests\Sitemap;

use Bluegrass\Blues\Component\Sitemap\Sitemap;
use Bluegrass\Blues\Component\Sitemap\Node;
use Bluegrass\Blues\Component\Sitemap\SitemapIterator;

class SitemapIteratorTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        new SitemapIterator(new \ArrayObject());
    }
    
    public function testIterate()
    {
        $sitemap = new Sitemap("home", null);
        
        $n1 = $sitemap->getRoot()->addChild("n1", null);
        $n2 = $n1->addChild("n2", null);
        $n3 = $n1->addChild("n3", null);        
        
        
        $it = new \RecursiveIteratorIterator($sitemap->getIterator(), \RecursiveIteratorIterator::SELF_FIRST);
                        
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