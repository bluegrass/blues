<?php

namespace Bluegrass\Blues\Component\Model\Web\Location;

use Bluegrass\Blues\Component\Model\Object;

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
    
    public abstract function generateUrlWith(UrlGeneratorInterface $urlGenerator, $referenceType);
    
}

