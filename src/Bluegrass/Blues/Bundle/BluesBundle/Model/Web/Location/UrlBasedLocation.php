<?php

namespace Bluegrass\Blues\Bundle\BluesBundle\Model\Web\Location;

/**
 *
 * @author ldelia
 */
class UrlBasedLocation extends WebLocation
{

    private $path;

    public function __construct($url, $parameters = array())
    {
        if (false === strpos($url, '?')) {
            $this->setPath($url);
        } else {
            $this->setPath(substr($url, 0, strpos($url, '?')));
        }
        $this->setParameters(array_merge($this->getQueryStringArray($url), $parameters));
    }

    public function getUrl()
    {
        if ($this->getParameters()) {
            return $this->getPath() . "?" . http_build_query($this->getParameters());
        } else {
            return $this->getPath();
        }
    }

    public function getPath()
    {
        return $this->path;
    }

    protected function setPath($path)
    {
        $this->path = $path;
    }

    protected function getQueryStringArray($url)
    {
        $result = array();

        //string must contain at least one = and cannot be in first position
        if (strpos($url, '=')) {
            
            if (strpos($url, '?') !== false) {
                $q = parse_url($url);
                foreach (explode('&', $q['query']) as $couple) {
                    list ($key, $val) = explode('=', $couple);
                    $result[$key] = \urldecode($val);
                }
                return empty($result) ? array() : $result;
            }
        } else {
            return array();
        }
    }

    public function generateUrlWith(UrlGeneratorInterface $urlGenerator, $referenceType)
    {
        return $urlGenerator->generateFromUrlBasedLocation($this);
    }

}

