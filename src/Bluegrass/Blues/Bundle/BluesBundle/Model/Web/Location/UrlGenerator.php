<?php

namespace Bluegrass\Blues\Bundle\BluesBundle\Model\Web\Location;

class UrlGenerator implements UrlGeneratorInterface
{
    private $routeUrlGenerator;
    
    /**
     * 
     * @param \Bluegrass\Blues\Bundle\BluesBundle\Model\Web\Location\Symfony\Component\Routing\Generator\UrlGeneratorInterface $value
     */
    protected function setRouteUrlGenerator(Symfony\Component\Routing\Generator\UrlGeneratorInterface $value)
    {
        $this->routeUrlGenerator = $value;
    }
    
    /**
     * 
     * @return Symfony\Component\Routing\Generator\UrlGeneratorInterface
     */
    protected function getRouteUrlGenerator()
    {
        return $this->routeUrlGenerator;
    }

    /**
     * 
     * @param \Bluegrass\Blues\Bundle\BluesBundle\Model\Web\Location\Symfony\Component\Routing\Generator\UrlGeneratorInterface $routeUrlGenerator
     */
    public function __construct(Symfony\Component\Routing\Generator\UrlGeneratorInterface $routeUrlGenerator)
    {
        $this->setRouteUrlGenerator($routeUrlGenerator);
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
        return $this->getRouteUrlGenerator()->generate($location->getName(), $location->getParameters(), $referenceType);
    }    
}