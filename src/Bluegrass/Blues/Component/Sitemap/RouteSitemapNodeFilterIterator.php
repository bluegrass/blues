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
        
        if ($currentLocation) {
            /*
             * Se acepta si los parámetros del current existen en la location
             * de comparación y contienen los mismos valores.
             * 
             * La location de comparación podría tener mas parámetros, sin 
             * embargo los mismos se ignoran.
             * 
             */
            if ($currentLocation->getName() == $this->getLocation()->getName() )
            {
                $result = true;
                $params = $this->getLocation()->getParameters();
                foreach ($currentLocation->getParameters() as $key => $value)
                {
                    $result &= isset($params[$key]) && ($params[$key] == $value);
                }
                
                return $result;
            } else {
                return false;
            }
            
        }else{
            return false;
        }
    }
}

