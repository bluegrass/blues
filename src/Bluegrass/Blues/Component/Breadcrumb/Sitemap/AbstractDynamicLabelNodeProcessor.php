<?php

namespace Bluegrass\Blues\Component\Breadcrumb\Sitemap;

use Bluegrass\Blues\Component\Breadcrumb\Sitemap\DynamicLabelNodeInterface;
use Bluegrass\Blues\Component\Patterns\Visitor\AbstractDynamicVisitor;
use Bluegrass\Blues\Component\Sitemap\NodeInterface;
use ReflectionClass;
use ReflectionMethod;

/**
 * Se encarga de procesar un nodo solo si es un DynamicLabelNode.
 *
 * @author gcaseres
 */
abstract class AbstractDynamicLabelNodeProcessor extends AbstractDynamicVisitor
{
    public function __construct()
    {
        parent::__construct();
        
        $this->setVisitHandler(
                new ReflectionClass('Bluegrass\\Blues\\Component\\Breadcrumb\\Sitemap\\DynamicLabelNodeInterface'),
                new ReflectionMethod($this, 'visitDynamicLabelNode')
        );
        $this->setVisitHandler(
                new ReflectionClass('Bluegrass\\Blues\\Component\\Sitemap\\NodeInterface'),
                new ReflectionMethod($this, 'visitStaticLabelNode')
        );        
    }
    
    public function process(NodeInterface $node)
    {
        $this->visit($node);
    }
    
    public function visitDynamicLabelNode(DynamicLabelNodeInterface $node)
    {
       $this->processDynamicNode($node);
    }
    
    public function visitStaticLabelNode(NodeInterface $node)
    {
        
    }
    
    protected abstract function processDynamicNode(DynamicLabelNodeInterface $node);

}

