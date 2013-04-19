<?php

namespace Bluegrass\Blues\Component\Menu;

use \Bluegrass\Blues\Bundle\BluesBundle\Model\Web\Location\RouteBasedLocation;

class MenuItem
{
    private $parent;
    private $children;
    private $name;
    private $label;
    private $location;
    
    public function __construct($name, $label, RouteBasedLocation $location = null)
    {                
        $this->setLocation($location);
        $this->setLabel($label);        
        $this->setName($name);
        $this->setChildren(new \ArrayObject());
    }    

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }
    
    /**
     * Retorna el menú padre
     * 
     * @return MenuItem
     */            
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Establece el menú padre
     * 
     * @param MenuItem $parent
     */                
    public function setParent(MenuItem $parent)
    {
        $this->parent = $parent;
    }

    /**
     * Retorna la colección de hijos del nodo.
     * 
     * @return \ArrayObject 
     */        
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Establece la colección de hijos del nodo.
     * 
     * @param \ArrayObject $value
     */    
    protected function setChildren($children)
    {
        $this->children = $children;
    }
    
    public function addChild($name, $label, RouteBasedLocation $location = null)
    {
        $child = new MenuItem($name, $label, $location);
        
        $child->setParent($this);
        $this->getChildren()->append($child);
        
        return $child;
    }
    
    /**
     * @return boolean
     */
    public function hasChildren()
    {
        return $this->getChildren()->count() > 0;
    }    

    public function getLabel()
    {
        return $this->label;
    }

    public function setLabel($label)
    {
        $this->label = $label;
    }

    /**
     * 
     * @return RouteBasedLocation $location
     */        
    public function getLocation()
    {
        return $this->location;
    }

/**
     * 
     * @param RouteBasedLocation $location
     */    
    public function setLocation(RouteBasedLocation $location = null)
    {
        $this->location = $location;
    }        
    
    public function getIterator() 
    {
        $nodes = new \ArrayObject();        
        $nodes->append($this);
        return new MenuItemIterator($nodes);
    }
    
}

