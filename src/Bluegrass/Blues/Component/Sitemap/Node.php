<?php

namespace Bluegrass\Blues\Component\Sitemap;

use \Bluegrass\Blues\Bundle\BluesBundle\Model\Web\Location\RouteBasedLocation;

/**
 * Description of Node
 *
 * @author gcaseres
 */
class Node 
{
    private $parent;
    private $children;
    private $label;
    private $navigable;
    private $location;
    
    public function __construct($label, RouteBasedLocation $location = null, $navigable = true)
    {                
        if ($location == null)
            $navigable = false;
        
        $this->setNavigable(false);
        $this->setLocation($location);
        $this->setNavigable($navigable);
        $this->setLabel($label);        
        $this->setChildren(new \ArrayObject());
    }
    
    /**
     * 
     * @param \Bluegrass\Blues\Bundle\BluesBundle\Model\Web\Location\RouteBasedLocation $value
     */
    protected function setLocation(RouteBasedLocation $value = null)
    {
        if ($value == null && $this->isNavigable())
            throw new \InvalidArgumentException("Un nodo sin location no puede ser navegable.");
        
        $this->location = $value;
    }
    
    /**
     * 
     * @return \Bluegrass\Blues\Bundle\BluesBundle\Model\Web\Location\WebLocation
     */
    public function getLocation()
    {
        return $this->location;
    }
    
    protected function setNavigable($value)
    {
        if ($value && $this->getLocation() == null)
            throw new \InvalidArgumentException("Un nodo sin location no puede ser navegable.");
        
        $this->navigable = $value;
    }
    
    public function isNavigable()
    {
        return $this->navigable;
    }
    
    protected function setLabel($value)
    {
        if ($value == null)
        {
            throw new \InvalidArgumentException("El label debe contener una cadena válida.");
        }
        
        $this->label = $value;
    }
    
    public function getLabel()
    {
        return $this->label;
    }
    
    /**
     * Establece la colección de hijos del nodo.
     * 
     * @param \ArrayObject $value
     */
    protected function setChildren(\ArrayObject $value)
    {
        $this->children = $value;
    }
    
    /**
     * Obtiene un iterable de hijos de solo lectura.
     * 
     * @return \IteratorAggregate 
     */
    public function getChildren()
    {
        return $this->getChildrenCollection()->getIterator();
    }

    /**
     * Obtiene la colección interna de hijos del nodo.
     * 
     * @return \ArrayObject
     */    
    protected function getChildrenCollection()
    {
        return $this->children;
    }
    
    /**
     * 
     * @param \Bluegrass\Blues\Component\Sitemap\Node $value
     */
    public function setParent(Node $value)
    {
        $this->parent = $value;
    }
    
    /**
     * 
     * @return \Bluegrass\Blues\Component\Sitemap\Node
     */
    public function getParent()
    {
        return $this->parent;
    }
    
    public function addChild($label, RouteBasedLocation $location = null, $navigable = true)
    {
        $child = new Node($label, $location, $navigable);
        
        $child->setParent($this);
        $this->getChildrenCollection()->append($child);
        
        return $child;
    }
    
    public function hasChildren()
    {
        return $this->getChildrenCollection()->count() > 0;
    }
    
}
