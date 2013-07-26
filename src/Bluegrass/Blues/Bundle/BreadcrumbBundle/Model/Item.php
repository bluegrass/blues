<?php

namespace Bluegrass\Blues\Bundle\BreadcrumbBundle\Model;

use Bluegrass\Blues\Component\Model\Web\Location\WebLocation;

class Item
{
    private $title;
    private $webLocation;
    
    public function __construct($title, WebLocation $webLocation)
    {
        $this->title = $title;
        $this->webLocation = $webLocation;
    }    

    public function getTitle()
    {
        return $this->title;
    }

    public function getWebLocation()
    {
        return $this->webLocation;
    }    
}
