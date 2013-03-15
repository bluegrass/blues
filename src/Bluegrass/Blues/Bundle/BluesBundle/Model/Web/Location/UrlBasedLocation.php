<?php

namespace Bluegrass\Blues\Bundle\BluesBundle\Model\Web\Location;

/**
 *
 * @author ldelia
 */
class UrlBasedLocation extends WebLocation
{
    private $url;

    public function __construct( $url, $parameters = array() )
    {
        $this->setUrl($url);
        $this->setParameters($parameters);
    }
   
    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }

    public function generateUrlWith(UrlGeneratorInterface $urlGenerator, $referenceType) {
        return $urlGenerator->generateFromUrlBasedLocation($this);
    }

   
}

