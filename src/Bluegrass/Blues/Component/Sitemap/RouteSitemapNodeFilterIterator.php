<?php

namespace Bluegrass\Blues\Component\Sitemap;

use Bluegrass\Blues\Bundle\BluesBundle\Model\Web\Location\RouteBasedLocation;

class RouteSitemapNodeFilterIterator extends \FilterIterator
{
    private $location;
    
    public function __construct(SitemapIterator $iterator, RouteBasedLocation $location)
    {
        parent::__construct(new \RecursiveIteratorIterator($iterator, \RecursiveIteratorIterator::SELF_FIRST));
        
        $this->setLocation($location);
    }

    /**
     * 
     * @return RouteBasedLocation
     */
    public function getLocation()
    {
        return $this->location;
    }

    public function setLocation(RouteBasedLocation $location)
    {
        $this->location = $location;
    }
    
    public function accept() 
    {
        $currentLocation = $this->current()->getLocation();
        
        if ( $currentLocation ){
            return $currentLocation->equals( $this->getLocation() );    
        }else{
            return false;
        }
    }
}

