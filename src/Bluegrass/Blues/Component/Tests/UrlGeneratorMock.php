<?php

namespace Bluegrass\Blues\Component\Tests;

use Bluegrass\Blues\Component\Model\Web\Location\RouteBasedLocation;
use Bluegrass\Blues\Component\Model\Web\Location\UrlBasedLocation;
use Bluegrass\Blues\Component\Model\Web\Location\UrlGeneratorInterface;
use Bluegrass\Blues\Component\Model\Web\Location\WebLocation;
use Exception;

class UrlGeneratorMock implements UrlGeneratorInterface
{
    public function __construct()
    {
    }
    
    /**
     * {@inheritDoc}
     */
    public function generate(WebLocation $location, $referenceType = self::ABSOLUTE_PATH) 
    {
        return $location->generateUrlWith($this, $referenceType);
    }
    
    public function generateFromUrlBasedLocation(UrlBasedLocation $location)
    {
        return $location->getUrl();
    }
    
    public function generateFromRouteBasedLocation(RouteBasedLocation $location, $referenceType = self::ABSOLUTE_PATH)
    {
        switch ($location->getName()) {
            case 'root':
                return 'root_url';
                break;
            case 'node_1':
                return 'node_1_url';
                break;
            case 'node_2':
                return 'node_2_url';
                break;
            case 'node_2_1':
                return 'node_2_1_url';
                break;
            default:
                throw new \Exception("La ruta especificada no existe.");
        }
    }    
}