<?php

namespace Bluegrass\Blues\Component\Menu\Iterators;

use FilterIterator;

class RouteItemFilterIterator extends FilterIterator
{
    private $routeName;
    private $routeParameters;
    
    public function __construct(\Iterator $iterator, $routeName, array $routeParameters)
    {
        parent::__construct($iterator);
        
        $this->setRouteName($routeName);
        $this->setRouteParameters($routeParameters);
    }
    
    protected function setRouteName($value)
    {
        $this->routeName = $value;
    }
    
    protected function getRouteName()
    {
        return $this->routeName;
    }
    
    protected function setRouteParameters(array $value)
    {
        $this->routeParameters = $value;
    }
    
    protected function getRouteParameters()
    {
        return $this->routeParameters;
    }
    

    public function accept() 
    {
        $routeName = $this->getRouteName();
        $routeParameters = $this->getRouteParameters();
        
        $currentRouteName = $this->current()->getExtra('route', null);
        $currentRouteParameters = $this->current()->getExtra('routeParameters', array());
               
        
        if (!$currentRouteName)
            return false;
                       
        /*
         * Se compara el nombre de la ruta y los parámetros de la misma con la
         * que se está buscando. 
         */
        $accept = $currentRouteName == $routeName;
        
        foreach ($currentRouteParameters as $currentRouteParameterKey => $currentRouteParameterValue) {
            if ($accept &= isset($routeParameters[$currentRouteParameterKey])) {
                $accept &= $routeParameters[$currentRouteParameterKey] == $currentRouteParameterValue;
            }
                        
            if (!$accept)
                break;
        }
        
        return $accept;
        
    }

}
