<?php

namespace Bluegrass\Blues\Bundle\BluesBundle\Model\Web\Location;

/**
 *
 * @author ldelia
 */
class RouteBasedLocation extends WebLocation
{
    private $name;
    
    public function __construct( $name, $parameters = array() )
    {
        $this->setName($name);
        $this->setParameters($parameters);
    }
    
    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function equals($object)
    {        
        $result = ( get_class($this) == get_class($object) ) && ($this->getName() == $object->getName());
        
        $params = $this->getParameters();
        
        foreach ($object->getParameters() as $key => $value)
        {
            $result &= isset($params[$key]) && $params[$key] == $value;
        }
        
        return $result;        
    }

    public function generateUrlWith(UrlGeneratorInterface $urlGenerator, $referenceType) {
        return $urlGenerator->generateFromRouteBasedLocation($this, $referenceType);
    }
}

