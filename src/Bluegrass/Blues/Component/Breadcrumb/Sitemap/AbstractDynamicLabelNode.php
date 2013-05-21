<?php

namespace Bluegrass\Blues\Component\Breadcrumb\Sitemap;

use Bluegrass\Blues\Bundle\BluesBundle\Model\Web\Location\RouteBasedLocation;
use Bluegrass\Blues\Component\Breadcrumb\Sitemap\DynamicLabelNodeInterface;
use Bluegrass\Blues\Component\Sitemap\Node;
use Bluegrass\Blues\Component\Sitemap\NodeInterface;

/**
 * Implementación abstracta de un Nodo de Sitemap capaz de decorar a un Nodo
 * convencional y modificar la etiqueta que retorna a partir de una serie de
 * parámetros.
 */
abstract class AbstractDynamicLabelNode implements DynamicLabelNodeInterface
{
    private $node;
    private $label;
    
    public function __construct(NodeInterface $node)
    {
        $this->setNode($node);
        $this->setLabel($this->getNode()->getLabel());
    }
    
    protected function setNode(NodeInterface $value)
    {
        $this->node = $value;
    }
    
    protected function getNode()
    {
        return $this->node;
    }
    
    public function getName()
    {
        return $this->getNode()->getName();
    }
    
    public function getLocation()
    {
        return $this->getNode()->getLocation();
    }
    
    public function isNavigable()
    {
        return $this->getNode()->isNavigable();
    }
    
    protected function setLabel($value)
    {
        $this->label = $value;
    }
    
    public function getLabel()
    {
        return $this->label;
    }
    
    public function getChildren()
    {
        return $this->getNode()->getChildren();
    }
    
    public function setParent(Node $value)
    {
        $this->getNode()->setParent($value);
    }
    
    public function getParent()
    {
        return $this->getNode()->getParent();
    }
    
    public function addChild(NodeInterface $node)
    {
        return $this->getNode()->addChild($node);
    }
    
    public function hasParent()
    {
        return $this->getNode()->hasParent();
    }
    
    public function hasChildren()
    {
        return $this->getNode()->hasChildren();
    }
    
    public abstract function process(array $parameters);

}

