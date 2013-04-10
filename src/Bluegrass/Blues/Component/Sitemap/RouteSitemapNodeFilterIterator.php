<?php

namespace Bluegrass\Blues\Component\Sitemap;

class RouteSitemapNodeFilterIterator extends \FilterIterator
{
    private $routeName;
    private $routeParams;
    
    public function __construct(SitemapIterator $iterator, $routeName, array $routeParams)
    {
        parent::__construct(new \RecursiveIteratorIterator($iterator, \RecursiveIteratorIterator::SELF_FIRST));
        
        $this->setRouteName($routeName);
        $this->setRouteParams($routeParams);
    }
    
    protected function setRouteName($value)
    {
        $this->routeName = $value;
    }
    
    protected function getRouteName()
    {
        return $this->routeName;
    }
    
    protected function setRouteParams(array $value)
    {
        $this->routeParams = $value;
    }
    
    protected function getRouteParams()
    {
        return $this->routeParams;
    }
    
    public function accept() 
    {
        $location = $this->current()->getLocation();
        $params = $this->getRouteParams();
       
        $result = $this->getRouteName() == $location->getName();
        
        foreach ($location->getParameters() as $key => $value)
        {
            $result &= isset($params[$key]) && $params[$key] == $value;
        }
        
        return $result;
    }
}

