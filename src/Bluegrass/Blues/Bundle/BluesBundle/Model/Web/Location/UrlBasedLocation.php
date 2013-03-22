<?php

namespace Bluegrass\Blues\Bundle\BluesBundle\Model\Web\Location;

/**
 *
 * @author ldelia
 */
class UrlBasedLocation extends WebLocation
{

    private $url;

    public function __construct($url, $parameters = array())
    {                        
        $this->setUrl($url);
        $this->setParameters( array_merge( $this->getQueryStringArray($url) , $parameters   ) );
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($url)
    {
        $this->url = $this->getPath( $url );
    }

    public function generateUrlWith(UrlGeneratorInterface $urlGenerator, $referenceType)
    {
        return $urlGenerator->generateFromUrlBasedLocation($this);
    }

    protected function getPath( $url )
    {            
        return substr( $url, 0, strpos( $url, '?' ) );
    }

    protected function getQueryStringArray($url)
    {
        $result = array();
        
        //string must contain at least one = and cannot be in first position
        if (strpos($url, '=')) {
            if (strpos($url, '?') !== false) {
                $q = parse_url($url);
                $qry = $q['query'];
            }
        } else {
            return array();
        }

        foreach (explode('&', $qry) as $couple) {
            list ($key, $val) = explode('=', $couple);
            $result[$key] = $val;
        }
        return empty($result) ? array() : $result;
    }

}

