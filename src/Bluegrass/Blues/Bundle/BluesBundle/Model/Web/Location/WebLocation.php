<?php

namespace Bluegrass\Blues\Bundle\BluesBundle\Model\Web\Location;

use Bluegrass\Blues\Bundle\BluesBundle\Model\Object;
/**
 *
 * @author ldelia
 */
abstract class WebLocation extends Object
{
    private $parameters;
    
    public function getParameters()
    {
        return $this->parameters;
    }

    public function setParameters($parameters)
    {
        $this->parameters = $parameters;
    }    
    
    
}

