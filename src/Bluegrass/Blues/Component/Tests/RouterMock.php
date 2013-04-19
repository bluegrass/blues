<?php

namespace Bluegrass\Blues\Component\Tests;

use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\RouterInterface;

/**
 *
 * @author gcaseres
 */
class RouterMock implements RouterInterface
{
    private $routeCollection;
    private $context;
    
    public function __construct()
    {
        $this->setRouteCollection(new RouteCollection());
        $this->getRouteCollection()->add("root", new Route('/root'));
        $this->getRouteCollection()->add("node_1", new Route('/root/node_1'));
        $this->getRouteCollection()->add("node_2", new Route('/root/node_2/{param_1}'));
        $this->getRouteCollection()->add("node_2_1", new Route('/root/node_2/node_1/{param_1}'));        
    }
    
    protected function setRouteCollection(RouteCollection $value)
    {
        $this->routeCollection = $value;
    }
    
    public function generate($name, $parameters = array(), $referenceType = self::ABSOLUTE_PATH) {
        
    }

    public function getContext()
    {
        return $this->context;
    }

    /**
     * 
     * @return RouteCollection
     */
    public function getRouteCollection() 
    {
        return $this->routeCollection;
    }

    public function match($pathinfo) 
    {
        $matcher = new UrlMatcher($this->getRouteCollection(), $this->getContext());
        return $matcher->match($pathinfo);
    }

    public function setContext(RequestContext $context) {
        $this->context = $context;
    }
}
