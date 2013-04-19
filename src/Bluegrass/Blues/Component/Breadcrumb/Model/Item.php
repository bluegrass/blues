<?php

namespace Bluegrass\Blues\Component\Breadcrumb\Model;


class Item
{
    private $title;
    private $url;
    
    public function __construct($title, $url)
    {
        $this->title = $title;
        $this->setUrl($url);
    }    

    public function getTitle()
    {
        return $this->title;
    }

    public function setUrl($value)
    {
        $this->url = $value;
    }
    
    public function getUrl()
    {
        return $this->url;
    }    
}
