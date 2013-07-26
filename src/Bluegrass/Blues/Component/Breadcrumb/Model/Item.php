<?php

namespace Bluegrass\Blues\Component\Breadcrumb\Model;

use Bluegrass\Blues\Component\Model\Web\Location\RouteBasedLocation;


class Item
{
    private $name;
    private $title;
    private $webLocation;
    
    public function __construct($name, $title, RouteBasedLocation $location)
    {
        $this->setName($name);
        $this->setTitle($title);
        $this->setWebLocation($location);
    }    
    
    protected function setName($value)
    {
        $this->name = $value;
    }
    
    public function getName()
    {
        return $this->name;
    }
    
    protected function setTitle($value)
    {
        $this->title = $value;
    }
    
    public function getTitle()
    {
        return $this->title;
    }

    public function setWebLocation(RouteBasedLocation $value)
    {
        $this->webLocation = $value;
    }

    /**
     * 
     * @return Bluegrass\Blues\Component\Model\Web\Location\RouteBasedLocation
     */
    public function getWebLocation()
    {
        return $this->webLocation;
    }    
}
