<?php

namespace Bluegrass\Blues\Component\Menu;

class Menu implements MenuItemInterface
{
    private $children;
    
    public function __construct()
    {
        $this->setChildren( new \ArrayObject() );
    }
    
    public function getChildren()
    {
        return $this->children;
    }

    private function setChildren($children)
    {
        $this->children = $children;
    }    
    
    public function addChild( MenuItem $menuItem )
    {        
        $this->getChildren()->append( $menuItem );        
        return $this;
    }
    
    /**
     * 
     * @return \Bluegrass\Blues\Component\Menu\MenuItemIterator
     */
    public function getIterator() 
    {
        return new MenuItemIterator( $this->getChildren() );
    }        
}

