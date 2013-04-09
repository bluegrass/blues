<?php


namespace Bluegrass\Blues\Component\Sitemap;

class NavigableSitemapNodeIterator extends \RecursiveFilterIterator
{
    public function __construct (SitemapIterator $iterator)
    {
        parent::__construct($iterator);
    }
    
    public function accept() 
    {
        return $this->current()->isNavigable();
    }
}

