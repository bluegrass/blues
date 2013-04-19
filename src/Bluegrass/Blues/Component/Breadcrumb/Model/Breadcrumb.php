<?php

namespace Bluegrass\Blues\Component\Breadcrumb\Model;


use \Countable;
use \IteratorAggregate;

class Breadcrumb implements Countable, IteratorAggregate
{
    private $trail;
        
    public function __construct()
    {
        $this->setTrailCollection(new \ArrayObject());
    }           

    /**
     * 
     * @return \ArrayObject
     */
    protected function getTrailCollection()
    {      
        return $this->trail;
    }   
    
    protected function setTrailCollection(\ArrayObject $value)
    {
        $this->trail = $value;
    }

    /**
     * Agrega un item al Breadcrumb.
     * 
     * @param \Bluegrass\Blues\Component\Breadcrumb\Model\Item $item
     */
    public function add(Item $item)
    {   
        $this->getTrailCollection()->append($item);
    }    
    

    /**
     * Obtiene un elemento del Breadcrumb.
     * 
     * @return Item
     */
    public function get($key)
    {
        return $this->getTrailCollection()->offsetGet($key);
    }        
       
    /**
     * Obtiene la cantidad de items que contiene el Breadcrumb.
     * 
     * @see Countable::count()
     * @return int Cantidad de items en el Breadcrumb.
     */
    public function count()
    {
        return $this->getTrailCollection()->count();
    }    

    
    /**
     * Obtiene los items del breadcrumb previos al item especificado.
     * El item especificado debe haberse obtenido del breadcrumb.
     * 
     * @param \Bluegrass\Blues\Component\Breadcrumb\Model\Item $item
     * @return array Colección de items previos al especificado.     
     * 
     * @throws \Exception Si el item especificado no pertenece al breadcrumb.
     */
    public function getTrailFor(Item $item)
    {
        $found = false;
        $result = array();
        foreach($this->getTrailCollection() as $trailItem) {            
            if ($item === $trailItem) {
                $found = true;
                break;
            }
            $result[] = $trailItem;
        }
        
        if (!$found)
            throw new \Exception("El item especificado no pertenece al breadcrumb.");
        
        return $result;
    }

    
    public function getIterator() 
    {
        return $this->getTrailCollection()->getIterator();
    }
    
}