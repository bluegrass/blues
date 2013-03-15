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
        return ( $this == $object ) && ($this->getName() == $object->getName());
    }
}

