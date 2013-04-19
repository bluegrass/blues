<?php

namespace Bluegrass\Blues\Component\Menu;

/**
 * Description of MenuItemIterator
 *
 */
class MenuItemIterator implements \RecursiveIterator
{
    private $nodeList;
    private $position;    
    
    public function __construct(\ArrayAccess $nodes)
    {
        $this->setNodeList($nodes);
        $this->setPosition(0);        
    }
    
    protected function setNodeList(\ArrayAccess $value)
    {
        $this->nodeList = $value;
    }
    
    protected function getNodeList()
    {
        return $this->nodeList;
    }
    
    protected function setPosition($value)
    {
        $this->position = $value;
    }
    
    protected function getPosition()
    {
        return $this->position;
    }

    public function current() 
    {
        return $this->getNodeList()->offsetGet($this->getPosition());
    }

    public function key() 
    {
        return $this->getPosition();
    }

    public function next() 
    {
        $this->setPosition($this->getPosition() + 1);
    }

    public function rewind() 
    {
        $this->setPosition(0);
    }

    public function valid()
    {
        return $this->getPosition() < $this->getNodeList()->count();
    }

    public function getChildren() 
    {
        return new self(new \ArrayObject($this->current()->getChildren()));
    }

    public function hasChildren() 
    {
        return $this->current()->hasChildren();
    }

}
