<?php

namespace Bluegrass\Blues\Component\Sitemap;

use \Bluegrass\Blues\Bundle\BluesBundle\Model\Web\Location\RouteBasedLocation;

/**
 * Description of Sitemap
 *
 * @author gcaseres
 */
class Sitemap implements \IteratorAggregate 
{
    private $root;
    
    public function __construct($rootName, $rootLabel, RouteBasedLocation $rootLocation = null, $rootNavigable = true)
    {
        $this->setRoot(new Node($rootName, $rootLabel, $rootLocation, $rootNavigable));
    }
    
    /**
     * 
     * @param Node $value
     */
    protected function setRoot(Node $value)
    {
        $this->root = $value;
    }
    
    /**
     * 
     * @return Node
     */
    public function getRoot()
    {
        return $this->root;
    }

    /**
     * 
     * @return SitemapIterator
     */
    public function getIterator() 
    {
        $nodes = new \ArrayObject();        
        $nodes->append($this->getRoot());
        return new SitemapIterator($nodes);
    }
}


